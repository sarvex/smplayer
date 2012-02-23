/*  ytbrowser
    Copyright (C) 2006-2012 Ricardo Villalba <rvm@users.sourceforge.net>
    Copyright (C) 2010 Ori Rejwan

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

#include <QApplication>
#include <QTranslator>
#include <QLibraryInfo>
#include "ytdialog.h"

int main( int argc, char ** argv ) 
{
	QApplication a( argc, argv );
	a.connect( &a, SIGNAL( lastWindowClosed() ), &a, SLOT( quit() ) );

	QString locale = QLocale::system().name();
	QTranslator translator;
	translator.load("ytbrowser_" + locale, "translations");
#if defined(Q_OS_WIN)
	translator.load("qt_" + locale, "translations");
#else
	translator.load("qt_" + locale, QLibraryInfo::location(QLibraryInfo::TranslationsPath));
#endif
	a.installTranslator(&translator);

	a.setStyleSheet(":/Control/main.css");

	YTDialog * yt = new YTDialog();
	yt->setMode(YTDialog::Button);
	yt->show();
	yt->resize(400, 500);

	int r = a.exec();

	delete yt;

	return r;
}
