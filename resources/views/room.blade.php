<!DOCTYPE html>
<html>
    <head>
        <title>Карта</title>
        <meta charset="utf-8" />
        <style>
            #manage{
                position:fixed;
                left: 55%;
                top:10px;
                border: 1px solid black;
                background-color: #fffff1;
            }
        </style>
        <script type="text/javascript" src="/jquery-3.2.1.js"></script>
        <script>
            var aud116a = 83;
            var currentIP = 0;

            

            function drawRoom(num) {
                var audience = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                audience.setAttributeNS(null, "d", "M50 50 L350 50 L350 750 L100 750 L100 700 L50 700 Z");
                audience.setAttributeNS(null, "stroke-width", 2);
                audience.setAttributeNS(null, "stroke", "black");
                audience.setAttributeNS(null, "fill-opacity", 0);
                document.querySelector("svg").appendChild(audience);

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'getMap.php?number='+num
                }).done(function(data) {
                        drawInv(data);
                        $("#shutdownroom").bind("click", function(event){shutDownRoom(); return false;});
                        checkOnline(); //settimeout
                    });
            }
            
            function drawInv(data){  
                var i;
                $.each(data, function(i){
                    var invObject = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                    var x = data[i].locationX;
                    var y = data[i].locationY;
                    invObject.setAttributeNS(null, "x", 50*x);
                    invObject.setAttributeNS(null, "y", 50*y);
                    invObject.setAttributeNS(null, "title", data[i].name); //наименование из свойства
                    invObject.setAttributeNS(null, "width", 50); //ширина высота из свойств
                    invObject.setAttributeNS(null, "height", 50);
                    invObject.setAttributeNS(null, "class", data[i].type);  //класс из свойства
                    invObject.setAttributeNS(null, "id", 'object' + i);
                    invObject.setAttributeNS(null, "ip", data[i].ip);
                    invObject.setAttributeNS(null, "stroke", "black");
                    if(data[i].online==1)    invObject.setAttributeNS(null, "fill", "blue");
                    else    invObject.setAttributeNS(null, "fill", "white");
                    $(invObject).bind("click", function(event){showInfo(this)});
                    document.querySelector("svg").appendChild(invObject);
                });
            }

            function showInfo(elem){
                isOnline(elem);
                $("#image").attr("src", "");
                elem.setAttribute("fill", "white");
                disableButtons();
                $("#status").text("Оффлайн");
                $("#manage p").text(elem.id);
                $.ajax({
                    url: "direct?ip="+elem.getAttribute("ip")+"&t=1"
                }).done(function(data) {
                    elem.setAttribute("fill", "blue");
                    $("#status").text("Онлайн");
                    $("#manage p").text(data);
                    currentIP = elem.getAttribute("ip");
                    enableButtons();
                    $("#manage").show();
                    $("#info").text(data);
                });
            }

            function disableButtons(){
                $("button").each(function( index, value ) {
                    value.setAttribute("disabled", 1);
                  });
            }

            function enableButtons(){
                $("button").each(function( index, value ) {
                    value.removeAttribute("disabled");
                  });
            }

            function isOnline(e){
                $.ajax({
                    url: "arp?ip="+e.getAttribute("ip"),
                }).done(function(data){
                    if(data==1){
                        e.setAttribute("fill", "blue");
                        return true;
                     }else{
                        e.setAttribute("fill", "white");
                        return false;
                     }
                });
            }
            
            function checkOnline(){
                $('rect.pc').each(function(){
                    isOnline(this);
                });
                setTimeout(checkOnline, 30000);
            }

            function getinfo(ip){
                $.ajax({
                    url: "direct?ip="+ip+"&t=1"
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
                    url: "direct?ip="+ip+"&t=2"
                }).done(function(data) {
                    document.getElementById("image").setAttribute( 'src',  "data:image/png;base64," + data);
                });
            }

            function shutdown(ip){
                console.log(ip);
                $.ajax({
                    url: "direct?ip="+ip+"&t=3"
                });
            }
            
            function shutDownRoom(){
                $('rect.pc').each(function(){
                    shutdown($(this).attr('ip'));
                });
            }

            function message(ip){
                $.ajax({
                    url: "direct?ip="+ip+"&t=4&message="+$("#messageinput").val()
                });
            }

            $(document).ready(function(){
                drawRoom("{{ $number }}");
            });
        </script>
    </head>
    <body>
        <h1>отрисовка кабинета {{$number}}</h1>
        <div>
            <a href="map">выбрать кабинет</a>
            <a id="shutdownroom" href="#">отключить все</a>
        </div>
        <svg width="1000px" height="1000px" id="canvas" />
        <div id="manage" style="display:none">
            <p></p>
            <span>Статус:</span><span id="status"></span>
            <button onClick="getscreen(currentIP)">Скриншот</button>
            <button onClick="shutdown(currentIP)">Выключить</button>
            <input id="messageinput" placeholder="Сообщение" />
            <button onClick="message(currentIP)">Сообщение</button>
            <img id="image" style="max-width: 600px"/>
        </div>
    </body>
</html>
