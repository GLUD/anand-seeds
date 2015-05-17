<script type="text/javascript">
    var estado1 = false;
    var estado2 = false;
    var estado3 = false;
    function cambiarIlum(){
        $.ajax({url:"http://192.168.1.238", data:{"ilum":((estado1==false)?"on":"off")}})
        .done(function (){
            estado1 = ~estado1;
        });
    }
    function cambiarVent(){
        $.ajax({url:"http://192.168.1.238", data:{"vent":((estado2==false)?"on":"off")}})
        .done(function (){
            estado2 = ~estado2;
        });
    }
    
    function cambiarRieg(){        
        $.ajax({url:"http://192.168.1.238", data:{"rieg":((estado3==false)?"on":"off")}})
        .done(function (){
            estado3 = ~estado3;
        });
    }
</script>
      
<section class="wrapper">   
    <h1>Activar las variables de iluminación, ventilación y riego.</h1>
<a class ='btn btn-info glyphicon glyphicon-off' onclick="cambiarIlum()"> Iluminación</a>
<a class ='btn btn-info glyphicon glyphicon-off' onclick="cambiarVent()"> Ventilacion</a>
<a class ='btn btn-info glyphicon glyphicon-off' onclick="cambiarRieg()"> Riego</a>
</section>