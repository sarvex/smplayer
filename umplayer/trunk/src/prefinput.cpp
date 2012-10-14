/*  umplayer, GUI front-end for mplayer.
    Copyright (C) 2006-2009 Ricardo Villalba <rvm@users.sourceforge.net>
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


#include "prefinput.h"
#include "images.h"
#include "config.h"
#include "guiconfig.h"

PrefInput::PrefInput(QWidget * parent, Qt::WindowFlags f)
	: PrefWidget(parent, f )
{
	setupUi(this);

	retranslateStrings();
}

PrefInput::~PrefInput()
{
}

QString PrefInput::sectionName() {
	return tr("Keyboard and mouse");
}

QPixmap PrefInput::sectionIcon() {
    return Images::icon("input_devices");
}

void PrefInput::createMouseCombos() {
	left_click_combo->clear();
	right_click_combo->clear();
	double_click_combo->clear();
	middle_click_combo->clear();
	xbutton1_click_combo->clear();
	xbutton2_click_combo->clear();

	left_click_combo->addItem( tr("None"), "" );
	left_click_combo->addItem( tr("Play"), "play" );
	left_click_combo->addItem( tr("Play / Pause"), "play_or_pause" );
	left_click_combo->addItem( tr("Pause"), "pause" );
	left_click_combo->addItem( tr("Pause / Frame step"), "pause_and_frame_step" );
	left_click_combo->addItem( tr("Stop"), "stop" );
	left_click_combo->addItem( tr("Go backward (short)"), "rewind1" );
	left_click_combo->addItem( tr("Go backward (medium)"), "rewind2" );
	left_click_combo->addItem( tr("Go backward (long)"), "rewind3" );
	left_click_combo->addItem( tr("Go forward (short)"), "forward1" );
	left_click_combo->addItem( tr("Go forward (medium)"), "forward2" );
	left_click_combo->addItem( tr("Go forward (long)"), "forward3" );
	left_click_combo->addItem( tr("Increase volume"), "increase_volume" );
	left_click_combo->addItem( tr("Decrease volume"), "decrease_volume" );
	left_click_combo->addItem( tr("Fullscreen"), "fullscreen" );	
	left_click_combo->addItem( tr("Screenshot"), "screenshot" );
	left_click_combo->addItem( tr("Always on top"), "on_top_always" );
	left_click_combo->addItem( tr("Never on top"), "on_top_never" );
	left_click_combo->addItem( tr("On top while playing"), "on_top_while_playing" );
	left_click_combo->addItem( tr("Mute"), "mute" );
	left_click_combo->addItem( tr("OSD - Next level"), "next_osd" );
	left_click_combo->addItem( tr("Playlist"), "show_playlist" );
	left_click_combo->addItem( tr("Reset zoom"), "reset_zoom" );
	left_click_combo->addItem( tr("Exit fullscreen"), "exit_fullscreen" );
	left_click_combo->addItem( tr("Normal speed"), "normal_speed" );
	left_click_combo->addItem( tr("Frame counter"), "frame_counter" );
	left_click_combo->addItem( tr("Preferences"), "show_preferences" );
	left_click_combo->addItem( tr("Double size"), "toggle_double_size" );
	left_click_combo->addItem( tr("Show video equalizer"), "video_equalizer" );
	left_click_combo->addItem( tr("Show audio equalizer"), "audio_equalizer" );
	left_click_combo->addItem( tr("Show context menu"), "show_context_menu" );
	left_click_combo->addItem( tr("Change function of wheel"), "next_wheel_function" );
#if DVDNAV_SUPPORT
	left_click_combo->addItem( tr("Activate option under mouse in DVD menus"), "dvdnav_mouse" );
	left_click_combo->addItem( tr("Return to main DVD menu"), "dvdnav_menu" );
	left_click_combo->addItem( tr("Return to previous menu in DVD menus"), "dvdnav_prev" );
	left_click_combo->addItem( tr("Move cursor up in DVD menus"), "dvdnav_up" );
	left_click_combo->addItem( tr("Move cursor down in DVD menus"), "dvdnav_down" );
	left_click_combo->addItem( tr("Move cursor left in DVD menus"), "dvdnav_left" );
	left_click_combo->addItem( tr("Move cursor right in DVD menus"), "dvdnav_right" );
	left_click_combo->addItem( tr("Activate highlighted option in DVD menus"), "dvdnav_select" );
#endif

	// Copy to other combos
	for (int n=0; n < left_click_combo->count(); n++) {
		double_click_combo->addItem( left_click_combo->itemText(n),
                                     left_click_combo->itemData(n) );

		right_click_combo->addItem( left_click_combo->itemText(n),
                                    left_click_combo->itemData(n) );

		middle_click_combo->addItem( left_click_combo->itemText(n),
                                     left_click_combo->itemData(n) );

		xbutton1_click_combo->addItem( left_click_combo->itemText(n),
                                       left_click_combo->itemData(n) );

		xbutton2_click_combo->addItem( left_click_combo->itemText(n),
                                       left_click_combo->itemData(n) );
	}
}

void PrefInput::retranslateStrings() {
	int wheel_function = wheel_function_combo->currentIndex();

	retranslateUi(this);

	keyboard_icon->setPixmap( Images::icon("keyboard") );
	mouse_icon->setPixmap( Images::icon("mouse") );

    // Mouse function combos
	int mouse_left = left_click_combo->currentIndex();
	int mouse_right = right_click_combo->currentIndex();
	int mouse_double = double_click_combo->currentIndex();
	int mouse_middle = middle_click_combo->currentIndex();
	int mouse_xclick1 = xbutton1_click_combo->currentIndex();
	int mouse_xclick2 = xbutton2_click_combo->currentIndex();

	createMouseCombos();

	left_click_combo->setCurrentIndex(mouse_left);
	right_click_combo->setCurrentIndex(mouse_right);
	double_click_combo->setCurrentIndex(mouse_double);
	middle_click_combo->setCurrentIndex(mouse_middle);
	xbutton1_click_combo->setCurrentIndex(mouse_xclick1);
	xbutton2_click_combo->setCurrentIndex(mouse_xclick2);

	wheel_function_combo->clear();
	wheel_function_combo->addItem( tr("No function"), Preferences::DoNothing );
	wheel_function_combo->addItem( tr("Media seeking"), Preferences::Seeking );
	wheel_function_combo->addItem( tr("Volume control"), Preferences::Volume );
	wheel_function_combo->addItem( tr("Zoom video"), Preferences::Zoom );
	wheel_function_combo->addItem( tr("Change speed"), Preferences::ChangeSpeed );
	wheel_function_combo->setCurrentIndex(wheel_function);

	wheel_function_seek->setText( tr("Media &seeking") );
	wheel_function_zoom->setText( tr("&Zoom video") );
	wheel_function_volume->setText( tr("&Volume control") );
	wheel_function_speed->setText( tr("&Change speed") );

#if !USE_SHORTCUTGETTER
	actioneditor_desc->setText( 
		tr("Here you can change any key shortcut. To do it double click or "
           "start typing over a shortcut cell. Optionally you can also save "
           "the list to share it with other people or load it in another "
           "computer.") );
#endif

	createHelp();
}

void PrefInput::setData(Preferences * pref) {
	setLeftClickFunction( pref->mouse_left_click_function );
	setRightClickFunction( pref->mouse_right_click_function );
	setDoubleClickFunction( pref->mouse_double_click_function );
	setMiddleClickFunction( pref->mouse_middle_click_function );
	setXButton1ClickFunction( pref->mouse_xbutton1_click_function );
	setXButton2ClickFunction( pref->mouse_xbutton2_click_function );
	setWheelFunction( pref->wheel_function );
	setWheelFunctionCycle(pref->wheel_function_cycle);
}

void PrefInput::getData(Preferences * pref) {
	requires_restart = false;

	pref->mouse_left_click_function = leftClickFunction();
	pref->mouse_right_click_function = rightClickFunction();
	pref->mouse_double_click_function = doubleClickFunction();
	pref->mouse_middle_click_function = middleClickFunction();
	pref->mouse_xbutton1_click_function = xButton1ClickFunction();
	pref->mouse_xbutton2_click_function = xButton2ClickFunction();
	pref->wheel_function = wheelFunction();
	pref->wheel_function_cycle = wheelFunctionCycle();
}

/*
void PrefInput::setActionsList(QStringList l) {
	left_click_combo->insertStringList( l );
	double_click_combo->insertStringList( l );
}
*/

