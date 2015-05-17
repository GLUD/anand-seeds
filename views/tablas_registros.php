<script type="text/javascript">
    var estado1 = false;
    var estado2 = false;
    var estado3 = false;
    function cambiarIlum(){
        $.ajax({url:"http://192.168.1.238", data:{"ilum":((estado1==true)?"off":"on")},success:function (){
            estado1 = ~estado1;
        }});
    }
    function cambiarVent(){
        $.ajax({url:"http://192.168.1.238", data:{"vent":((estado2==true)?"on":"off")},success:function (){
            estado2 = ~estado2;
        }});
    }
    
    function cambiarRieg(){        
        $.ajax({url:"http://192.168.1.238", data:{"rieg":((estado3==false)?"off":"on")},success:function (){
            estado3 = ~estado3;
        }});
    }
</script>
      
      
<a class ='btn btn-info' onclick="cambiarIlum()">Iluminación</a>
<a class ='btn btn-info' onclick="cambiarVent()">Ventilacion</a>
<a class ='btn btn-info' onclick="cambiarRieg()">Riego</a>