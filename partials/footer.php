    </section>
</section>
<!-- **********************************************************************************************************************************************************
  RIGHT SIDEBAR CONTENT
  *********************************************************************************************************************************************************** -->                  

  <!--main content end-->
  <!--footer start-->
  <footer class="site-footer">
      <div class="text-center">
            <ul class="redes">
                <li><a href="https://www.facebook.com/anandseeds">Facebook</a></li>
                <li><a href="https://twitter.com/AnandSeeds">Twitter</a></li>
            </ul>
          <span style="display:inline-block;">2015 - Grupo GNU/Linux Universida Distrital</span>
          <a href="/" class="go-top">
              <i class="fa fa-angle-up"></i>
          </a>
          
      </div>
      
  </footer>
  <!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery-1.8.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="assets/js/jquery.sparkline.js"></script>


<!--common script for all pages-->
<script src="assets/js/common-scripts.js"></script>

<script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="assets/js/gritter-conf.js"></script>

<!--script for this page-->
<script src="assets/js/sparkline-chart.js"></script>    
<script src="assets/js/zabuto_calendar.js"></script>	

<script type="text/javascript">
    $(document).ready(function () {
        if(localStorage.getItem("haingresado")==null){
            var unique_id = $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Bienvenido a Anand Seeds!',
                // (string | mandatory) the text inside the notification
                text: 'Este proyecto se desarrolla en Hackaton patrocinada por Bunny Inc. <a href="http://bunnyinc.com" target="_blank" style="color:#ffd777">BunnyInc.com</a>.',
                // (string | optional) the image to display on the left
                image: 'assets/img/bunny_small.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: true,
                // (int | optional) the time you want it to be alive for before fading out
                time: '',
                // (string | optional) the class name you want to apply to that specific message
                class_name: 'my-sticky-class'
            });            
            localStorage.setItem("haingresado", "glud");
        }
    return false;
    });
</script>

<script type="application/javascript">
    $(document).ready(function () {
        $( "#change_ticker" ).change(function() {
            dato = $( this ).val();
            clearTimeout(tempo);
            actualizarRegistros(dato);
        });
        if($("#ticker").length > 0) {
          actualizarRegistros('dato_hum_s');  
        }
        $("#date-popover").popover({html: true, trigger: "manual"});
        $("#date-popover").hide();
        $("#date-popover").click(function (e) {
            $(this).hide();
        });       
        
        $("#my-calendar").zabuto_calendar({
            action: function () {
                return myDateFunction(this.id, false);
            },
            action_nav: function () {
                return myNavFunction(this.id);
            },
            ajax: {
                url: "show_data.php?action=1",
                modal: true
            },
            legend: [
                {type: "text", label: "Special event", badge: "00"},
                {type: "block", label: "Regular event", }
            ]
        });      
    });
    
    var tempo;
    function actualizarRegistros(variable){
        clearTimeout(tempo);
        $.ajax({url:"http://192.168.1.239/DBClass/ultimos_datos.php", data:{"maximo":100}})
        .done(function (a){
            a=JSON.parse(a);
            var arreglo = new Array();
            for(var i=0; i<a.length; i++){
                arreglo.push(a[i][variable]);
            }
            sufijo = {'dato_hum_s':' hum','dato_hum_r':' rel','dato_tem':' °C','dato_rad':' Rads'};
            $('#ticker').sparkline(arreglo,{width : '90%',height:'100%',tooltipSuffix: sufijo[variable]});
        });
        tempo = setTimeout(function (){actualizarRegistros(variable);},1000);
    }

    function myNavFunction(id) {
        $("#date-popover").hide();
        var nav = $("#" + id).data("navigation");
        var to = $("#" + id).data("to");
        console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }
</script>