void PrefInput::setLeftClickFunction(QString f) {
	int pos = left_click_combo->findData(f);
	if (pos == -1) pos = 0; //None
	left_click_combo->setCurrentIndex(pos);
}

QString PrefInput::leftClickFunction() {
	return left_click_combo->itemData( left_click_combo->currentIndex() ).toString();
}

void PrefInput::setRightClickFunction(QString f) {
	int pos = right_click_combo->findData(f);
	if (pos == -1) pos = 0; //None
	right_click_combo->setCurrentIndex(pos);
}

QString PrefInput::rightClickFunction() {
	return right_click_combo->itemData( right_click_combo->currentIndex() ).toString();
}

void PrefInput::setDoubleClickFunction(QString f) {
	int pos = double_click_combo->findData(f);
	if (pos == -1) pos = 0; //None
	double_click_combo->setCurrentIndex(pos);
}

QString PrefInput::doubleClickFunction() {
	return double_click_combo->itemData( double_click_combo->currentIndex() ).toString();
}

void PrefInput::setMiddleClickFunction(QString f) {
	int pos = middle_click_combo->findData(f);
	if (pos == -1) pos = 0; //None
	middle_click_combo->setCurrentIndex(pos);
}

QString PrefInput::middleClickFunction() {
	return middle_click_combo->itemData( middle_click_combo->currentIndex() ).toString();
}

