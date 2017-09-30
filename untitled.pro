QT       += core gui network widgets

TARGET = untitled
TEMPLATE = app


SOURCES += main.cpp\
        mainwindow.cpp

HEADERS  += mainwindow.h mytcpserver.h \
    mytcpclient.h


FORMS    += mainwindow.ui
