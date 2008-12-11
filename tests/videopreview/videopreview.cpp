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

VideoPreview::VideoPreview(QString mplayer_path) {
	mplayer_bin = mplayer_path;
}

VideoPreview::~VideoPreview() {
}

void VideoPreview::createThumbnails(int cols, int rows, int video_length) {
	int length = video_length;
	if (length == 0) length = getLength();
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
