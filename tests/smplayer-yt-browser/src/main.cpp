/*  smplayer-yt-browser
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
#include <QSettings>
#include <QDir>
#include "ytdialog.h"

QString configPath() {
#if !defined(Q_OS_WIN) && !defined(Q_OS_OS2)
    const char * XDG_CONFIG_HOME = getenv("XDG_CONFIG_HOME");
    if (XDG_CONFIG_HOME!=NULL) {
        qDebug("configPath: XDG_CONFIG_HOME: %s", XDG_CONFIG_HOME);
        return QString(XDG_CONFIG_HOME) + "/smplayer";
    } 
    else
    return QDir::homePath() + "/.config/smplayer";
#else
    return QDir::homePath() + "/.smplayer";
#endif
}

int main( int argc, char ** argv ) 
{
	QApplication a( argc, argv );
	a.connect( &a, SIGNAL( lastWindowClosed() ), &a, SLOT( quit() ) );

	QString locale = QLocale::system().name();
	QTranslator app_trans;
#ifdef TRANSLATION_PATH
	 QString path = QString(TRANSLATION_PATH);
	 if (path.isEmpty()) path = "translations";
	app_trans.load("smplayer-yt-browser_" + locale, path);
#else
	app_trans.load("smplayer-yt-browser_" + locale, "translations");
#endif

	QTranslator qt_trans;
#if defined(Q_OS_WIN)
	qt_trans.load("qt_" + locale, "translations");
#else
	qt_trans.load("qt_" + locale, QLibraryInfo::location(QLibraryInfo::TranslationsPath));
#endif

	a.installTranslator(&app_trans);
	a.installTranslator(&qt_trans);

	a.setStyleSheet(":/Control/main.css");

    QSettings settings(configPath() + "/smplayer-yt-browser.ini", QSettings::IniFormat);

	YTDialog * yt = new YTDialog(0, &settings);
	yt->setMode(YTDialog::Button);
	yt->show();
	yt->resize(400, 500);

	int r = a.exec();

	delete yt;

	return r;
}
