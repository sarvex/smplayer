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
#include "osgetinfo.h"
#include <QMessageBox>

SubDownloaderDialog::SubDownloaderDialog( QWidget * parent, Qt::WindowFlags f )
	: QDialog(parent,f)
{
	setupUi(this);

	downloader = new OSGetInfo(this);

	connect( downloader, SIGNAL(downloadFinished(QByteArray)), 
             this, SLOT(readDownloadedText(QByteArray)) );
	connect( downloader, SIGNAL(downloadFailed(QString)),
             this, SLOT(showError(QString)) );

	connect( downloader, SIGNAL(downloadFinished(QByteArray)), 
             this, SLOT(parseInfo(QByteArray)) );

	downloader->download("http://www.opensubtitles.org/search/sublanguageid-all/moviehash-f967db8edee2873b/simplexml");
}

SubDownloaderDialog::~SubDownloaderDialog() {
}

void SubDownloaderDialog::readDownloadedText(QByteArray text) {
	log->insertPlainText(text);
}

void SubDownloaderDialog::showError(QString error) {
	QMessageBox::information(this, tr("HTTP"),
                             tr("Download failed: %1.")
                             .arg(error));
}

void SubDownloaderDialog::parseInfo(QByteArray xml_text) {
	bool ok = downloader->parseXml(xml_text);

	if (ok) {
		QList<OSSubtitle> l = downloader->subtitleList();
		for (int n=0; n < l.count(); n++) {
			log->insertPlainText( QString::number(n) + " " + l[n].releasename + "|" + l[n].movie + "\n" );
		}
	}
}

#include "moc_subdownloaderdialog.cpp"

