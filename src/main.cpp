/*  smplayer, GUI front-end for mplayer.
    Copyright (C) 2007 Ricardo Villalba <rvm@escomposlinux.org>

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


#include "defaultgui.h"
#include "helper.h"
#include "global.h"
#include "preferences.h"
#include "translator.h"
#include "version.h"
#include "config.h"
#include "myclient.h"
#include "constants.h"

#include <QApplication>
#include <QLocale>
#include <QTranslator>
#include <QFileInfo>
#include <QDir>
#include <QSettings>
#include <QRegExp>

#include <stdio.h>
#include <stdlib.h>

static QRegExp rx_log;

void myMessageOutput( QtMsgType type, const char *msg ) {
	if ( (!pref) || (!pref->log_smplayer) ) return;

	rx_log.setPattern(pref->log_filter);

	QString line = QString::fromUtf8(msg);
	switch ( type ) {
		case QtDebugMsg:
			if (rx_log.indexIn(line) > -1) {
				#ifndef NO_DEBUG_ON_CONSOLE
				fprintf( stderr, "Debug: %s\n", line.toLocal8Bit().data() );
				#endif
				Helper::addLog( line );
			}
			break;
		case QtWarningMsg:
			#ifndef NO_DEBUG_ON_CONSOLE
			fprintf( stderr, "Warning: %s\n", line.toLocal8Bit().data() );
			#endif
			Helper::addLog( "WARNING: " + line );
			break;
		case QtFatalMsg:
			#ifndef NO_DEBUG_ON_CONSOLE
			fprintf( stderr, "Fatal: %s\n", line.toLocal8Bit().data() );
			#endif
			Helper::addLog( "FATAL: " + line );
			abort();                    // deliberately core dump
		case QtCriticalMsg:
			#ifndef NO_DEBUG_ON_CONSOLE
			fprintf( stderr, "Critical: %s\n", line.toLocal8Bit().data() );
			#endif
			Helper::addLog( "CRITICAL: " + line );
			break;
	}
}

void showInfo() {
	printf( QObject::tr("This is SMPlayer v. %1 running on %2\n")
            .arg(VERSION)
#ifdef Q_OS_LINUX
           .arg("Linux")
#else
#ifdef Q_OS_WIN
           .arg("Windows")
#else
		   .arg("Other OS")
#endif
#endif
           .toLocal8Bit() );

	qDebug("Qt v. " QT_VERSION_STR);

	qDebug(" * application path: '%s'", Helper::appPath().toUtf8().data());
	qDebug(" * data path: '%s'", Helper::dataPath().toUtf8().data());
	qDebug(" * translation path: '%s'", Helper::translationPath().toUtf8().data());
	qDebug(" * doc path: '%s'", Helper::docPath().toUtf8().data());
	qDebug(" * themes path: '%s'", Helper::themesPath().toUtf8().data());
	qDebug(" * shortcuts path: '%s'", Helper::shortcutsPath().toUtf8().data());
	qDebug(" * smplayer home path: '%s'", Helper::appHomePath().toUtf8().data());
}

void showHelp(QString app_name) {
	printf( QObject::tr("Usage: %1 [-ini-path [directory]] "
                        "[-action action_name] [-close-at-end] [-help|--help|-h|-?] [[-playlist] media] "
                        "[[-playlist] media]...\n").arg(app_name).toLocal8Bit() );

	printf( QObject::tr(
		"         -ini-path: specifies the directory for the configuration file\n"
        "                    (smplayer.ini). If directory is omitted, the application\n"
        "                    directory will be used.\n").toLocal8Bit() );
	printf( QObject::tr(
		"           -action: tries to make a connection to another running instance\n"
        "                    and send to it the specified action. Example: -action pause\n"
        "                    The rest of options (if any) will be ignored and the\n"
        "                    application will exit. It will return 0 on success or -1\n"
        "                    on failure.\n").toLocal8Bit() );
	printf( QObject::tr(
		"     -close-at-end: the main window will be closed when the file/playlist finish\n").toLocal8Bit() );
	printf( QObject::tr(
		"             -help: will show this message and then will exit.\n").toLocal8Bit() );
	printf( QObject::tr(
		"             media: 'media' is any kind of file that SMPlayer can open. It can\n"
        "                    be a local file, a DVD (e.g. dvd://1), an Internet stream\n"
        "                    (e.g. mms://....) or a local playlist in format m3u.\n"
        "                    If the -playlist option is used, that means that SMPlayer\n"
        "                    will pass the -playlist option to MPlayer, so MPlayer will\n"
        "                    will handle the playlist, not SMPlayer.\n").toLocal8Bit() );
}

int main( int argc, char ** argv ) 
{
	QApplication a( argc, argv );

	QString app_path = a.applicationDirPath();
	Helper::setAppPath(app_path);
	//qDebug( "main: application path: '%s'", app_path.toUtf8().data());

	// Create smplayer home directories
	if (!QFile::exists(Helper::appHomePath())) {
		QDir d;
		if (!d.mkdir(Helper::appHomePath())) {
			qWarning("main: can't create %s", Helper::appHomePath().toUtf8().data());
		}
		QString s = Helper::appHomePath() + "/screenshots";
		if (!d.mkdir(s)) {
			qWarning("main: can't create %s", s.toUtf8().data());
		}
	}

	QString ini_path="";
	QStringList files_to_play;
	QString action; // Action to be passed to running instance

	QString app_name = QFileInfo(a.applicationFilePath()).baseName();
	qDebug("main: app name: %s", app_name.toUtf8().data());
	// If the name is smplayer_portable, activate the -ini_path by default
	if (app_name.toLower() == "smplayer_portable") 	{
		ini_path = Helper::appPath();
	}

	bool close_at_end = false;
	bool show_help = false;

	// Deleted KDE code
	// ...

	// Qt code
	int arg_init = 1;
	int arg_count = a.arguments().count();

	bool is_playlist = false;

	if ( arg_count > arg_init ) {
		for (int n=arg_init; n < arg_count; n++) {
			QString argument = a.arguments()[n];
			if (argument == "-ini-path") {
				//qDebug( "ini_path: %d %d", n+1, arg_count );
				ini_path = Helper::appPath();
				if (n+1 < arg_count) {
					n++;
					ini_path = a.arguments()[n];
				}
			}
			else
			if (argument == "-action") {
				//qDebug( "ini_path: %d %d", n+1, arg_count );
				if (n+1 < arg_count) {
					n++;
					action = a.arguments()[n];
				} else {
					printf("Error: expected parameter for -action\r\n");
					return -1;
				}
			}
			else
			if (argument == "-playlist") {
				is_playlist = true;
			}
			else
			if ((argument == "--help") || (argument == "-help") ||
                (argument == "-h") || (argument == "-?") ) {
				show_help = true;
			}
			else
			if (argument == "-close-at-end") {
				close_at_end = true;
			}
			else {
				// File
				if (QFile::exists( argument )) {
					argument = QFileInfo(argument).absoluteFilePath();
				}
				if (is_playlist) {
					argument = argument + IS_PLAYLIST_TAG;
					is_playlist = false;
				}
				files_to_play.append( argument );
			}
		}
	}


	global_init(ini_path);

	qInstallMsgHandler( myMessageOutput );

	// Application translations
	translator->load( pref->language );

	showInfo();
	// FIXME: this should be in showInfo() ?
	qDebug(" * ini path: '%s'", ini_path.toUtf8().data());

	if (show_help) {
		showHelp(app_name);
		return 0;
	}

	qDebug("main: files_to_play: count: %d", files_to_play.count() );
	for (int n=0; n < files_to_play.count(); n++) {
		qDebug("main: files_to_play[%d]: '%s'", n, files_to_play[n].toUtf8().data());
	}

	// Single instance
	MyClient *c = new MyClient(pref->connection_port);
	//c->setTimeOut(1000);
	if (c->openConnection()) {
		qDebug("main: found another instance");

		if (!action.isEmpty()) {
			if (c->sendAction(action)) {
				qDebug("main: action passed successfully to the running instance");
			} else {
				printf("Error: action couldn't be passed to the running instance");
				return -1;
			}
		}
		else	
		if (!files_to_play.isEmpty()) {
			if (c->sendFiles(files_to_play)) {
				qDebug("main: files sent successfully to the running instance");
    	        qDebug("main: exiting.");
			} else {
				qDebug("main: files couldn't be sent to another instance");
			}
		}

		return 0;

	} else {
		if (!action.isEmpty()) {
			printf("Error: no running instance found\r\n");
			return -1;
		}
	}

	DefaultGui * w = new DefaultGui(0);
	w->setExitOnFinish( close_at_end );

	if (!w->startHidden() || !files_to_play.isEmpty() ) w->show();
	if (!files_to_play.isEmpty()) w->openFiles(files_to_play);

	a.connect( &a, SIGNAL( lastWindowClosed() ), &a, SLOT( quit() ) );

	int r = a.exec();
	delete w;

	global_end();

	return r;
}
