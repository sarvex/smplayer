TEMPLATE = app
LANGUAGE = C++

CONFIG += qt warn_on release

QT += network xml

HEADERS += simplehttp.h osgetinfo.h subdownloaderdialog.h
SOURCES += simplehttp.cpp osgetinfo.cpp subdownloaderdialog.cpp main.cpp
FORMS += subdownloaderdialog.ui

unix {
  UI_DIR = .ui
  MOC_DIR = .moc
  OBJECTS_DIR = .obj
}

win32 {
  CONFIG += console
}

