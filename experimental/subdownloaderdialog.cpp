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

#include "subdownloaderdialog.h"
#include <QHttp>
#include <QUrl>
#include <QMessageBox>

SubDownloaderDialog::SubDownloaderDialog( QWidget * parent, Qt::WindowFlags f )
	: QDialog(parent,f)
{
	setupUi(this);

	http = new QHttp(this);
	connect( http, SIGNAL(requestFinished(int, bool)),
             this, SLOT(httpRequestFinished(int, bool)) );

	connect( http, SIGNAL(responseHeaderReceived(const QHttpResponseHeader &)),
             this, SLOT(readResponseHeader(const QHttpResponseHeader &)) );

	download("http://www.opensubtitles.org/search/sublanguageid-all/moviehash-f967db8edee2873b/simplexml");
}

SubDownloaderDialog::~SubDownloaderDialog() {
}

void SubDownloaderDialog::download(const QString & url) {
	//QUrl url("http://www.opensubtitles.com/es/simplexml");
	//QUrl url("http://www.opensubtitles.org/search/sublanguageid-all/moviehash-f967db8edee2873b/simplexml");

	QUrl u(url);
	http->setHost( u.host() );
	http->get( u.path() );
}

void SubDownloaderDialog::readResponseHeader(const QHttpResponseHeader &responseHeader) {
	qDebug("SubDownloaderDialog::readResponseHeader: statusCode: %d", responseHeader.statusCode());

	if (responseHeader.statusCode() == 301)  {
		QString new_url = responseHeader.value("Location");
		qDebug("SubDownloaderDialog::readResponseHeader: Location: '%s'", new_url.toLatin1().constData());
		download(new_url);
	}
	else
	if (responseHeader.statusCode() != 200) {
		QMessageBox::information(this, tr("HTTP"),
                                 tr("Download failed: %1.")
                                 .arg(responseHeader.reasonPhrase()));
         http->abort();
     }
}

void SubDownloaderDialog::httpRequestFinished(int id, bool error) {
	qDebug("SubDownloaderDialog::httpRequestFinished: %d, %d", id, error);

	log->insertPlainText( http->readAll() );
}

#include "moc_subdownloaderdialog.cpp"

