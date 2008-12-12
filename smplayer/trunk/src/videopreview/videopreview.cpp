/*  smplayer, GUI front-end for mplayer.
    Copyright (C) 2006-2008 Ricardo Villalba <rvm@escomposlinux.org>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

#include "videopreview.h"
#include <QProcess>
#include <QRegExp>
#include <QDir>
#include <QTime>
#include <QProgressDialog>
#include <QWidget>
#include <QGridLayout>
#include <QLabel>
#include <QScrollArea>
#include <QDialogButtonBox>
#include <QPushButton>
#include <QPainter>
#include <QFileDialog>
#include <QMessageBox>
#include <QApplication>

VideoPreview::VideoPreview(QString mplayer_path, QWidget * parent, Qt::WindowFlags f) : QWidget(parent, f)
{
	mplayer_bin = mplayer_path;

	input_video.clear();
	n_cols = 3;
	n_rows = 4;
	initial_step = 20;
	max_width = 800;
	aspect_ratio = 0;
	display_osd = false;

	output_dir = "smplayer_preview";
	full_output_dir = QDir::tempPath() +"/"+ output_dir;

	progress = new QProgressDialog(this);
	progress->setCancelButtonText( tr("Cancel") );
	connect( progress, SIGNAL(canceled()), this, SLOT(cancelPressed()) );

	w_contents = new QWidget(this);

	info = new QLabel(this);

	foot = new QLabel(this);
	foot->setAlignment(Qt::AlignRight);
	foot->setText("<i>"+ tr("Generated by SMPlayer") +" (http://smplayer.sf.net)</i>");

	grid_layout = new QGridLayout;
	grid_layout->setSpacing(2);

	QVBoxLayout * l = new QVBoxLayout;
	l->setSizeConstraint(QLayout::SetFixedSize);
	l->addWidget(info);
	l->addLayout(grid_layout);
	l->addWidget(foot);
	
	w_contents->setLayout(l);

	QScrollArea * scroll_area = new QScrollArea(this);
	scroll_area->setWidgetResizable(true);
	scroll_area->setWidget( w_contents );

	QDialogButtonBox * button_box = new QDialogButtonBox(QDialogButtonBox::Close | QDialogButtonBox::Save, Qt::Horizontal, this);
	connect( button_box, SIGNAL(rejected()), this, SLOT(close()) );
	connect( button_box->button(QDialogButtonBox::Save), SIGNAL(clicked()), this, SLOT(saveImage()) );

	QVBoxLayout * my_layout = new QVBoxLayout;
	my_layout->addWidget(scroll_area);
	my_layout->addWidget(button_box);
	setLayout(my_layout);	
}

VideoPreview::~VideoPreview() {
}

bool VideoPreview::createThumbnails() {
	bool result = extractImages();

	cleanDir(full_output_dir);
	return result;
}

bool VideoPreview::extractImages() {
	VideoInfo i = getInfo(mplayer_bin, input_video);
	int length = i.length;

	if (length == 0) return false;

	// Create a temporary directory
	QDir d(QDir::tempPath());
	if (!d.exists(output_dir)) {
		if (!d.mkpath(output_dir)) {
			qDebug("VideoPreview::extractImages: error: can't create '%s'", full_output_dir.toUtf8().constData());
			return false;
		}
	}

	thumbnail_width = 0;

	int num_pictures = n_cols * n_rows;
	length -= initial_step;
	int s_step = length / num_pictures;

	int current_time = initial_step;

	canceled = false;
	progress->setLabelText(tr("Creating thumbnails..."));
	progress->setRange(1, num_pictures);

	int current_col = 0;
	int current_row = 0;
	for (int n=1; n <= num_pictures; n++) {
		qDebug("VideoPreview::extractImages: getting frame %d of %d...", n, num_pictures);
		progress->setValue(n);
		qApp->processEvents();

		if (canceled) return false;

		QStringList args;
		args << "-nosound" << "-vo" << "jpeg:outdir="+full_output_dir << "-frames" << "6"
             << "-ss" << QString::number(current_time);

		if (aspect_ratio != 0) {
			args << "-aspect" << QString::number(aspect_ratio) << "-zoom";
		}

		/*
		if (display_osd) {
			args << "-vf" << "expand=osd=1" << "-osdlevel" << "2";
		}
		*/

		args << input_video;

		QString command = mplayer_bin + " ";
		for (int n = 0; n < args.count(); n++) command = command + args[n] + " ";
		qDebug("VideoPreview::extractImages: command: %s", command.toUtf8().constData());

		QProcess p;
		p.start(mplayer_bin, args);
		if (!p.waitForFinished()) {
			qDebug("VideoPreview::extractImages: error running process");
			return false;
		}

		QString output_file = output_dir + QString("/picture_%1.jpg").arg(current_time, 8, 10, QLatin1Char('0'));
		d.rename(output_dir + "/00000005.jpg", output_file);

		addPicture(QDir::tempPath() +"/"+ output_file, current_row, current_col, current_time);
		current_col++;
		if (current_col >= n_cols) { current_col = 0; current_row++; }

		current_time += s_step;
	}

	QTime t = QTime().addSecs(i.length);
	info->setText(
		"<b>" +	
		tr("File: %1").arg(i.filename) + "<br>" +
		tr("Size: %1 MB").arg(i.size / (1024*1024)) + "<br>" +
		tr("Resolution: %1 x %2").arg(i.width).arg(i.height) + "<br>" +
		tr("Length: %1").arg(t.toString("hh:mm:ss")) + 
		"</b>"
	);

	return true;
}

