/*  smplayer, GUI front-end for mplayer.
    Copyright (C) 2006-2012 Ricardo Villalba <rvm@users.sourceforge.net>

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

#include "skingui.h"
#include "helper.h"
#include "colorutils.h"
#include "core.h"
#include "global.h"
#include "widgetactions.h"
#include "playlist.h"
#include "mplayerwindow.h"
#include "myaction.h"
#include "images.h"
#include "floatingwidget.h"
#include "desktopinfo.h"
#include "editabletoolbar.h"
#include "mediabarpanel.h"
#include "actionseditor.h"

#if DOCK_PLAYLIST
#include "playlistdock.h"
#endif

#include <QMenu>
#include <QSettings>
#include <QLabel>
#include <QStatusBar>
#include <QPushButton>
#include <QToolButton>
#include <QMenuBar>
#include <QLayout>

#define TOOLBAR_VERSION 1

#undef CONTROLWIDGET_OVER_VIDEO

using namespace Global;

SkinGui::SkinGui( QWidget * parent, Qt::WindowFlags flags )
	: BaseGuiPlus( parent, flags )
{
	createStatusBar();

	connect( this, SIGNAL(timeChanged(QString)),
             this, SLOT(displayTime(QString)) );
    connect( this, SIGNAL(frameChanged(int)),
             this, SLOT(displayFrame(int)) );
	connect( this, SIGNAL(ABMarkersChanged(int,int)),
             this, SLOT(displayABSection(int,int)) );
	connect( this, SIGNAL(videoInfoChanged(int,int,double)),
             this, SLOT(displayVideoInfo(int,int,double)) );

	connect( this, SIGNAL(cursorNearBottom(QPoint)), 
             this, SLOT(showFloatingControl(QPoint)) );
	connect( this, SIGNAL(cursorNearTop(QPoint)), 
             this, SLOT(showFloatingMenu(QPoint)) );
	connect( this, SIGNAL(cursorFarEdges()), 
             this, SLOT(hideFloatingControls()) );

	createActions();
	createMainToolBars();
	createControlWidget();
	createFloatingControl();
	createMenus();

#if USE_CONFIGURABLE_TOOLBARS
	connect( editToolbar1Act, SIGNAL(triggered()),
             toolbar1, SLOT(edit()) );
	floating_control->toolbar()->takeAvailableActionsFrom(this);
	connect( editFloatingControlAct, SIGNAL(triggered()),
             floating_control->toolbar(), SLOT(edit()) );
#endif

	retranslateStrings();

	loadConfig();

	//if (playlist_visible) showPlaylist(true);

	if (pref->compact_mode) {
		mediaBarPanel->hide();
		toolbar1->hide();
	}
}

SkinGui::~SkinGui() {
	saveConfig();
}

void SkinGui::createActions() {
	qDebug("SkinGui::createActions");

	timeslider_action = createTimeSliderAction(this);
	timeslider_action->disable();

	volumeslider_action = createVolumeSliderAction(this);
	volumeslider_action->disable();

	// Create the time label
	time_label_action = new TimeLabelAction(this);
	time_label_action->setObjectName("timelabel_action");

#if MINI_ARROW_BUTTONS
	QList<QAction*> rewind_actions;
	rewind_actions << rewind1Act << rewind2Act << rewind3Act;
	rewindbutton_action = new SeekingButton(rewind_actions, this);
	rewindbutton_action->setObjectName("rewindbutton_action");

	QList<QAction*> forward_actions;
	forward_actions << forward1Act << forward2Act << forward3Act;
	forwardbutton_action = new SeekingButton(forward_actions, this);
	forwardbutton_action->setObjectName("forwardbutton_action");
#endif

	// Statusbar
	viewVideoInfoAct = new MyAction(this, "toggle_video_info" );
	viewVideoInfoAct->setCheckable(true);
	connect( viewVideoInfoAct, SIGNAL(toggled(bool)),
             video_info_display, SLOT(setVisible(bool)) );

	viewFrameCounterAct = new MyAction( this, "toggle_frame_counter" );
	viewFrameCounterAct->setCheckable( true );
	connect( viewFrameCounterAct, SIGNAL(toggled(bool)),
             frame_display, SLOT(setVisible(bool)) );

#if USE_CONFIGURABLE_TOOLBARS
	editToolbar1Act = new MyAction( this, "edit_main_toolbar" );
	editControl1Act = new MyAction( this, "edit_control1" );
	editControl2Act = new MyAction( this, "edit_control2" );
	editFloatingControlAct = new MyAction( this, "edit_floating_control" );
#endif
}

#if AUTODISABLE_ACTIONS
void SkinGui::enableActionsOnPlaying() {
	qDebug("SkinGui::enableActionsOnPlaying");
	BaseGuiPlus::enableActionsOnPlaying();

	timeslider_action->enable();
	volumeslider_action->enable();
}

void SkinGui::disableActionsOnStop() {
	qDebug("SkinGui::disableActionsOnStop");
	BaseGuiPlus::disableActionsOnStop();

	timeslider_action->disable();
	volumeslider_action->disable();
}
#endif // AUTODISABLE_ACTIONS

void SkinGui::createMenus() {
	menuBar()->setObjectName("menubar");
	QFont font = menuBar()->font();
	font.setPixelSize(11);
	menuBar()->setFont(font);
	menuBar()->setFixedHeight(21);

	toolbar_menu = new QMenu(this);
	toolbar_menu->addAction(toolbar1->toggleViewAction());
#if USE_CONFIGURABLE_TOOLBARS
	toolbar_menu->addSeparator();
	toolbar_menu->addAction(editToolbar1Act);
	toolbar_menu->addAction(editControl1Act);
	toolbar_menu->addAction(editControl2Act);
	toolbar_menu->addAction(editFloatingControlAct);
#endif
	optionsMenu->addSeparator();
	optionsMenu->addMenu(toolbar_menu);

	statusbar_menu = new QMenu(this);
	statusbar_menu->addAction(viewVideoInfoAct);
	statusbar_menu->addAction(viewFrameCounterAct);

	optionsMenu->addMenu(statusbar_menu);
}

QMenu * SkinGui::createPopupMenu() {
	QMenu * m = new QMenu(this);
#if USE_CONFIGURABLE_TOOLBARS
	m->addAction(editToolbar1Act);
	m->addAction(editControl1Act);
	m->addAction(editControl2Act);
	m->addAction(editFloatingControlAct);
#else
	m->addAction(toolbar1->toggleViewAction());
#endif
	return m;
}

void SkinGui::createMainToolBars() {
	toolbar1 = new EditableToolbar( this );
	toolbar1->setObjectName("toolbar");
	toolbar1->setMovable(false);
	toolbar1->setFixedHeight(35);
	addToolBar(Qt::TopToolBarArea, toolbar1);
#if USE_CONFIGURABLE_TOOLBARS
	QStringList toolbar1_actions;
	toolbar1_actions << "open_file" << "open_url" << "favorites_menu" << "separator"
                     << "screenshot" << "separator" << "show_file_properties" 
                     << "show_find_sub_dialog" << "show_tube_browser" << "show_preferences";
	toolbar1->setDefaultActions(toolbar1_actions);
#else
	toolbar1->addAction(openFileAct);
	toolbar1->addAction(openURLAct);
	toolbar1->addSeparator();
	toolbar1->addAction(compactAct);
	toolbar1->addAction(fullscreenAct);
	toolbar1->addSeparator();
	toolbar1->addAction(screenshotAct);
	toolbar1->addSeparator();
	toolbar1->addAction(showPropertiesAct);
	toolbar1->addAction(showFindSubtitlesDialogAct);
	toolbar1->addAction(showPreferencesAct);
	// Test:
	//toolbar1->addSeparator();
	//toolbar1->addAction(timeslider_action);
	//toolbar1->addAction(volumeslider_action);
#endif

	// Modify toolbars' actions
	QAction *tba;
	tba = toolbar1->toggleViewAction();
	tba->setObjectName("show_main_toolbar");
	tba->setShortcut(Qt::Key_F5);
}


void SkinGui::createControlWidget() {
	qDebug("SkinGui::createControlWidget");

	mediaBarPanel = new MediaBarPanel(panel);
	mediaBarPanel->setObjectName("mediabar-panel");
	mediaBarPanel->setCore(core);
	panel->layout()->addWidget(mediaBarPanel);

	QList<QAction*> actions;
	//actions << halveSpeedAct << playPrevAct << playOrPauseAct << stopAct << recordAct << playNextAct << doubleSpeedAct;
	actions << halveSpeedAct << playPrevAct << playOrPauseAct << stopAct << playNextAct << doubleSpeedAct;
	mediaBarPanel->setPlayControlActionCollection(actions);

	actions.clear();
	//actions << timeslider_action << shuffleAct << repeatPlaylistAct;
	QAction * shuffleAct = ActionsEditor::findAction(playlist, "pl_shuffle");
	QAction * repeatPlaylistAct = ActionsEditor::findAction(playlist, "pl_repeat");
	if (shuffleAct) actions << shuffleAct;
	if (repeatPlaylistAct) actions << repeatPlaylistAct;
	mediaBarPanel->setMediaPanelActionCollection(actions);
	connect(core, SIGNAL(stateChanged(Core::State)), mediaBarPanel, SLOT(setMplayerState(Core::State)));

	actions.clear();
	//actions << volumeslider_action << showPlaylistAct << fullscreenAct << equalizerAct;
	actions << volumeslider_action << showPlaylistAct << fullscreenAct << videoEqualizerAct;
	mediaBarPanel->setVolumeControlActionCollection(actions);

	actions.clear();
	actions << openFileAct << openDirectoryAct << openDVDAct << openURLAct << screenshotAct << showPropertiesAct;
#ifdef FIND_SUBTITLES
	actions << showFindSubtitlesDialogAct;
#endif
	actions << showPreferencesAct;
	mediaBarPanel->setToolbarActionCollection(actions);

	connect(mediaBarPanel, SIGNAL(volumeChanged(int)), core, SLOT(setVolume(int)));
	connect(core, SIGNAL(volumeChanged(int)), mediaBarPanel, SLOT(setVolume(int)));

#ifdef SEEKBAR_RESOLUTION
	connect(mediaBarPanel, SIGNAL(seekerChanged(int)), core, SLOT(goToPosition(int)));
	connect(core, SIGNAL(positionChanged(int)), mediaBarPanel, SLOT(setSeeker(int)));
#else
	connect(mediaBarPanel, SIGNAL(seekerChanged(int)), core, SLOT(goToPos(int)));
	connect(core, SIGNAL(posChanged(int)),mediaBarPanel, SLOT(setSeeker(int)));
#endif
}

void SkinGui::createFloatingControl() {
	// Floating control
	floating_control = new FloatingWidget(this);

#if USE_CONFIGURABLE_TOOLBARS
	QStringList floatingcontrol_actions;
	floatingcontrol_actions << "play" << "pause" << "stop" << "separator";
	#if MINI_ARROW_BUTTONS
	floatingcontrol_actions << "rewindbutton_action";
	#else
	floatingcontrol_actions << "rewind3" << "rewind2" << "rewind1";
	#endif
	floatingcontrol_actions << "timeslider_action";
	#if MINI_ARROW_BUTTONS
	floatingcontrol_actions << "forwardbutton_action";
	#else
	floatingcontrol_actions << "forward1" << "forward2" << "forward3";
	#endif
	floatingcontrol_actions << "separator" << "fullscreen" << "mute" << "volumeslider_action" << "separator" << "timelabel_action";
	floating_control->toolbar()->setDefaultActions(floatingcontrol_actions);
#else
	floating_control->toolbar()->addAction(playAct);
	floating_control->toolbar()->addAction(pauseAct);
	floating_control->toolbar()->addAction(stopAct);
	floating_control->toolbar()->addSeparator();

	#if MINI_ARROW_BUTTONS
	floating_control->toolbar()->addAction( rewindbutton_action );
	#else
	floating_control->toolbar()->addAction(rewind3Act);
	floating_control->toolbar()->addAction(rewind2Act);
	floating_control->toolbar()->addAction(rewind1Act);
	#endif

	floating_control->toolbar()->addAction(timeslider_action);

	#if MINI_ARROW_BUTTONS
	floating_control->toolbar()->addAction( forwardbutton_action );
	#else
	floating_control->toolbar()->addAction(forward1Act);
	floating_control->toolbar()->addAction(forward2Act);
	floating_control->toolbar()->addAction(forward3Act);
	#endif

	floating_control->toolbar()->addSeparator();
	floating_control->toolbar()->addAction(fullscreenAct);
	floating_control->toolbar()->addAction(muteAct);
	floating_control->toolbar()->addAction(volumeslider_action);
	floating_control->toolbar()->addSeparator();
	floating_control->toolbar()->addAction(time_label_action);
#endif // USE_CONFIGURABLE_TOOLBARS

#if defined(Q_OS_WIN) || defined(Q_OS_OS2)
	// To make work the ESC key (exit fullscreen) and Ctrl-X (close) in Windows and OS2
	floating_control->addAction(exitFullscreenAct);
	floating_control->addAction(exitAct);
#endif

#if !USE_CONFIGURABLE_TOOLBARS
	floating_control->adjustSize();
#endif
}

void SkinGui::createStatusBar() {
	qDebug("SkinGui::createStatusBar");

	time_display = new QLabel( statusBar() );
	time_display->setObjectName("time_display");
	time_display->setAlignment(Qt::AlignRight);
	time_display->setFrameShape(QFrame::NoFrame);
	time_display->setText(" 88:88:88 / 88:88:88 ");
	time_display->setMinimumSize(time_display->sizeHint());

	frame_display = new QLabel( statusBar() );
	frame_display->setObjectName("frame_display");
	frame_display->setAlignment(Qt::AlignRight);
	frame_display->setFrameShape(QFrame::NoFrame);
	frame_display->setText("88888888");
	frame_display->setMinimumSize(frame_display->sizeHint());

	ab_section_display = new QLabel( statusBar() );
	ab_section_display->setObjectName("ab_section_display");
	ab_section_display->setAlignment(Qt::AlignRight);
	ab_section_display->setFrameShape(QFrame::NoFrame);
//	ab_section_display->setText("A:0:00:00 B:0:00:00");
//	ab_section_display->setMinimumSize(ab_section_display->sizeHint());

	video_info_display = new QLabel( statusBar() );
	video_info_display->setObjectName("video_info_display");
	video_info_display->setAlignment(Qt::AlignRight);
	video_info_display->setFrameShape(QFrame::NoFrame);

	statusBar()->setAutoFillBackground(TRUE);

	ColorUtils::setBackgroundColor( statusBar(), QColor(0,0,0) );
	ColorUtils::setForegroundColor( statusBar(), QColor(255,255,255) );
	ColorUtils::setBackgroundColor( time_display, QColor(0,0,0) );
	ColorUtils::setForegroundColor( time_display, QColor(255,255,255) );
	ColorUtils::setBackgroundColor( frame_display, QColor(0,0,0) );
	ColorUtils::setForegroundColor( frame_display, QColor(255,255,255) );
	ColorUtils::setBackgroundColor( ab_section_display, QColor(0,0,0) );
	ColorUtils::setForegroundColor( ab_section_display, QColor(255,255,255) );
	ColorUtils::setBackgroundColor( video_info_display, QColor(0,0,0) );
	ColorUtils::setForegroundColor( video_info_display, QColor(255,255,255) );
	statusBar()->setSizeGripEnabled(FALSE);

	statusBar()->addPermanentWidget( video_info_display );
	statusBar()->addPermanentWidget( ab_section_display );

    statusBar()->showMessage( tr("Welcome to SMPlayer") );
	statusBar()->addPermanentWidget( frame_display, 0 );
	frame_display->setText( "0" );

    statusBar()->addPermanentWidget( time_display, 0 );
	time_display->setText(" 00:00:00 / 00:00:00 ");

	time_display->show();
	frame_display->hide();
	ab_section_display->show();
	video_info_display->hide();

	statusBar()->hide();
}

void SkinGui::retranslateStrings() {
	BaseGuiPlus::retranslateStrings();

	toolbar_menu->menuAction()->setText( tr("&Toolbars") );
	toolbar_menu->menuAction()->setIcon( Images::icon("toolbars") );

	statusbar_menu->menuAction()->setText( tr("Status&bar") );
	statusbar_menu->menuAction()->setIcon( Images::icon("statusbar") );

	toolbar1->setWindowTitle( tr("&Main toolbar") );
	toolbar1->toggleViewAction()->setIcon(Images::icon("main_toolbar"));

	viewVideoInfoAct->change(Images::icon("view_video_info"), tr("&Video info") );
	viewFrameCounterAct->change( Images::icon("frame_counter"), tr("&Frame counter") );

#if USE_CONFIGURABLE_TOOLBARS
	editToolbar1Act->change( tr("Edit main &toolbar") );
	editControl1Act->change( tr("Edit &control bar") );
	editControl2Act->change( tr("Edit m&ini control bar") );
	editFloatingControlAct->change( tr("Edit &floating control") );
#endif
}

void SkinGui::displayTime(QString text) {
	time_display->setText( text );
	time_label_action->setText(text);
}

void SkinGui::displayFrame(int frame) {
	if (frame_display->isVisible()) {
		frame_display->setNum( frame );
	}
}

void SkinGui::displayABSection(int secs_a, int secs_b) {
	QString s;
	if (secs_a > -1) s = tr("A:%1").arg(Helper::formatTime(secs_a));

	if (secs_b > -1) {
		if (!s.isEmpty()) s += " ";
		s += tr("B:%1").arg(Helper::formatTime(secs_b));
	}

	ab_section_display->setText( s );

	ab_section_display->setShown( !s.isEmpty() );
}

void SkinGui::displayVideoInfo(int width, int height, double fps) {
	video_info_display->setText(tr("%1x%2 %3 fps", "width + height + fps").arg(width).arg(height).arg(fps));
}

void SkinGui::updateWidgets() {
	qDebug("SkinGui::updateWidgets");

	BaseGuiPlus::updateWidgets();

	panel->setFocus();
}

void SkinGui::aboutToEnterFullscreen() {
	qDebug("SkinGui::aboutToEnterFullscreen");

	BaseGuiPlus::aboutToEnterFullscreen();

	// Save visibility of toolbars
	fullscreen_toolbar1_was_visible = toolbar1->isVisible();

	if (!pref->compact_mode) {
		mediaBarPanel->hide();
		toolbar1->hide();
	}
}

void SkinGui::aboutToExitFullscreen() {
	qDebug("SkinGui::aboutToExitFullscreen");

	BaseGuiPlus::aboutToExitFullscreen();

	floating_control->hide();

	if (!pref->compact_mode) {
		statusBar()->hide();
		mediaBarPanel->show();
		toolbar1->setVisible( fullscreen_toolbar1_was_visible );
	}
}

void SkinGui::aboutToEnterCompactMode() {

	BaseGuiPlus::aboutToEnterCompactMode();

	// Save visibility of toolbars
	compact_toolbar1_was_visible = toolbar1->isVisible();

	mediaBarPanel->hide();
	toolbar1->hide();
}

void SkinGui::aboutToExitCompactMode() {
	BaseGuiPlus::aboutToExitCompactMode();

	statusBar()->hide();
	mediaBarPanel->show();
	toolbar1->setVisible( compact_toolbar1_was_visible );

	// Recheck size of controlwidget
	/* resizeEvent( new QResizeEvent( size(), size() ) ); */
}

