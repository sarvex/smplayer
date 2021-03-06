/*  smtube, a small youtube browser.
    Copyright (C) 2012-2015 Ricardo Villalba <rvm@users.sourceforge.net>
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

#ifdef USE_SINGLE_APPLICATION
#include "QtSingleApplication"
#else
#include <QApplication>
#endif

#include <QTranslator>
#include <QLibraryInfo>
#include <QSettings>
#include <QDir>
#include "ytdialog.h"

#ifdef Q_WS_AMIGA // zzd10h
const char* __attribute__((used)) stack_cookie = "\0$STACK:500000\0";
#endif

QString configPath() {
#ifdef PORTABLE_APP
    return qApp->applicationDirPath();
#else
#if !defined(Q_OS_WIN) && !defined(Q_OS_OS2)
    const char * XDG_CONFIG_HOME = getenv("XDG_CONFIG_HOME");
    if (XDG_CONFIG_HOME!=NULL) {
        /* qDebug("configPath: XDG_CONFIG_HOME: %s", XDG_CONFIG_HOME); */
        return QString(XDG_CONFIG_HOME) + "/smtube";
    } 
    else
    return QDir::homePath() + "/.config/smtube";
#else
    return QDir::homePath() + "/.smtube";
#endif
#endif // PORTABLE_APP
}

#ifdef YT_USE_SCRIPT
QString smplayerConfigPath() {
#ifdef PORTABLE_APP
    return qApp->applicationDirPath();
#else
#if !defined(Q_OS_WIN) && !defined(Q_OS_OS2)
    const char * XDG_CONFIG_HOME = getenv("XDG_CONFIG_HOME");
    if (XDG_CONFIG_HOME!=NULL) {
        /* qDebug("configPath: XDG_CONFIG_HOME: %s", XDG_CONFIG_HOME); */
        return QString(XDG_CONFIG_HOME) + "/smplayer";
    } 
    else
    return QDir::homePath() + "/.config/smplayer";
#else
    return QDir::homePath() + "/.smplayer";
#endif
#endif // PORTABLE_APP
}
#endif // YT_USE_SCRIPT

QString translationsPath() {
#ifdef Q_WS_AMIGA // zzd10h
	QDir::setCurrent(qApp->applicationDirPath());
#endif

	QString path = "translations";
#if !defined(Q_OS_WIN)
#ifdef TRANSLATION_PATH
	 QString s = QString(TRANSLATION_PATH);
	 if (!s.isEmpty()) path = s;
#endif
#endif
    //qDebug("Translations path: '%s'", path.toUtf8().constData());
    return path;
}

QString qtTranslationsPath() {
#if defined(Q_OS_WIN)
    return "translations";
#else
    return QLibraryInfo::location(QLibraryInfo::TranslationsPath);
#endif
}

int main( int argc, char ** argv ) 
{
#ifdef USE_SINGLE_APPLICATION
	QtSingleApplication a("smtube", argc, argv);
#else
	QApplication a(argc, argv);
#endif
	/* a.setWheelScrollLines(1); */

	QString search_term;
	QString language;
#ifdef YT_DL
	QString download_url;
#endif

	QStringList args = qApp->arguments();
	for (int n = 1; n < args.count(); n++) {
		QString argument = args[n];
		if (argument == "-lang") {
			if (n+1 < args.count()) {
				n++;
				language = args[n];
			}
		}
		#ifdef YT_DL
		else
		if (argument == "-url") {
			if (n+1 < args.count()) {
				n++;
				download_url = args[n];
			}
		}
		#endif
		else
		search_term = args[n];
	}

#ifdef USE_SINGLE_APPLICATION
	if (a.isRunning()) {
		QString message;
		if (!search_term.isEmpty()) message = "search " + search_term;
		a.sendMessage(message);
		#ifdef YT_DL
		if (!download_url.isEmpty()) {
			a.sendMessage("download " + download_url);
		}
		#endif
		qDebug("Another instance is running. Exiting.");
		return 0;
	}
#endif
	a.connect( &a, SIGNAL( lastWindowClosed() ), &a, SLOT( quit() ) );

	QString locale = QLocale::system().name();
	if (!language.isEmpty()) locale = language;
	QTranslator app_trans;
	app_trans.load("smtube_" + locale, translationsPath());

	QTranslator qt_trans;
	qt_trans.load("qt_" + locale, qtTranslationsPath());

	a.installTranslator(&app_trans);
	a.installTranslator(&qt_trans);

	if (!QFile::exists(configPath())) {
		qDebug("Creating '%s'", configPath().toUtf8().constData() );
		QDir().mkpath( configPath() );
	}

	QSettings settings(configPath() + "/smtube.ini", QSettings::IniFormat);

	YTDialog * yt = new YTDialog(0, &settings);

#ifdef YT_USE_SCRIPT
	QString ytcode_name = "yt.js";
	QString ytcode_file = configPath() +"/"+ ytcode_name;
	if (QFile::exists(smplayerConfigPath())) ytcode_file = smplayerConfigPath() +"/"+ ytcode_name;
	qDebug("ytcode_file: %s", ytcode_file.toUtf8().constData());
	yt->setScriptFile(ytcode_file);
#endif

#ifdef USE_SINGLE_APPLICATION
	QObject::connect(&a, SIGNAL(messageReceived(const QString&)),
                     yt, SLOT(handleMessage(const QString&)));
	a.setActivationWindow(yt);
#endif

	if (!search_term.isEmpty()) {
		yt->setSearchTerm(search_term);
	} else {
		yt->setMode(YTDialog::Button);
	}
	yt->show();
#ifdef YT_DL
	if (!download_url.isEmpty()) yt->downloadUrl(download_url);
#endif

	int r = a.exec();

	delete yt;

	return r;
}