void VideoPreview::addPicture(const QString & filename, int row, int col, int time) {
	//qDebug("VideoPreview::addPicture: %d %d", row, col);

	QPixmap picture(filename);

	if (thumbnail_width == 0) {
		int spacing = grid_layout->horizontalSpacing() * (n_cols-1);
		if (spacing < 0) spacing = 0;
		qDebug("VideoPreview::addPicture: spacing: %d", spacing);
		thumbnail_width = (max_width - spacing) / n_cols;
		if (thumbnail_width > picture.width()) thumbnail_width = picture.width();
		qDebug("VideoPreview::addPicture: thumbnail_width set to %d", thumbnail_width);
	}

	QPixmap scaled_picture = picture.scaledToWidth(thumbnail_width, Qt::SmoothTransformation);

	// Add current time text
	if (display_osd) {
		QString stime = QTime().addSecs(time).toString("hh:mm:ss");
		QFont font("Arial");
		font.setBold(true);
		QPainter painter(&scaled_picture);
		painter.setPen( Qt::white );
		painter.setFont(font);
		painter.drawText(scaled_picture.rect(), Qt::AlignRight | Qt::AlignBottom, stime);
	}

	QLabel * l = new QLabel(this);
	l->setPixmap(scaled_picture);
	//l->setPixmap(picture);
	grid_layout->addWidget(l, row, col);
}

void VideoPreview::cleanDir(QString directory) {
	QDir d(directory);
	QStringList l = d.entryList( QStringList() << "*.jpg", QDir::Files, QDir::Unsorted);

	for (int n = 0; n < l.count(); n++) {
		qDebug("VideoPreview::cleanDir: deleting '%s'", l[n].toUtf8().constData());
		d.remove(l[n]);
	}
	qDebug("VideoPreview::cleanDir: removing directory '%s'", directory.toUtf8().constData());
	d.rmpath(directory);
}

VideoInfo VideoPreview::getInfo(const QString & mplayer_path, const QString & filename) {
	VideoInfo i;

	if (filename.isEmpty()) return i;

	QFileInfo fi(filename);
	if (fi.exists()) {
		i.filename = fi.fileName();
		i.size = fi.size();
	}

	QRegExp rx("^ID_(.*)=(.*)");

	QProcess p;
	p.setProcessChannelMode( QProcess::MergedChannels );

	QStringList args;
	args << "-vo" << "null" << "-ao" << "null" << "-frames" << "1" << "-identify" << "-nocache" << "-noquiet" << filename;
	p.start(mplayer_path, args);

	if (p.waitForFinished()) {
		QByteArray line;
		while (p.canReadLine()) {
			line = p.readLine().trimmed();
			qDebug("VideoPreview::getInfo: '%s'", line.constData());
			if (rx.indexIn(line) > -1) {
				QString tag = rx.cap(1);
				QString value = rx.cap(2);
				qDebug("VideoPreview::getInfo: tag: '%s', value: '%s'", tag.toUtf8().constData(), value.toUtf8().constData());

				if (tag == "LENGTH") i.length = (int) value.toDouble();
				else
				if (tag == "VIDEO_WIDTH") i.width = value.toInt();
				else
				if (tag == "VIDEO_HEIGHT") i.height = value.toInt();
			}
		}
	} else {
		qDebug("VideoPreview::getInfo: error: process didn't start");
	}

	qDebug("VideoPreview::getInfo: filename: '%s'", i.filename.toUtf8().constData());
	qDebug("VideoPreview::getInfo: resolution: '%d x %d'", i.width, i.height);
	qDebug("VideoPreview::getInfo: length: '%d'", i.length);
	qDebug("VideoPreview::getInfo: size: '%d'", (int) i.size);

	return i;
}

void VideoPreview::cancelPressed() {
	canceled = true;
}

void VideoPreview::saveImage() {
	qDebug("VideoPreview::saveImage");

	QString filename = QFileDialog::getSaveFileName(this, tr("Save file"),
                            last_directory, tr("Images (*.png *.jpg)"));

	if (!filename.isEmpty()) {
		QPixmap image = QPixmap::grabWidget(w_contents);
		if (!image.save(filename)) {
			// Failed!!!
			qDebug("VideoPreview::saveImage: error saving '%s'", filename.toUtf8().constData());
			QMessageBox::warning(this, tr("Error saving file"), 
                                 tr("The file couldn't be saved") );
		} else {
			last_directory = QFileInfo(filename).absolutePath();
		}
	}
}

#include "moc_videopreview.cpp"

