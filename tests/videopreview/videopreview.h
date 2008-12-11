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

#ifndef _VIDEOPREVIEW_H_
#define _VIDEOPREVIEW_H_

#include <QWidget>
#include <QString>

class QProgressDialog;

struct VideoInfo {
	int width;
	int height;
	int length;
};

class VideoPreview : public QWidget
{
public:
	VideoPreview(QString mplayer_path, QWidget * parent = 0, Qt::WindowFlags f = 0);
	~VideoPreview();

	void setVideoFile(QString file) { input_video = file; };
	QString videoFile() { return input_video; };

	bool createThumbnails(int cols, int rows);

	static VideoInfo getInfo(const QString & mplayer_path, const QString & filename);

protected:
	bool extractImages(int cols, int rows);
	void addPicture(const QString & filename, int col, int row); 
	void cleanDir(QString directory);

	QString mplayer_bin;
	QString input_video;

	QString output_dir;
	QString full_output_dir;

	QProgressDialog * progress;
};

#endif
