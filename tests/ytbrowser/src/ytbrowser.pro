######################################################################
# Automatically generated by qmake (2.01a) mar feb 21 00:12:34 2012
######################################################################

TEMPLATE = app
QT += network xml
TARGET = 
DEPENDPATH += .
INCLUDEPATH += .

CONFIG += qt warn_on release

RESOURCES = icons.qrc

DEFINES += NO_SMPLAYER_SUPPORT

# Input
HEADERS += myborder.h \
           myicon.h \
           downloadfile.h \
           recordingdialog.h \
           retrievevideourl.h \
           searchbox.h \
           ytdataapi.h \
           ytdelegate.h \
           ytdialog.h \
           yttabbar.h \
           lineedit_with_icon.h \
           filechooser.h \
           configdialog.h

SOURCES += myborder.cpp \
           myicon.cpp \
           downloadfile.cpp \
           recordingdialog.cpp \
           retrievevideourl.cpp \
           searchbox.cpp \
           ytdataapi.cpp \
           ytdelegate.cpp \
           ytdialog.cpp \
           yttabbar.cpp \
           lineedit_with_icon.cpp \
           filechooser.cpp \
           configdialog.cpp \
           main.cpp

FORMS += configdialog.ui

TRANSLATIONS = translations/ytbrowser_es.ts translations/ytbrowser_en.ts

unix {
    UI_DIR = .ui
    MOC_DIR = .moc
    OBJECTS_DIR = .obj
}