void SkinGui::showFloatingControl(QPoint /*p*/) {
	qDebug("SkinGui::showFloatingControl");

#if CONTROLWIDGET_OVER_VIDEO
	if ((pref->compact_mode) && (!pref->fullscreen)) {
		floating_control->setAnimated( false );
	} else {
		floating_control->setAnimated( pref->floating_control_animated );
	}
	floating_control->setMargin(pref->floating_control_margin);
#ifndef Q_OS_WIN
	floating_control->setBypassWindowManager(pref->bypass_window_manager);
#endif
	floating_control->showOver(panel, pref->floating_control_width);
#else
	if (!mediaBarPanel->isVisible()) {
		mediaBarPanel->show();
	}
#endif
}

void SkinGui::showFloatingMenu(QPoint /*p*/) {
#if !CONTROLWIDGET_OVER_VIDEO
	qDebug("SkinGui::showFloatingMenu");

	if (!menuBar()->isVisible())
		menuBar()->show();
#endif
}

void SkinGui::hideFloatingControls() {
	qDebug("SkinGui::hideFloatingControls");

#if CONTROLWIDGET_OVER_VIDEO
	floating_control->hide();
#else
	if (mediaBarPanel->isVisible())
		mediaBarPanel->hide();

	if (menuBar()->isVisible())
		menuBar()->hide();
#endif
}

