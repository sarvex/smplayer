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
	Q_OBJECT

public:
	VideoPreview(QString mplayer_path, QWidget * parent = 0, Qt::WindowFlags f = 0);
	~VideoPreview();

	void setVideoFile(QString file) { input_video = file; };
	QString videoFile() { return input_video; };

	void setCols(int cols) { n_cols = cols; };
	int cols() { return n_cols; };

	void setRows(int rows) { n_rows = rows; };
	int rows() { return n_rows; };

	void setGrid(int cols, int rows) { n_cols = cols; n_rows = rows; };

	void setInitialStep(int step) { initial_step = step; };
	int initialStep() { return initial_step; };

	void setMaxWidth(int w) { max_width = w; };
	int maxWidth() { return max_width; };

	void setDisplayOSD(bool b) { display_osd = b; };
	bool displayOSD() { return display_osd; };

	bool createThumbnails();

	static VideoInfo getInfo(const QString & mplayer_path, const QString & filename);

protected slots:
	void cancelPressed();

protected:
	bool extractImages();
	void addPicture(const QString & filename, int col, int row); 
	void cleanDir(QString directory);

	QString mplayer_bin;

	QString output_dir;
	QString full_output_dir;

	QProgressDialog * progress;
	bool canceled;

	QString input_video;
	int n_cols, n_rows, initial_step, max_width;
	bool display_osd;

	int thumbnail_width;
};

#endif