void PrefInput::setXButton1ClickFunction(QString f) {
	int pos = xbutton1_click_combo->findData(f);
	if (pos == -1) pos = 0; //None
	xbutton1_click_combo->setCurrentIndex(pos);
}

QString PrefInput::xButton1ClickFunction() {
	return xbutton1_click_combo->itemData( xbutton1_click_combo->currentIndex() ).toString();
}

void PrefInput::setXButton2ClickFunction(QString f) {
	int pos = xbutton2_click_combo->findData(f);
	if (pos == -1) pos = 0; //None
	xbutton2_click_combo->setCurrentIndex(pos);
}

QString PrefInput::xButton2ClickFunction() {
	return xbutton2_click_combo->itemData( xbutton2_click_combo->currentIndex() ).toString();
}

void PrefInput::setWheelFunction(int function) {
	int d = wheel_function_combo->findData(function);
	if (d < 0) d = 0;
	wheel_function_combo->setCurrentIndex( d );
}

int PrefInput::wheelFunction() {
	return wheel_function_combo->itemData(wheel_function_combo->currentIndex()).toInt();
}

void PrefInput::setWheelFunctionCycle(QFlags<Preferences::WheelFunctions> flags){
	wheel_function_seek->setChecked(flags.testFlag(Preferences::Seeking));
	wheel_function_volume->setChecked(flags.testFlag(Preferences::Volume));
	wheel_function_zoom->setChecked(flags.testFlag(Preferences::Zoom));
	wheel_function_speed->setChecked(flags.testFlag(Preferences::ChangeSpeed));
}

QFlags<Preferences::WheelFunctions> PrefInput::wheelFunctionCycle(){
	QFlags<Preferences::WheelFunctions> seekflags (QFlag ((int) Preferences::Seeking)) ;
	QFlags<Preferences::WheelFunctions> volumeflags (QFlag ((int) Preferences::Volume)) ;
	QFlags<Preferences::WheelFunctions> zoomflags (QFlag ((int) Preferences::Zoom)) ;
	QFlags<Preferences::WheelFunctions> speedflags (QFlag ((int) Preferences::ChangeSpeed)) ;
	QFlags<Preferences::WheelFunctions> out (QFlag (0));
	if(wheel_function_seek->isChecked()){
		out = out | seekflags;
	}
	if(wheel_function_volume->isChecked()){
		out = out | volumeflags;
	}
	if(wheel_function_zoom->isChecked()){
		out = out | zoomflags;
	}
	if(wheel_function_speed->isChecked()){
		out = out | speedflags;
	}
	return out;
}

void PrefInput::createHelp() {
	clearHelp();

	addSectionTitle(tr("Keyboard"));

	setWhatsThis(actions_editor, tr("Shortcut editor"),
        tr("This table allows you to change the key shortcuts of most "
           "available actions. Double click or press enter on a item, or "
           "press the <b>Change shortcut</b> button to enter in the "
           "<i>Modify shortcut</i> dialog. There are two ways to change a "
           "shortcut: if the <b>Capture</b> button is on then just "
           "press the new key or combination of keys that you want to "
           "assign for the action (unfortunately this doesn't work for all "
           "keys). If the <b>Capture</b> button is off "
           "then you could enter the full name of the key.") );

	addSectionTitle(tr("Mouse"));

	setWhatsThis(left_click_combo, tr("Left click"),
		tr("Select the action for left click on the mouse.") );

	setWhatsThis(double_click_combo, tr("Double click"),
		tr("Select the action for double click on the mouse.") );

	setWhatsThis(middle_click_combo, tr("Middle click"),
		tr("Select the action for middle click on the mouse.") );

	setWhatsThis(xbutton1_click_combo, tr("X Button 1"),
		tr("Select the action for the X button 1.") );

	setWhatsThis(xbutton2_click_combo, tr("X Button 2"),
		tr("Select the action for the X button 2.") );

	setWhatsThis(wheel_function_combo, tr("Wheel function"),
		tr("Select the action for the mouse wheel.") );

	addSectionTitle(tr("Mouse wheel functions"));

	setWhatsThis(wheel_function_seek, tr("Media seeking"),
		tr("Check it to enable seeking as one function.") );

	setWhatsThis(wheel_function_volume, tr("Volume control"),
		tr("Check it to enable changing volume as one function.") );

	setWhatsThis(wheel_function_zoom, tr("Zoom video"),
		tr("Check it to enable zooming as one function.") );

	setWhatsThis(wheel_function_speed, tr("Change speed"),
		tr("Check it to enable changing speed as one function.") );

}

#include "moc_prefinput.cpp"
