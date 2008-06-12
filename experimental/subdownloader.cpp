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

#include "subdownloader.h"
#include <QHttp>
#include <QUrl>
#include <QXmlSimpleReader>

SubDownloader::SubDownloader( QObject * parent )
	: QObject(parent)
{
	http = new QHttp(this);
	connect( http, SIGNAL(requestFinished(int, bool)),
             this, SLOT(httpRequestFinished(int, bool)) );

	connect( http, SIGNAL(responseHeaderReceived(const QHttpResponseHeader &)),
             this, SLOT(readResponseHeader(const QHttpResponseHeader &)) );

	connect( this, SIGNAL(downloadFinished(QString)), this, SLOT(parseXml(QString)) );
}

SubDownloader::~SubDownloader() {
}

void SubDownloader::download(const QString & url) {
	downloaded_text.clear();

	QUrl u(url);
	http->setHost( u.host() );
	http->get( u.path() );
}

void SubDownloader::readResponseHeader(const QHttpResponseHeader &responseHeader) {
	qDebug("SubDownloader::readResponseHeader: statusCode: %d", responseHeader.statusCode());

	if (responseHeader.statusCode() == 301)  {
		QString new_url = responseHeader.value("Location");
		qDebug("SubDownloader::readResponseHeader: Location: '%s'", new_url.toLatin1().constData());
		download(new_url);
	}
	else
	if (responseHeader.statusCode() != 200) {
		qDebug("SubDownloader::readResponseHeader: error: '%s'", responseHeader.reasonPhrase().toLatin1().constData());
		emit downloadFailed(responseHeader.reasonPhrase());
		http->abort();
	}
}

void SubDownloader::httpRequestFinished(int id, bool error) {
	qDebug("SubDownloader::httpRequestFinished: %d, %d", id, error);

	downloaded_text += http->readAll();

	if (!downloaded_text.isEmpty()) {
		emit downloadFinished(downloaded_text);
	}
}

void SubDownloader::parseXml(QString text) {
	qDebug("SubDownloader::parseXml");

	QXmlInputSource xml_input;
	xml_input.setData(text);

	QXmlSimpleReader xml_reader;
	bool ok = xml_reader.parse(&xml_input, false);

	qDebug("SubDownloader::parseXml: success: %d", ok);

	// What to do now?
}

#include "moc_subdownloader.cpp"

