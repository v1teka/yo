#ifndef TCPCLIENT_H
#define TCPCLIENT_H

#include <QObject>
#include <QTcpSocket>
#include <QThread>

class TCPClient : public QThread
{
Q_OBJECT
public:
explicit TCPClient(QString hostname = "127.0.0.1/server_project1/public/", int port = 80);
void write(QByteArray data);

private:
QTcpSocket *socket;
quint16 blockSize;

private slots:
void error(QAbstractSocket::SocketError error);
void read();
};

#endif // TCPCLIENT_H