void SkinGui::saveConfig() {
	qDebug("SkinGui::saveConfig");

	QSettings * set = settings;

	set->beginGroup( "skin_gui");

	set->setValue("video_info", viewVideoInfoAct->isChecked());
	set->setValue("frame_counter", viewFrameCounterAct->isChecked());

	set->setValue("fullscreen_toolbar1_was_visible", fullscreen_toolbar1_was_visible);
	set->setValue("compact_toolbar1_was_visible", compact_toolbar1_was_visible);

	if (pref->save_window_size_on_exit) {
		qDebug("SkinGui::saveConfig: w: %d h: %d", width(), height());
		set->setValue( "pos", pos() );
		set->setValue( "size", size() );
	}

	set->setValue( "toolbars_state", saveState(Helper::qtVersion()) );

#if USE_CONFIGURABLE_TOOLBARS
	set->beginGroup( "actions" );
	set->setValue("toolbar1", toolbar1->actionsToStringList() );
	set->setValue("floating_control", floating_control->toolbar()->actionsToStringList() );
	set->setValue("toolbar1_version", TOOLBAR_VERSION);
	set->endGroup();
#endif

	set->endGroup();
}

void SkinGui::loadConfig() {
	qDebug("SkinGui::loadConfig");

	QSettings * set = settings;

	set->beginGroup( "skin_gui");

	viewVideoInfoAct->setChecked(set->value("video_info", false).toBool());
	viewFrameCounterAct->setChecked(set->value("frame_counter", false).toBool());

	fullscreen_toolbar1_was_visible = set->value("fullscreen_toolbar1_was_visible", fullscreen_toolbar1_was_visible).toBool();
	compact_toolbar1_was_visible = set->value("compact_toolbar1_was_visible", compact_toolbar1_was_visible).toBool();

	if (pref->save_window_size_on_exit) {
		QPoint p = set->value("pos", pos()).toPoint();
		QSize s = set->value("size", size()).toSize();

		if ( (s.height() < 200) && (!pref->use_mplayer_window) ) {
			s = pref->default_size;
		}

		move(p);
		resize(s);

		if (!DesktopInfo::isInsideScreen(this)) {
			move(0,0);
			qWarning("SkinGui::loadConfig: window is outside of the screen, moved to 0x0");
		}
	}

#if USE_CONFIGURABLE_TOOLBARS
	set->beginGroup( "actions" );
	int toolbar_version = set->value("toolbar1_version", 0).toInt();
	if (toolbar_version >= TOOLBAR_VERSION) {
		toolbar1->setActionsFromStringList( set->value("toolbar1", toolbar1->defaultActions()).toStringList() );
	} else {
		qDebug("SkinGui::loadConfig: toolbar too old, loading default one");
		toolbar1->setActionsFromStringList( toolbar1->defaultActions() );
	}
	floating_control->toolbar()->setActionsFromStringList( set->value("floating_control", floating_control->toolbar()->defaultActions()).toStringList() );
	floating_control->adjustSize();
	set->endGroup();
#endif

	restoreState( set->value( "toolbars_state" ).toByteArray(), Helper::qtVersion() );

#if DOCK_PLAYLIST
	qDebug("SkinGui::loadConfig: playlist visible: %d", playlistdock->isVisible());
	qDebug("SkinGui::loadConfig: playlist position: %d, %d", playlistdock->pos().x(), playlistdock->pos().y());
	qDebug("SkinGui::loadConfig: playlist size: %d x %d", playlistdock->size().width(), playlistdock->size().height());
#endif

	set->endGroup();

	updateWidgets();
}

#include "moc_skingui.cpp"
