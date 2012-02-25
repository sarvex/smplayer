#ifndef SEARCHBOX_H
#define SEARCHBOX_H

#include "lineedit_with_icon.h"

class SearchBox : public LineEditWithIcon
{
    Q_OBJECT
public:
    explicit SearchBox(QWidget *parent = 0);
    QSize sizeHint() const;

signals:
    void search(QString);

public slots:
    void startSearch();

protected:
    virtual void setupButton();
};

#endif // SEARCHBOX_H
