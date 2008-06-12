TEMPLATE = app
LANGUAGE = C++

CONFIG += qt warn_on release

QT += network xml

HEADERS += subdownloaderdialog.h
SOURCES += subdownloaderdialog.cpp main.cpp
FORMS += subdownloaderdialog.ui

unix {
  UI_DIR = .ui
  MOC_DIR = .moc
  OBJECTS_DIR = .obj
}

