<?php


require_once "controladores/configuraciones.controlador.php";
require_once "modelos/configuraciones.modelo.php";


if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

if($_SESSION["perfil"] == "Oftalmologico"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

$xml = ControladorVentas::ctrDescargarXML();

if($xml){

  rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

  echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';


}
      $item = null;
      $valor = null;
      $moneda = "";
      $configuraciones = Controladorconfiguraciones::ctrMostrarconfiguraciones($item, $valor);

          foreach ($configuraciones as $key => $value) {

            $moneda = $value["moneda"];


          }

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar ventas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-venta">

          <button class="btn btn-primary">
            
          <i class="ion ion-arrow-right-a"></i> AGREGAR VENTA

          </button>

        </a>

        <button class="btn btn-success btnEntregarPedido" data-target="#modalEntregarPedido" data-toggle="modal">

          <i class="ion ion-arrow-right-a"></i> ENTREGAR PEDIDO

        </button>

        <a href="https://dclaro.impuestos.gob.bo/"><button class="btn btn-danger">

        <i class="fa fa-file-text-o"> BOLETA</i>

        </button></a>

         <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicial"])){

                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                
                }else{
                 
                  echo 'Rango de fecha';

                }

              ?>
            </span>

            <i class="fa fa-caret-down"></i>

         </button>

      </div>

      <div class="box-body">
        
       <<table class="table table-bordered table-striped dt-responsive tablas table-hover" style="width:100%; font-size: 14px;">
         
        <thead class="bg-primary text-white">
         
         <tr>
           
           <th>#</th>
           <th>Venta</th>
           <th>Estado</th>
           <th>Lugar</th>
           <th>Cliente</th>
           <th>Vendedor</th>
           <th>Pago</th>
           <th>Total</th>
           <th>Abono</th>
           <th>Pendiente</th>
           <th>Retiro</th>
           <th>Ingreso</th>
           <th>Entrega</th>
           <th>Observ.</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          if(isset($_GET["fechaInicial"])){

            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];

          }else{

            $fechaInicial = null;
            $fechaFinal = null;

          }

          $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

          foreach ($respuesta as $key => $value) {

                  $totalfinal = isset($value["totalfinal"]) && is_numeric($value["totalfinal"]) ? (float)$value["totalfinal"] : 0;
                  $abono = isset($value["abono"]) && is_numeric($value["abono"]) ? (float)$value["abono"] : 0;
                  $pendiente = isset($value["pendiente"]) && is_numeric($value["pendiente"]) ? (float)$value["pendiente"] : 0;
                  $retiro = isset($value["retiro"]) && is_numeric($value["retiro"]) ? (float)$value["retiro"] : 0;
           
           echo '<tr>

                  <td style=" border: 1px solid #666; width: "100%";">'.($key+1).'</td>

                  <td style=" border: 1px solid #666; width: "100%";">'.$value["codigo"].'</td>';
                  
                  if ($value["estado"] == 'PENDIENTE'){

                    echo '<td style=" border: 1px solid #666; width: "100%";"> <button class="btn btn-danger">'.$value["estado"].'</td>';

                  }else{
        
                    echo '<td style=" border: 1px solid #666; width: "100%";"> <button class="btn btn-success">'.$value["estado"].'</td>';
        
                  }

                  if ($value["estado_bulto"] == 'EN LABORATORIO'){

                    echo '<td style=" border: 1px solid #666; width: "100%";"> <button class="btn btn-warning">'.$value["estado_bulto"].'</td>';

                  }else{
        
                    echo '<td style=" border: 1px solid #666; width: "100%";"> <button class="btn btn-success">'.$value["estado_bulto"].'</td>';
        
                  }
                  

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];
                  $pendiente = $value["pendiente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td style=" border: 1px solid #666; width: "100%";">'.mb_strtoupper($respuestaCliente["apellido"]).' '.mb_strtoupper($respuestaCliente["nombre"]).' '.mb_strtoupper($respuestaCliente["documento"]).'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_vendedor"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td style=" border: 1px solid #666; width: "100%";>'.$respuestaUsuario["nombre"].' </td>

                  <td style=" border: 1px solid #666; width: "100%";>'.$value["metodo_pago"].'</td>

                  <td style=" border: 1px solid #666; width: "100%";>'.$moneda.' <b>'.number_format($totalfinal,2).'</b></td>

                  <td style=" border: 1px solid #666; width: "100%";'.$moneda.' <b>'.number_format($abono,2).'</b></td>

                  <td style=" border: 1px solid #666; width: "100%";>'.$moneda.' <b>'.number_format($pendiente,2).'</b></td> 

                  <td style=" border: 1px solid #666; width: "100%;">'.$moneda.' <b>'.number_format($retiro,2).'</b></td>



                  <td style=" border: 1px solid #666; width: "100%";>'.$value["fecha"].'</td>

                  <td style=" border: 1px solid #666; width: "100%";>'.$value["fechaentrega"].'</td>

                  <td style=" border: 1px solid #666; width: "100%";>'.$value["observaciones"].'</td>

                  <td style=" border: 1px solid #666; width: "100%";>

                    <div class="btn-group">

                                              
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo"].'">

                        <i class="fa fa-file-text-o"></i>

                      </button>

                      <button class="btn btn-primary btnImprimirFactura1" codigoVenta="'.$value["codigo"].'">

                        <i class="fa fa-print"></i>

                      </button>

                      ';

                      if($_SESSION["perfil"] == "Administrador"){

                      echo '<button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'"><i class="fa fa-pencil"></i></button>



                      <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                    }

                    echo '</div>  

                  </td>

                </tr>';
            }

        ?>
               
        </tbody>

       </table>

       <?php

      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();

      ?>
       

      </div>

    </div>

  </section>

