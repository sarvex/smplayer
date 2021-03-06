/*  smtube, a small youtube browser.
    Copyright (C) 2012-2015 Ricardo Villalba <rvm@users.sourceforge.net>

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

#ifndef CONFIGDIALOG_H
#define CONFIGDIALOG_H

#include "ui_configdialog.h"

#include <QDialog>

class ConfigDialog : public QDialog, public Ui::ConfigDialog
{
    Q_OBJECT

public:
    ConfigDialog( QWidget * parent = 0, Qt::WindowFlags f = 0 );
    ~ConfigDialog();

public slots:
    void setRecordingDirectory( const QString & folder );
    void setRecordingQuality( int quality );
    void setPlaybackQuality( int quality );
#ifdef USE_PLAYERS
    void setPlayerNames(QStringList names);
    void setPlayer(QString name);
#endif
    void setRegion(const QString & region);
    void setPeriod(const QString & period);

	void setUseProxy(bool b);
	void setProxyHostname(const QString & host);
	void setProxyPort(int port);
	void setProxyUsername(const QString & username);
	void setProxyPassword(const QString & pass);
	void setProxyType(int type);

public:
    QString recordingDirectory();
    int recordingQuality();
    int playbackQuality();
#ifdef USE_PLAYERS
    QString player();
#endif
    QString region();
    QString period();

	bool useProxy();
	QString proxyHostname();
	int proxyPort();
	QString proxyUsername();
	QString proxyPassword();
	int proxyType();

#ifdef USE_PLAYERS
protected slots:
    void playerChanged(int);
#endif
};

#endif
