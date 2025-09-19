<?php

require_once "controladores/configuraciones.controlador.php";
require_once "modelos/configuraciones.modelo.php";


error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

$respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayVentas = array();
$sumaPagosMes = array();

foreach ($respuesta as $key => $value) {

    #Capturamos sólo el año y el mes
    $fecha = substr($value["fecha"],0,7);

    #Introducir las fechas en arrayFechas
    array_push($arrayFechas, $fecha);

    #Capturamos las ventas
    $arrayVentas = array($fecha => $value["totalfinalreporte"]);

    #Sumamos los pagos que ocurrieron el mismo mes
    foreach ($arrayVentas as $key => $value) {
        
        $sumaContadoMes[$key] += $value;
    }

}


$respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayVentas = array();
$sumaPagosMes = array();

foreach ($respuesta as $key => $value) {

    #Capturamos sólo el año y el mes
    $fecha = substr($value["fecha"],0,7);

    #Introducir las fechas en arrayFechas
    array_push($arrayFechas, $fecha);

    #Capturamos las ventas
    $arrayVentas = array($fecha => $value["abono"]);

    #Sumamos los pagos que ocurrieron el mismo mes
    foreach ($arrayVentas as $key => $value) {
        
        $sumaPagosMes[$key] += $value;
    }

}

$respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayVentas = array();
$sumaRetiroMes = array();

foreach ($respuesta as $key => $value) {

    #Capturamos sólo el año y el mes
    $fecha = substr($value["fecha"],0,7);

    #Introducir las fechas en arrayFechas
    array_push($arrayFechas, $fecha);

    #Capturamos las ventas
    $arrayVentas = array($fecha => $value["retiro"]);

    #Sumamos los pagos que ocurrieron el mismo mes
    foreach ($arrayVentas as $key => $value) {
        
        $sumaRetiroMes[$key] += $value;
    }

}


$noRepetirFechas = array_unique($arrayFechas);

$item = null;
$valor = null;

$moneda = "";
          $configuraciones = Controladorconfiguraciones::ctrMostrarconfiguraciones($item, $valor);

          foreach ($configuraciones as $key => $value) {

            $moneda = $value["moneda"];


          }


?>

<!--=====================================
GRÁFICO DE VENTAS
======================================-->

<div class="box box-solid bg-teal-gradient">
    
    <div class="box-header">
        
        <i class="fa fa-th"></i>

        <h3 class="box-title">Gráfico de servicios pagados</h3>

    </div>

    <div class="box-body border-radius-none nuevoGraficoVentas">

        <div class="chart" id="line-chart-pagados" style="height: 250px;"></div>

    </div>

</div>


<div class="box box-solid bg-teal-gradient">
    
    <div class="box-header">
        
        <i class="fa fa-th"></i>

        <h3 class="box-title">Gráfico de Abonos</h3>

    </div>

    <div class="box-body border-radius-none nuevoGraficoVentas">

        <div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

  </div>

</div>

<div class="box box-solid bg-teal-gradient">
    
    <div class="box-header">
        
        <i class="fa fa-th"></i>

        <h3 class="box-title">Gráfico de Retiros</h3>

    </div>

    <div class="box-body border-radius-none nuevoGraficoVentas">

        <div class="chart" id="line-chart-retiros" style="height: 250px;"></div>

  </div>

</div>

<script>
    
 var line = new Morris.Line({
    element          : 'line-chart-pagados',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

        foreach($noRepetirFechas as $key){

            echo "{ y: '".$key."', Pagado: ".$sumaContadoMes[$key]." },";


        }

        echo "{y: '".$key."', Pagado: ".$sumaContadoMes[$key]." }";

    }else{

       echo "{ y: '0', Pagado: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['Pagado'],
    labels           : ['Pagado'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits: <?php echo "'"; echo $moneda; echo " "; echo "'";  ?>,
    gridTextSize     : 10
  });

</script>

<script>
    
 var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

        foreach($noRepetirFechas as $key){

            echo "{ y: '".$key."', Abono: ".$sumaPagosMes[$key]." },";


        }

        echo "{y: '".$key."', Abono: ".$sumaPagosMes[$key]." }";

    }else{

       echo "{ y: '0', Abono: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['Abono'],
    labels           : ['Abono'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits: <?php echo "'"; echo $moneda; echo " "; echo "'";  ?>,
    gridTextSize     : 10
  });

</script>

<script>
    
 var line = new Morris.Line({
    element          : 'line-chart-retiros',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

        foreach($noRepetirFechas as $key){

            echo "{ y: '".$key."', retiros: ".$sumaRetiroMes[$key]." },";


        }

        echo "{y: '".$key."', retiros: ".$sumaRetiroMes[$key]." }";

    }else{

       echo "{ y: '0', retiros: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['retiros'],
    labels           : ['retiros'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits: <?php echo "'"; echo $moneda; echo " "; echo "'";  ?>,
    gridTextSize     : 10
  });

</script>