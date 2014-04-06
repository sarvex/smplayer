/*  smplayer, GUI front-end for mplayer.
    Copyright (C) 2006-2014 Ricardo Villalba <rvm@users.sourceforge.net>

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

#include "shutdowndialog.h"
#include "images.h"
#include <QTimer>

ShutdownDialog::ShutdownDialog( QWidget* parent, Qt::WindowFlags f )
	: QDialog(parent, f)
	, countdown(30)
	, timer(0)
{
	setupUi(this);

	setMinimumSize(QSize(500, 100));

	icon_label->setPixmap(Images::icon("logo", 64));

	text = tr("The computer will shut down in %1 seconds.<br>Press <b>Cancel</b> to abort.");
	text_label->setText(text.arg(countdown));

	adjustSize();

	timer = new QTimer(this);
	timer->setInterval(1000);
	connect(timer, SIGNAL(timeout()), this, SLOT(updateCountdown()));
	timer->start();
}

ShutdownDialog::~ShutdownDialog() {
}

void ShutdownDialog::updateCountdown() {
	countdown--;
	text_label->setText(text.arg(countdown));
	if (countdown < 1) accept();
}

#include "moc_shutdowndialog.cpp"
