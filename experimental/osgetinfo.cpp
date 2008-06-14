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

#include "osgetinfo.h"
#include <QHttp>
#include <QUrl>
#include <QXmlSimpleReader>

OSGetInfo::OSGetInfo( QObject * parent )
	: QObject(parent)
{
	http = new QHttp(this);
	connect( http, SIGNAL(requestFinished(int, bool)),
             this, SLOT(httpRequestFinished(int, bool)) );

	connect( http, SIGNAL(responseHeaderReceived(const QHttpResponseHeader &)),
             this, SLOT(readResponseHeader(const QHttpResponseHeader &)) );

	//connect( this, SIGNAL(downloadFinished(QString)), this, SLOT(parseXml(QString)) );
}

OSGetInfo::~OSGetInfo() {
}

void OSGetInfo::download(const QString & url) {
	downloaded_text.clear();

	QUrl u(url);
	http->setHost( u.host() );
	http->get( u.path() );
}

void OSGetInfo::readResponseHeader(const QHttpResponseHeader &responseHeader) {
	qDebug("OSGetInfo::readResponseHeader: statusCode: %d", responseHeader.statusCode());

	if (responseHeader.statusCode() == 301)  {
		QString new_url = responseHeader.value("Location");
		qDebug("OSGetInfo::readResponseHeader: Location: '%s'", new_url.toLatin1().constData());
		download(new_url);
	}
	else
	if (responseHeader.statusCode() != 200) {
		qDebug("OSGetInfo::readResponseHeader: error: '%s'", responseHeader.reasonPhrase().toLatin1().constData());
		emit downloadFailed(responseHeader.reasonPhrase());
		http->abort();
	}
}

void OSGetInfo::httpRequestFinished(int id, bool error) {
	qDebug("OSGetInfo::httpRequestFinished: %d, %d", id, error);

	downloaded_text += http->readAll();

	if (!downloaded_text.isEmpty()) {
		emit downloadFinished(downloaded_text);
	}
}

bool OSGetInfo::parseXml(QString text) {
	qDebug("OSGetInfo::parseXml");

	/*
	QXmlInputSource xml_input;
	xml_input.setData(text);

	QXmlSimpleReader xml_reader;
	bool ok = xml_reader.parse(&xml_input, false);

	qDebug("OSGetInfo::parseXml: success: %d", ok);
	*/

	s_list.clear();

	bool ok = dom_document.setContent(text);
	qDebug("OSGetInfo::parseXml: success: %d", ok);

	if (!ok) return false;

	QDomNode root = dom_document.documentElement();
	qDebug("tagname: '%s'", root.toElement().tagName().toLatin1().constData());

	QDomNode child = root.firstChildElement("results");
	if (!child.isNull()) {
		qDebug("items: %s", child.toElement().attribute("items").toLatin1().constData());
		QDomNode subtitle = child.firstChildElement("subtitle");
		while (!subtitle.isNull()) {
			//qDebug("tagname: '%s'", subtitle.tagName().toLatin1().constData());
			qDebug("text: '%s'", subtitle.toElement().text().toLatin1().constData());

			OSSubtitle sub;

			QDomElement e = subtitle.namedItem("releasename").toElement();
			if (!e.isNull()) sub.releasename = e.text();

			e = subtitle.namedItem("download").toElement();
			if (!e.isNull()) sub.link = e.text();

			e = subtitle.namedItem("detail").toElement();
			if (!e.isNull()) sub.detail = e.text();

			e = subtitle.namedItem("subadddate").toElement();
			if (!e.isNull()) sub.date = e.text();

			e = subtitle.namedItem("subrating").toElement();
			if (!e.isNull()) sub.rating = e.text();

			e = subtitle.namedItem("subcomments").toElement();
			if (!e.isNull()) sub.comments = e.text();

			e = subtitle.namedItem("movie").toElement();
			if (!e.isNull()) sub.movie = e.text();

			e = subtitle.namedItem("files").toElement();
			if (!e.isNull()) sub.files = e.text();

			e = subtitle.namedItem("format").toElement();
			if (!e.isNull()) sub.format = e.text();

			e = subtitle.namedItem("language").toElement();
			if (!e.isNull()) sub.language = e.text();

			e = subtitle.namedItem("iso639").toElement();
			if (!e.isNull()) sub.iso639 = e.text();

			s_list.append(sub);

			subtitle = subtitle.nextSiblingElement("subtitle");
		}
	}

	return true;
}

#include "moc_osgetinfo.cpp"

