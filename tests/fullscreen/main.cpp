
#include "mainwindow.h"
#include <QApplication>

int main( int argc, char ** argv )
{
    QApplication a( argc, argv );
    a.connect( &a, SIGNAL( lastWindowClosed() ), &a, SLOT( quit() ) );

    MainWindow * w = new MainWindow();
    w->show();

    int r = a.exec();

    delete w;

    return r;
}

