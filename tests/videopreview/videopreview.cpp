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
#include <QApplication>

VideoPreview::VideoPreview(QString mplayer_path, QWidget * parent, Qt::WindowFlags f) : QWidget(parent, f)
{
	mplayer_bin = mplayer_path;

	output_dir = "smplayer_preview";
	full_output_dir = QDir::tempPath() +"/"+ output_dir;

	progress = new QProgressDialog(this);
	progress->setCancelButtonText( tr("Cancel") );

	QGridLayout * layout = new QGridLayout;
	setLayout(layout);
}

VideoPreview::~VideoPreview() {
}

bool VideoPreview::createThumbnails(int cols, int rows) {
	bool result = extractImages(cols, rows);

	cleanDir(full_output_dir);
	return result;
}

bool VideoPreview::extractImages(int cols, int rows) {
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

	int num_pictures = cols * rows;
	int initial_step = 40;
	length -= initial_step;
	int s_step = length / num_pictures;

	int current_time = initial_step;

	progress->setLabelText(tr("Creating thumbnails..."));
	progress->setRange(1, num_pictures);

	int current_col = 0;
	int current_row = 0;
	for (int n=1; n <= num_pictures; n++) {
		qDebug("VideoPreview::extractImages: getting frame %d of %d...", n, num_pictures);
		progress->setValue(n);
		qApp->processEvents();

		QStringList args;
		args << "-nosound" << "-vo" << "jpeg:outdir="+full_output_dir << "-frames" << "6"
             << "-ss" << QString::number(current_time) << input_video;

		QProcess p;
		p.start(mplayer_bin, args);
		if (!p.waitForFinished()) {
			qDebug("VideoPreview::extractImages: error running process");
			return false;
		}

		QString output_file = output_dir + QString("/picture_%1.jpg").arg(current_time, 8, 10, QLatin1Char('0'));
		d.rename(output_dir + "/00000005.jpg", output_file);

		addPicture(QDir::tempPath() +"/"+ output_file, current_col, current_row);
		current_col++;
		if (current_col >= cols) { current_col = 0; current_row++; }

		current_time += s_step;
	}

	return true;
}

void VideoPreview::addPicture(const QString & filename, int col, int row) {
	QGridLayout * grid_layout = static_cast<QGridLayout*> (layout());

	QPixmap picture(filename);
	QLabel * l = new QLabel(this);
	l->setPixmap(picture.scaledToHeight(100, Qt::SmoothTransformation));
	//l->setPixmap(picture);
	grid_layout->addWidget(l, col, row);
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
	i.width = 0;
	i.height = 0;
	i.length = 0;

	if (filename.isEmpty()) return i;

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

				if (tag == "LENGTH") i.length = value.toDouble();
				else
				if (tag == "VIDEO_WIDTH") i.width = value.toInt();
				else
				if (tag == "VIDEO_HEIGHT") i.height = value.toInt();
			}
		}
	} else {
		qDebug("VideoPreview::getInfo: error: process didn't start");
	}

	return i;
}
