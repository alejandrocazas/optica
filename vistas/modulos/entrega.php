
<div class="content-wrapper">

<?php

if($_SESSION["perfil"] == "Oftalmologico"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

  <section class="content-header">

    <h1>

      ENTREGA DE PEDIDOS

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar atenciones</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">




<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>

  <div class="container-fluid">

    <div class="row">

      <div class="col-lg-12">

        <div class="card shadow mb-4 border-bottom-info">
          
          <div class="collapse show" id="collapseCardExample">

            <div class="card-body">

              <div id="cajitaficha">

                  <div class="form-row">
                  <div class="col-md-12 mb-2">
                     <h3 align="center">ENTREGA DE PEDIDOS</h3><br>
                    </div>
                    <div class="form-row">
                      <div class="col-md-12 mb-1">
                      <label class="form-label" for="form-wizard-progress-wizard-name">Para entregar una orden de trabajo, debes ingresar el N° de Orden para verificar cobros, si está pagado o "Pendiente a Pagar" está en "0", podrás entregarlo con normalidad, no obstante, deberás completar el cierre de pago.</label>
                    </div>
                    <br>
                    <br>

                    <div class="col-md-2 mb-2">

                      <label class="form-label" for="form-wizard-progress-wizard-name">N° DE LA ORDEN.</label>
                      
                      
                      <select class="selectpicker" name="orden" id="orden" class="selectpicker show-tick"

                        data-max-options="4" 
                        data-live-search="true" 
                        data-width="fit" 
                        title="N° de ORDEN">

                        <?php
                          
                          foreach($rs_entrega as $keypac =>
                           $data_pac){

                            echo '<option value="'.$data_pac["id"].'">N° Orden: '.$data_pac["id"].'</option>';

                          }
                          
                        ?>

                      </select>
              
                      <div class="invalid-feedback">Complete el campo.</div>

                    </div>
                <div class="col-md-10 mb-3">
                </div>
                <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">NIT/CI:</label>
                    <input readonly class="form-control" type="text" name="enRut" id="enRut" required>                
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                <div class="col-md-6 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Nombre</label>
                    <input readonly class="form-control" type="text" name="enNombre" id="enNombre" required>                
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Edad</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enEdad" id="enEdad" required/>  
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Telefono</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enTelefono" id="enTelefono" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-8 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Dirección</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enDireccion" id="enDireccion" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>               
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Fecha pedido realizado</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enFecha_pedido" id="enFecha_pedido" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Sucursal</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enSucursal" id="enSucursal" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Precio Calculado</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enSucursal" id="enPrecioCalculado" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Descuento</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enSucursal" id="enDescuento" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Quedo En</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enSucursal" id="enPrecioFinal" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Abonado</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enSucursal" id="enAbono" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
                 <div class="col-md-4 mb-3">  
                 </div>
                 <div class="col-md-2 mb-3">
                   <label class="form-label" for="form-wizard-progress-wizard-name">Pendiente a Pagar</label>
                   <input readonly class="form-control txt-a-edad" type="text" name="enSucursal" id="enPendiente" required />                   
                   <div class="invalid-feedback">Complete el campo.</div>   
                 </div>
              </div>
                 <br>
                  <button href="#" class="btn btn-success btn-icon-split" data-toggle="modal" name="registrar" type="submit" data-target="#modalEntregarPedido">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">ENTREGAR</span>
                  </button>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>
  </div>


<!-- ===============================================-->
<!-- REALIZAR PAGO MODAL-->
<!-- ===============================================-->
<div class="modal fade" id="modalEntregarPedido" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="post">
              <div class="modal-body p-0">
                  <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                      <h4 class="mb-1" id="staticBackdropLabel"><i class="fas fa-"></i> FORMA DE PAGO</h4>
                  </div>

                  <div class="p-2">

                      <div class="row">

                          <div class="col-lg-12">


                                  <div class="card theme-wizard mb-5 mb-lg-0 mb-xl-5 mb-xxl-0 h-100">

                                      <div class="card-body py-4">

                                          <div class="tab-content">

                                              <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="form-wizard-progress-tab1" id="form-wizard-progress-tab1">

                                                  <div class="form-row">

                                                    <div class="col-md-12 mb-3">
                                                      <label class="form-label" for="form-wizard-progress-wizard-name">TIPO PAGO</label>                                           
                                                      <select onchange="cambio_pagos()" name="entipo_pago" id="tipo_pago" class="form-control" tabindex="7">
                                                        <option value="EFECTIVO">EFECTIVO</option>
                                                        <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                                        <option value="TARJETA">TARJETA</option>
                                                      </select>
                                                    </div> <input type="hidden" name="enid_pedido" id="endeCli">
                                                    <!-- INPUTS DE EFECTIVO  -->
                                                    <div id="row_efectivo">
                                                      <div class="col-md-12 mb-3">
                                                          <label class="form-label" for="form-wizard-progress-wizard-name"><i class="far fa-id-"></i>PENDIENTE</label>
                                                          <input readonly class="form-control" type="text" name="entPENDIENTE" id="PENDIENTE"/>
                                                      </div>

                                                        
                                                      <div class="col-md-12 mb-3">

                                                        <label class="form-label" for="form-wizard-progress-wizard-name"><i class="fas fa-"></i> CON CUANTO PAGAS</label>
                                                        <input onkeyup="monto_vuelto()" class="form-control txt-a-edad" type="text" name="entCUANTO_PAGA" id="CUANTO_PAGA" />
                                                        
                                                      </div>
                                                        
                                                        <div class="col-md-12 mb-3">
                                                          <label class="form-label" for="form-wizard-progress-wizard-name"><i class="fas fa-"></i> VUELTO</label>
                                                          <input readonly class="form-control" type="text" name="entVUELTO" id="VUELTO" />
                                                        </div>
                                                    </div>

                                                    <!-- INPUTS DE TRANSFERENCIAS  -->
                                                    <div id="row_transferencia" style="display:none">
                                                      <div class="col-md-12 mb-3">
                                                                <label class="form-label" for="form-wizard-progress-wizard-name"><i class="fas fa-sort"></i> CODIGO DE TRANSFERENCIA</label>
                                                                <input class="form-control" type="text" name="entCOD_TRANS" id="COD_TRANS" />
                                                      </div>
                                                        
                                                    </div>
                                                

                                                    <!-- INPUTS DE TARJETAS  -->
                                                    <div id="row_tarjeta"  style="display:none">
                                                      <div class="col-md-12 mb-3">
                                                                <label class="form-label" for="form-wizard-progress-wizard-name"><i class="fas fa-card"></i> CODIGO PAGO TARJETA</label>
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




      </div>

    </div>

  </section>

</div>















<?php
  
  $item = null;

  $valor = null;

  $rs_entrega = ControladorEntrega::ctrMostrarEntrega($item, $valor);

?>


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
  let pendiente = document.getElementById('PENDIENTE').value;
  let monto_pago = document.getElementById('CUANTO_PAGA').value;

  let vuelto = Number(monto_pago) - Number(pendiente);
  document.getElementById('VUELTO').value = vuelto;
}
</script>

</div>