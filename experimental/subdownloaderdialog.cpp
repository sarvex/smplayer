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
#include "simplehttp.h"
#include "osparser.h"
#include <QStandardItemModel>
#include <QMessageBox>
#include <QProgressDialog>
#include <QDesktopServices>
#include <QUrl>

#define COL_LANG 0
#define COL_NAME 1
#define COL_FORMAT 2
#define COL_FILES 3
#define COL_DATE 4
#define COL_USER 5

SubDownloaderDialog::SubDownloaderDialog( QWidget * parent, Qt::WindowFlags f )
	: QDialog(parent,f)
{
	setupUi(this);

	connect( file_chooser, SIGNAL(fileChanged(QString)),
             this, SLOT(setMovie(QString)) );

	table = new QStandardItemModel(this);
	table->setColumnCount(COL_USER + 1);
	table->setHorizontalHeaderLabels( QStringList() << tr("Language") 
                                                    << tr("Name") 
                                                    << tr("Format") 
                                                    << tr("Files")
                                                    << tr("Date") 
                                                    << tr("Uploaded by") );

	view->setModel(table);
	view->setRootIsDecorated(false);
	view->setSortingEnabled(true);
	view->setAlternatingRowColors(true);
	view->setEditTriggers(QAbstractItemView::NoEditTriggers);

	connect(view, SIGNAL(activated(const QModelIndex &)),
            this, SLOT(itemActivated(const QModelIndex &)) );

	downloader = new SimpleHttp(this);

	connect( downloader, SIGNAL(downloadFailed(QString)),
             this, SLOT(showError(QString)) );
	connect( downloader, SIGNAL(downloadFinished(QByteArray)), 
             this, SLOT(parseInfo(QByteArray)) );

	progress_dialog = new QProgressDialog(this);
	progress_dialog->setWindowTitle( tr("Progress") );
	progress_dialog->setCancelButtonText( tr("Cancel") );
	progress_dialog->setMinimumDuration( 200 );

	connect( downloader, SIGNAL(connecting(QString)),
             this, SLOT(connecting(QString)) );
	connect( downloader, SIGNAL(dataReadProgress(int, int)),
             this, SLOT(updateDataReadProgress(int, int)) );
	connect( downloader, SIGNAL(downloadFinished(QByteArray)),
             progress_dialog, SLOT(hide()) );
	connect( progress_dialog, SIGNAL(canceled()), downloader, SLOT(abort()) );

	//downloader->download("http://www.opensubtitles.org/search/sublanguageid-all/moviehash-f967db8edee2873b/simplexml");
	//downloader->download("http://www.opensubtitles.org/search/sublanguageid-all/moviehash-b64b940fcfe885e9/simplexml");
}

SubDownloaderDialog::~SubDownloaderDialog() {
}

void SubDownloaderDialog::setMovie(QString filename) {
	qDebug("SubDownloaderDialog::setMovie: '%s'", filename.toLatin1().constData());

	QString hash = OSParser::calculateHash(filename);
	if (hash.isEmpty()) {
		qWarning("SubDownloaderDialog::setMovie: hash invalid. Doing nothing.");
	} else {
		QString link = "http://www.opensubtitles.org/search/sublanguageid-all/moviehash-" + hash + "/simplexml";
		qDebug("SubDownloaderDialog::setMovie: link: '%s'", link.toLatin1().constData());
		downloader->download(link);
	}
}

void SubDownloaderDialog::showError(QString error) {
	QMessageBox::information(this, tr("HTTP"),
                             tr("Download failed: %1.")
                             .arg(error));
}

void SubDownloaderDialog::connecting(QString host) {
	if (!progress_dialog->isVisible()) progress_dialog->show();

	progress_dialog->setLabelText( tr("Connecting to %1...").arg(host) );
}

void SubDownloaderDialog::updateDataReadProgress(int done, int total) {
	qDebug("SubDownloaderDialog::updateDataReadProgress: %d, %d", done, total);

	//if (!progress_dialog->isVisible()) progress_dialog->show();

	progress_dialog->setLabelText( tr("Downloading...") );
	progress_dialog->setMaximum(total);
	progress_dialog->setValue(done);
}

void SubDownloaderDialog::parseInfo(QByteArray xml_text) {
	OSParser osparser;
	bool ok = osparser.parseXml(xml_text);

	table->setRowCount(0);

	if (ok) {
		QList<OSSubtitle> l = osparser.subtitleList();
		for (int n=0; n < l.count(); n++) {

			//QString title_name = "<a href=\"hola\">" + l[n].movie;
			QString title_name = l[n].movie;
			if (!l[n].releasename.isEmpty()) {
				title_name += " - " + l[n].releasename;
			}
			//title_name += "</a>";

			QStandardItem * i_name = new QStandardItem(title_name);
			i_name->setData( l[n].link );
			i_name->setToolTip( l[n].link );
			/*
			if (!l[n].comments.isEmpty()) {
				i_name->setToolTip(l[n].comments);
			}
			*/

			table->setItem(n, COL_LANG, new QStandardItem(l[n].language));
			table->setItem(n, COL_NAME, i_name);
			table->setItem(n, COL_FORMAT, new QStandardItem(l[n].format));
			table->setItem(n, COL_FILES, new QStandardItem(l[n].files));
			table->setItem(n, COL_DATE, new QStandardItem(l[n].date));
			table->setItem(n, COL_USER, new QStandardItem(l[n].user));

		}
	}

	view->resizeColumnToContents(COL_NAME);
}

void SubDownloaderDialog::itemActivated(const QModelIndex & index ) {
	qDebug("SubDownloaderDialog::itemActivated: row: %d, col %d", index.row(), index.column());

	QString download_link = table->item(index.row(), COL_NAME)->data().toString();

	qDebug("SubDownloaderDialog::itemActivated: download link: '%s'", download_link.toLatin1().constData());

	QDesktopServices::openUrl( QUrl(download_link) );
}

#include "moc_subdownloaderdialog.cpp"