</div>

<!-- ===============================================-->
<!-- REALIZAR ENTREGA MODAL-->
<!-- ===============================================-->
<div class="modal fade" id="modalEntregarPedido" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">

            <form action="" method="post">
              <div class="modal-body p-0">
                  <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                      <h4 class="mb-1" id="staticBackdropLabel"> <strong> <i class="fas fa-"></i> RETIRO DE PEDIDOS A TRAVÉS DE ORDEN DE TRABAJO </strong></h4>
                  </div>
                  <br>
                  <div class="p-2">

                      <div class="row">

                          <div class="col-lg-12">


                                  <div class="card theme-wizard mb-5 mb-lg-0 mb-xl-5 mb-xxl-0 h-100">

                                      <div class="card-body py-4">

                                          <div class="tab-content">

                                              <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="form-wizard-progress-tab1" id="form-wizard-progress-tab1">

                                                  <div class="form-row">

                                                    <div class="col-md-12 mb-3">    
                                                    <label class="form-label" for="form-wizard-progress-wizard-name"> N° DE LA ORDEN: </label>                     
                                                      <select class="selectpicker" name="traer_orden" id="traer_orden" class="selectpicker show-tick"

                                                        data-max-options="6" 
                                                        data-live-search="true" 
                                                        data-width="fit" 
                                                        title="CONSULTAR AQUÍ">

                                                        <?php
                                                    
  
                                                          $item = null;
                                                        
                                                          $valor = null;
                                                        
                                                          $rs_entrega = ControladorEntrega::ctrMostrarEntrega($item, $valor);
                                                        
                                                    
                                                          echo '<option></option>';

                                                          foreach($rs_entrega as $keypac =>
                                                          $data_pac){

                                                            //aca muestra el codigo de la venta pero en realidad el value es "id"

                                                            echo '<option value="'.$data_pac["id"].'">N° Orden: '.$data_pac["codigo"].'</option>';

                                                          }
                                                          
                                                        ?>

                                                      </select>

                                                   
                                                    
                                                    </div>
                                                    

                                                    <!-- INPUTS DE EFECTIVO  -->

                                                    

                                                      <div class="col-md-12 mb-3">
                                                        <br><br>
                                                          <label class="form-label" for="form-wizard-progress-wizard-name"><i class="ion ion-arrow-right-a"></i> ABONO REALIZADO</label>
                                                          <input readonly class="form-control" type="text" id="abono"/>
                                                      </div> 

                                                      <div class="col-md-12 mb-3">
                                                          <label class="form-label" for="form-wizard-progress-wizard-name"><i class="ion ion-arrow-right-a"></i> PENDIENTE</label>
                                                          <input readonly class="form-control" type="text" name="entPENDIENTE" id="entPENDIENTE"/>
                                                      </div>
                                        
                                                      <div class="col-md-12 mb-3">   
                                                        <label class="form-label" for="form-wizard-progress-wizard-name"><i class="ion ion-arrow-right-a"></i> TIPO PAGO</label>                                           
                                                        <select onchange="cambio_pagos()" name="entipo_pago" id="tipo_pago" class="form-control" tabindex="7">
                                                          <option value="EFECTIVO">EFECTIVO</option>
                                                          <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                                          <option value="TARJETA">TARJETA</option>
                                                        </select>
                                                      </div> <input type="hidden" name="enid_pedido" id="endeCli">
                                                      
                                                    <div id="row_efectivo">
                                                      <div class="col-md-12 mb-3">
                                                        <label class="form-label" for="form-wizard-progress-wizard-name"><i class="ion ion-arrow-right-a"></i> CON CUANTO PAGA</label>
                                                        <input onkeyup="monto_vuelto()" class="form-control txt-a-edad" type="text" name="entCUANTO_PAGA" id="CUANTO_PAGA" />
                                                        
                                                      </div>
                                                        
                                                        <div class="col-md-12 mb-3">
                                                          <label class="form-label" for="form-wizard-progress-wizard-name"><i class="ion ion-arrow-right-a"></i> VUELTO</label>
                                                          <input readonly class="form-control" type="text" name="entVUELTO" id="VUELTO" />
                                                        </div>
                                                    </div>

                                                    <!-- INPUTS DE TRANSFERENCIAS  -->
                                                    <div id="row_transferencia" style="display:none">
                                                      <div class="col-md-12 mb-3">
                                                          <label class="form-label" for="form-wizard-progress-wizard-name"><i class="ion ion-arrow-right-a"></i> CODIGO DE TRANSFERENCIA</label>
                                                          <input class="form-control" type="text" name="entCOD_TRANS" id="COD_TRANS" />
                                                      </div>
                                                        
                                                    </div>

                                                    <!-- INPUTS DE TARJETAS  -->
                                                    <div id="row_tarjeta"  style="display:none">
                                                      <div class="col-md-12 mb-3">
                                                            <label class="form-label" for="form-wizard-progress-wizard-name"><i class="ion ion-arrow-right-a"></i> CODIGO PAGO TARJETA</label>
                                                            <input class="form-control" type="text" name="entCODIGO_TARJETA" id="CODIGO_TARJETA" />
                                                      </div>
                                                        
                                                    </div>
                                                    
                                                  </div> 

                                              </div>

                                          </div>

                                      </div>

                                  </div>    

                          </div>

                      </div>

                  </div>

              </div>
              <div class="modal-footer">
                  <button class="btn btn-outline-secondary me-1 mb-1" type="button" data-dismiss="modal">Cerrar</button>
                  <button class="btn btn-outline-success me-1 mb-1" type="submit">Entregar Pedido</button>
              </div>

            </form>
            <?php
                        $regentrega = new ControladorEntrega();
                        $regentrega->ctrCrearEntrega();

            ?>


        </div>

    </div>

    <?php
    //var_dump($_POST);
     ?>
<script>
  function cambio_pagos(){
  getSelectValue = document.getElementById("tipo_pago").value;
  if(getSelectValue=="EFECTIVO"){
    document.getElementById("row_efectivo").style.display = "inline-block";
    document.getElementById("row_transferencia").style.display = "none";
    document.getElementById("row_tarjeta").style.display = "none";
  }else if(getSelectValue=="TRANSFERENCIA"){
    document.getElementById("row_efectivo").style.display = "none";
    document.getElementById("row_transferencia").style.display = "inline-block";
    document.getElementById("row_tarjeta").style.display = "none";
  }else if(getSelectValue=="TARJETA"){
    document.getElementById("row_efectivo").style.display = "none";
    document.getElementById("row_transferencia").style.display = "none";
    document.getElementById("row_tarjeta").style.display = "inline-block";
  }
}

function monto_vuelto(){
  let pendiente = document.getElementById('entPENDIENTE').value;
  let monto_pago = document.getElementById('CUANTO_PAGA').value;

  let vuelto = Number(monto_pago) - Number(pendiente);
  document.getElementById('VUELTO').value = vuelto;
}
</script>

</div>



