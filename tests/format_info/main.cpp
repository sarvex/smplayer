#include <QApplication>
#include <QLabel>
#include <QList>
#include <QImageReader>
#include <QImageWriter>

int main( int argc, char ** argv ) 
{
	QApplication a( argc, argv );

	QList<QByteArray> r_formats = QImageReader::supportedImageFormats();
	QString read_formats;
	for (int n=0; n < r_formats.count(); n++) {
		read_formats.append(r_formats[n]+" ");
	}

	QList<QByteArray> w_formats = QImageWriter::supportedImageFormats();
	QString write_formats;
	for (int n=0; n < w_formats.count(); n++) {
		write_formats.append(w_formats[n]+" ");
	}

	QLabel l;
	l.setText(QString("<b>Supported formats for reading:</b> %1<br>"
                      "<b>Supported formats for writing:</b> %2<br>").arg(read_formats).arg(write_formats));
	l.show();

	return a.exec();
}

