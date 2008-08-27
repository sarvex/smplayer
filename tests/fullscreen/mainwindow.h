
#include <QMainWindow>

class QWidget;
class QAction;
class QToolBar;

class MainWindow : public QMainWindow
{
    Q_OBJECT

public:
    MainWindow( QWidget* parent = 0, Qt::WindowFlags flags = 0 );
    ~MainWindow();

public slots:
    void setFullscreen(bool b);
    void pickColor();

protected:
    void setPanelColor(QColor c);

protected:
    QAction * fullscreen_action;
    QAction * pickcolor_action;
    QAction * exit_action;

    QWidget * panel;

    QToolBar * toolbar;
};
