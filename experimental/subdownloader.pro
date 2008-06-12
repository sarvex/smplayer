TEMPLATE = app
LANGUAGE = C++

CONFIG += qt warn_on release

QT += network xml

HEADERS += subdownloader.h subdownloaderdialog.h
SOURCES += subdownloader.cpp subdownloaderdialog.cpp main.cpp
FORMS += subdownloaderdialog.ui

unix {
  UI_DIR = .ui
  MOC_DIR = .moc
  OBJECTS_DIR = .obj
}

win32 {
  CONFIG += console
}

