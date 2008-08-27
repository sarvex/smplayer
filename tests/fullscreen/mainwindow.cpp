
#include "mainwindow.h"
#include <QStatusBar>
#include <QMenuBar>
#include <QAction>
#include <QMenu>
#include <QColorDialog>

MainWindow::MainWindow( QWidget* parent, Qt::WindowFlags flags )
    : QMainWindow(parent, flags)
{
    setWindowTitle("Test Fullscreen");

    panel = new QWidget( this );
    panel->setSizePolicy( QSizePolicy::Expanding, QSizePolicy::Expanding );
    panel->setMinimumSize( QSize(1,1) );
    panel->setFocusPolicy( Qt::StrongFocus );

    // Color
    panel->setAutoFillBackground(true);
    setPanelColor( QColor(0,0,0) );

    setCentralWidget(panel);

    // Actions
    exit_action = new QAction("&Exit", this);
    exit_action->setShortcut( QKeySequence("Ctrl+X") );
    connect(exit_action, SIGNAL(triggered()), this, SLOT(close()));

    fullscreen_action = new QAction("&Fullscreen", this);
    fullscreen_action->setCheckable(true);
    fullscreen_action->setShortcut( QKeySequence("F") );
    connect(fullscreen_action, SIGNAL(toggled(bool)), 
                   this, SLOT(setFullscreen(bool)));

    pickcolor_action = new QAction("&Pick color", this);
    connect(pickcolor_action, SIGNAL(triggered()), this, SLOT(pickColor()));

    QMenu * file_menu = menuBar()->addMenu(tr("&Actions"));
    file_menu->addAction(fullscreen_action);
    file_menu->addAction(pickcolor_action);
    file_menu->addAction(exit_action);

    this->addAction(fullscreen_action); // So the shortcut works without the menu

    statusBar()->showMessage("Hello", 0);
}

MainWindow::~MainWindow()
{
}

void MainWindow::setPanelColor(QColor c) {
    QPalette p = panel->palette();
    p.setColor(panel->backgroundRole(), c);
    panel->setPalette(p);
}

void MainWindow::pickColor() {
    QColor c = QColorDialog::getColor();
    if (c.isValid()) setPanelColor(c);
}

void MainWindow::setFullscreen(bool b) {
    if (b) {
        menuBar()->hide();
        statusBar()->hide();
        showFullScreen();
    } else {
        showNormal();
        menuBar()->show();
        statusBar()->show();
    }
}
