/****************************************************************************
** Meta object code from reading C++ file 'simplehttp.h'
**
** Created: Mon 8. Feb 19:27:40 2010
**      by: The Qt Meta Object Compiler version 62 (Qt 4.6.1)
**
** WARNING! All changes made in this file will be lost!
*****************************************************************************/

#include "../simplehttp.h"
#if !defined(Q_MOC_OUTPUT_REVISION)
#error "The header file 'simplehttp.h' doesn't include <QObject>."
#elif Q_MOC_OUTPUT_REVISION != 62
#error "This file was generated using the moc from 4.6.1. It"
#error "cannot be used with the include files from this version of Qt."
#error "(The moc has changed too much.)"
#endif

QT_BEGIN_MOC_NAMESPACE
static const uint qt_meta_data_SimpleHttp[] = {

 // content:
       4,       // revision
       0,       // classname
       0,    0, // classinfo
       5,   14, // methods
       0,    0, // properties
       0,    0, // enums/sets
       0,    0, // constructors
       0,       // flags
       3,       // signalCount

 // signals: signature, parameters, type, tag, flags
      17,   12,   11,   11, 0x05,
      53,   37,   11,   11, 0x05,
      88,   82,   11,   11, 0x05,

 // slots: signature, parameters, type, tag, flags
     127,  112,   11,   11, 0x09,
     184,  167,   11,   11, 0x09,

       0        // eod
};

static const char qt_meta_stringdata_SimpleHttp[] = {
    "SimpleHttp\0\0host\0connecting(QString)\0"
    "downloaded_text\0downloadFinished(QByteArray)\0"
    "error\0downloadFailed(QString)\0"
    "responseHeader\0readResponseHeader(QHttpResponseHeader)\0"
    "request_id,error\0httpRequestFinished(int,bool)\0"
};

const QMetaObject SimpleHttp::staticMetaObject = {
    { &QHttp::staticMetaObject, qt_meta_stringdata_SimpleHttp,
      qt_meta_data_SimpleHttp, 0 }
};

#ifdef Q_NO_DATA_RELOCATION
const QMetaObject &SimpleHttp::getStaticMetaObject() { return staticMetaObject; }
#endif //Q_NO_DATA_RELOCATION

const QMetaObject *SimpleHttp::metaObject() const
{
    return QObject::d_ptr->metaObject ? QObject::d_ptr->metaObject : &staticMetaObject;
}

void *SimpleHttp::qt_metacast(const char *_clname)
{
    if (!_clname) return 0;
    if (!strcmp(_clname, qt_meta_stringdata_SimpleHttp))
        return static_cast<void*>(const_cast< SimpleHttp*>(this));
    return QHttp::qt_metacast(_clname);
}

int SimpleHttp::qt_metacall(QMetaObject::Call _c, int _id, void **_a)
{
    _id = QHttp::qt_metacall(_c, _id, _a);
    if (_id < 0)
        return _id;
    if (_c == QMetaObject::InvokeMetaMethod) {
        switch (_id) {
        case 0: connecting((*reinterpret_cast< QString(*)>(_a[1]))); break;
        case 1: downloadFinished((*reinterpret_cast< QByteArray(*)>(_a[1]))); break;
        case 2: downloadFailed((*reinterpret_cast< QString(*)>(_a[1]))); break;
        case 3: readResponseHeader((*reinterpret_cast< const QHttpResponseHeader(*)>(_a[1]))); break;
        case 4: httpRequestFinished((*reinterpret_cast< int(*)>(_a[1])),(*reinterpret_cast< bool(*)>(_a[2]))); break;
        default: ;
        }
        _id -= 5;
    }
    return _id;
}

// SIGNAL 0
void SimpleHttp::connecting(QString _t1)
{
    void *_a[] = { 0, const_cast<void*>(reinterpret_cast<const void*>(&_t1)) };
    QMetaObject::activate(this, &staticMetaObject, 0, _a);
}

// SIGNAL 1
void SimpleHttp::downloadFinished(QByteArray _t1)
{
    void *_a[] = { 0, const_cast<void*>(reinterpret_cast<const void*>(&_t1)) };
    QMetaObject::activate(this, &staticMetaObject, 1, _a);
}

// SIGNAL 2
void SimpleHttp::downloadFailed(QString _t1)
{
    void *_a[] = { 0, const_cast<void*>(reinterpret_cast<const void*>(&_t1)) };
    QMetaObject::activate(this, &staticMetaObject, 2, _a);
}
QT_END_MOC_NAMESPACE
