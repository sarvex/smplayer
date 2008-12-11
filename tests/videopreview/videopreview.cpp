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

VideoPreview::VideoPreview(QString mplayer_path, QObject * parent) : QObject(parent)
{
	mplayer_bin = mplayer_path;

	output_dir = "smplayer_preview";
	full_output_dir = QDir::tempPath() +"/"+ output_dir;
}

VideoPreview::~VideoPreview() {
}

QWidget * VideoPreview::createThumbnails(int cols, int rows, int video_length) {
	QStringList images;

	if (!extractImages(cols, rows, images, video_length)) {
		cleanDir(full_output_dir);
		return 0;
	}

	QWidget * widget = new QWidget(0);
	QGridLayout * layout = new QGridLayout;
	widget->setLayout(layout);

	int c=0;
	int r=0;
	for (int n=0; n < images.count(); n++) {
		qDebug("VideoPreview::createThumbnails: '%s'", images[n].toUtf8().constData());
		QPixmap picture(images[n]);
		QLabel * l = new QLabel(widget);
		l->setPixmap(picture.scaledToHeight(100));
		//l->setPixmap(picture);
		layout->addWidget(l, c, r);
		c++;
		if (c >= cols) { c = 0; r++; }
	}

	cleanDir(full_output_dir);
	return widget;
}

bool VideoPreview::extractImages(int cols, int rows, QStringList & images, int video_length) {
	images.clear();

	int length = video_length;
	if (length == 0) length = getLength();

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

	QProgressDialog progress(tr("Generating thumbnails..."), tr("Cancel"), 1, num_pictures, 0);
	for (int n=1; n <= num_pictures; n++) {
		qDebug("VideoPreview::extractImages: getting frame %d of %d...", n, num_pictures);
		progress.setValue(n);
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
		images.append(QDir::tempPath() +"/"+ output_file);

		current_time += s_step;
	}

	return true;
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

int VideoPreview::getLength() {
	int length = 0;

	QRegExp rx("^ID_LENGTH=(.*)");

	QProcess p;
	p.setProcessChannelMode( QProcess::MergedChannels );

	QStringList args;
	args << "-vo" << "null" << "-ao" << "null" << "-frames" << "1" << "-identify" << input_video;
	p.start(mplayer_bin, args);

	if (p.waitForFinished()) {
		QByteArray line;
		while (p.canReadLine()) {
			line = p.readLine();
			qDebug("VideoPreview::getLength: '%s'", line.constData());
			if ( rx.indexIn(line) > -1 ) {
				length = rx.cap(1).toDouble();
				qDebug("VideoPreview::getLength: found length: %d", length);
			}
		}
	} else {
		qDebug("VideoPreview::getLength: error: process didn't start");
	}

	return length;
}
