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

VideoPreview::VideoPreview(QString mplayer_path) {
	mplayer_bin = mplayer_path;
}

VideoPreview::~VideoPreview() {
}

bool VideoPreview::createThumbnails(int cols, int rows, int video_length) {
	int length = video_length;
	if (length == 0) length = getLength();

	// Create a temporary directory
	QString output_dir = "thumbnails";
	QString full_output_dir = QDir::tempPath() +"/"+ output_dir;
	QDir d(QDir::tempPath());
	if (!d.exists(output_dir)) {
		if (!d.mkpath(output_dir)) {
			qDebug("VideoPreview::createThumbnails: error: can't create '%s'", full_output_dir.toUtf8().constData());
			return false;
		}
	}

	int num_pictures = cols * rows;
	int initial_step = 0;
	length -= initial_step;
	int s_step = length / num_pictures;

	int current_time = initial_step;

	for (int n=1; n <= num_pictures; n++) {
		qDebug("VideoPreview::createThumbnails: getting frame %d of %d...", n, num_pictures);

		QStringList args;
		args << "-nosound" << "-vo" << "jpeg:outdir="+full_output_dir << "-frames" << "6"
             << "-ss" << QString::number(current_time) << input_video;

		QProcess p;
		p.start(mplayer_bin, args);
		if (!p.waitForFinished()) {
			qDebug("VideoPreview::createThumbnails: error running process");
			return false;
		}

		//QTime t = QTime().addSecs(current_time);
		//d.rename(output_dir + "/00000005.jpg", output_dir +"/picture_"+ t.toString() +".jpg");
		d.rename(output_dir + "/00000005.jpg", output_dir +"/picture_"+ QString::number(current_time) +".jpg");

		current_time += s_step;
	}

	return true;
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
