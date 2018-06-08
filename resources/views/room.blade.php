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
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>
            var aud116a = 83;
            var currentIP = 0;
            function updateMap(num) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'getMap.php?number='+num,
                    success: function (data) {
                        var audience116a = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                        audience116a.setAttributeNS(null, "d", "M50 50 L350 50 L350 750 L100 750 L100 700 L50 700 Z");
                        audience116a.setAttributeNS(null, "stroke-width", 2);
                        audience116a.setAttributeNS(null, "stroke", "black");
                        audience116a.setAttributeNS(null, "fill-opacity", 0);
                        document.querySelector("svg").appendChild(audience116a);
                        
                        var i;
                        for(i = 1; i < aud116a + 1; i++)
                        {
                            if ((data['comp' + i].locationX))
                            {
                                if ( ((data['comp' + i].locationX !=1)||(data['comp' + i].locationY !=14))&&((data['comp' + i].locationX < 7)||(data['comp' + i].locationY < 15)) )
                                {
                                var comp = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                                var x = data['comp' + i].locationX;
                                var y = data['comp' + i].locationY;
                                comp.setAttributeNS(null, "x", 50*x);
                                comp.setAttributeNS(null, "y", 50*y);
                                comp.setAttributeNS(null, "width", 50);
                                comp.setAttributeNS(null, "height", 50);
                                comp.setAttributeNS(null, "id", 'comp' + i);
                                comp.setAttributeNS(null, "ip", data['comp' + i].ip);
                                comp.setAttributeNS(null, "stroke", "black");
                                comp.setAttributeNS(null, "fill", "white");
                                $(comp).bind("click", function(event){showInfo(this)});
                                document.querySelector("svg").appendChild(comp);
                                }
                            }
                            else
                            {
                                var forRemove = document.getElementById('comp'+i);
                                document.querySelector("svg").removeChild(forRemove);
                            }
                        }

                    }
                });
            }

            function showInfo(elem){
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
                    url: "online?ip="+e.getAttribute("ip"),
                }).done(function(data){
                    return data;
                });
                if(true){
                    e.setAttribute("fill", "blue");
                    return true;
                }else{
                    e.setAttribute("fill", "white");
                    return false;
                }
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
                $.ajax({
                    url: "direct?ip="+ip+"&t=3"
                });
            }

            function message(ip){
                $.ajax({
                    url: "direct?ip="+ip+"&t=4&message="+$("#messageinput").val()
                });
            }

            $(document).ready(function(){
                updateMap("{{ $number }}");
            });
        </script>
    </head>
    <body>
        <h1>отрисовка кабинета {{$number}}</h1>
        <div>
            <a href="map">выбрать кабинет</a>
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
