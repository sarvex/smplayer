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

#ifndef _OSGETINFO_H_
#define _OSGETINFO_H_

#include <QObject>

class QHttp;
class QHttpResponseHeader;

class OSGetInfo : public QObject
{
	Q_OBJECT

public:
	OSGetInfo( QObject* parent = 0 );
	~OSGetInfo();

	void download(const QString & url);

signals:
	void downloadFinished(QString downloaded_text);
	void downloadFailed(QString error);

protected slots:
	void readResponseHeader(const QHttpResponseHeader &responseHeader);
	void httpRequestFinished(int id, bool error);
	void parseXml(QString text);

protected:
	QHttp * http;
	QString downloaded_text;
};

#endif

