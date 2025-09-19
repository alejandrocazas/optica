<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>


<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
    <i class="ion ion-arrow-right-a"></i> CREAR ORDEN DE TRABAJO.
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Crear Orden</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->
      
      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-success">
          
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioVenta">

            <div class="box-body">
  
              <div class="box">

                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div> 

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

                    if(!$ventas){

                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="10001" readonly>';
                  

                    }else{

                      foreach ($ventas as $key => $value) {
                        
                        
                      
                      }

                      $codigo = $value["codigo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'.$codigo.'" readonly>';
                  

                    }

                    ?>
                    
                    
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA DEL CLIENTE
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-users"></i> CI/NIT: </span>
                             
                    <select class="selectpicker" name="seleccionarCliente" id="seleccionarCliente" class="selectpicker show-tick"  required

                    data-max-options="4" 
                    data-live-search="true" 
                    data-width="fit"
                    title="CONSULTAR AQUÍ">

                    <?php

                      $item = null;
                      $valor = null;

                      $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

                       echo '<option></option>';

                       foreach ($clientes as $key => $value) {

                         echo '<option class="text-uppercase" value="'.$value["id"].'">'.$value["documento"].' - '.$value["nombre"].' '.$value["apellido"].'</option>';

                       }

                    ?>

                    </select>
                
                    <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal"><i class="ion ion-arrow-right-a"></i> CREAR CLIENTE</button></span>
                  
                  </div>
                
                </div>

                <!--=====================================
                ENTRADA PARA ESPACIO OFTALMOLÓGICO
                ======================================--> 

                <div class="form-group">
                  
                  <div class="input-group">
                    
                  <button type="button" class="btn btn-danger btnVerReceta" data-target="#modalVerhistoria" data-toggle="modal"><i class="ion ion-arrow-right-a"></i> VER RECETA MÉDICA</button>
                  <span> <button type="button" class="btn btn-danger btnTecnologo" data-target="#modalAlertarTecnologo" data-toggle="modal"><i class="ion ion-arrow-right-a"></i> ALERTA TECNÓLOGO</button></span>
                  
                  </div>

                </div>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================--> 

                <div class="form-group row nuevoProducto">         

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>

                <hr>

                <div class="row">

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  
                  <div class="col-xs-12 pull-right">
                    
                    <table class="table">

                      <thead>

                        <tr>
                          <th>Impuesto</th>
                          <th>Sub Total</th>      
                        </tr>

                      </thead>

                      <tbody>
                      
                        <tr>
                          
                          <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <input type="number" class="form-control input-lg" min="0" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0" required>

                               <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" required>

                               <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>

                              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                        
                            </div>

                          </td>

                           <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-arrow-right-a"></i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" onkeyup="s()" onfocus="SumarDatosFinancieros()" total="" placeholder="000" readonly required>

                              <input type="hidden" name="totalVenta" id="totalVenta">
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  <!--=====================================
                  ENTRADA DESCUENTO / TOTAL 
                  ======================================-->


                    <table class="table">

                      <thead>

                        <tr>
                          <th>Descuento</th>
                          <th>Total</th>      
                        </tr>

                      </thead>

                      <tbody>
                      
                        <tr>
                          
                          <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <input type="number" class="form-control input-lg" min="0" id="nuevoDescuentoVenta" name="nuevoDescuentoVenta" onfocus="s()" onkeyup="SumarDatosFinancieros()" placeholder="0" required>

                              <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                        
                            </div>

                          </td>

                           <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-arrow-right-a"></i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalFinal" name="nuevoTotalFinal" onfocus="s()" onkeyup="SumarDatosFinancieros()" total="" placeholder="000" readonly required>

                              <input type="hidden" name="totalVentaFinal" id="totalVentaFinal">
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                <hr>

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-group row">
                  
                  <div class="col-xs-6" style="padding-right:0px">
                    
                     <div class="input-group">

                      <select class="form-control" id="nuevoFormaPago" onclick="cambio_forma()" name="nuevoFormaPago" required>
                        <option value="0">FORMA DE PAGO</option>
                        <option value="CONTADO">Contado</option>
                        <option value="ABONO">Abono</option>
                        <option value="RETIRO">Retiro</option>    
               
                      </select>    

                    </div>

                  </div>

                </div>

                  <!--=====================================
                  ENTRADA ABONO Y SALDO PENDIENTE
                  ======================================-->

                    <table class="table">

                      <thead>

                        <tr>
                          <th>Abono</th>
                          <th>Saldo Pendiente</th>      
                        </tr>

                      </thead>

                      <tbody>
                      
                        <tr>
                          
                          <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <input type="number" class="form-control input-lg" min="0" id="Abono" name="Abono" onkeyup="SumarDatosFinancieros()" placeholder="0">

                              <input type="hidden" name="abonoNeto" id="abonoNeto" required>

                              <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                        
                            </div>

                          </td>

                           <td style="width: 50%">
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-arrow-right-a"></i></span>

                              <input type="text" class="form-control input-lg" id="SaldoPendiente" name="SaldoPendiente" onkeyup="SumarDatosFinancieros()"  total="" placeholder="000" readonly>
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

                <hr>

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-group row">
                  
                  <div class="col-xs-6" style="padding-right:0px">
                    
                     <div class="input-group">

                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Método de pago</option>
                        <option value="RETIRAR">Al retirar</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="TC">Tarjeta Crédito</option>
                        <option value="TD">Tarjeta Débito</option>    
                        <option value="#MULTIPAGO#">Multipago</option>                  
                      </select>    

                    </div>

                  </div>

                  <div class="cajasMetodoPago"></div>

                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                </div>

                <!--=====================================
                ENTRADA OBSERVACIÓNES
                ======================================-->

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="ion ion-arrow-right-a"> Observación: </i></span>

                    <input type="text" class="form-control  input-lg" id="Observaciones" name="Observaciones" required>
                
                  </div>
                
                </div>

                <div class="form-group">

                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="ion ion-arrow-right-a"> Fecha de Entrega: </i></span>
                        
                    <input type="datetime-local" class="form-control input-lg" id="FechaEntrega" name="FechaEntrega" required>
                  
                  </div>
                
                </div>

                <br>
      
              </div>

          </div>

          <div class="box-footer">

            <button type="submit" id="CrearVenta" class="btn btn-danger pull-right"><i class="ion ion-arrow-right-a"></i> REALIZAR VENTA</button>

          </div>

        </form>

        <?php

          $guardarVenta = new ControladorVentas();
          $guardarVenta -> ctrCrearVenta();
          
        ?>

        </div>
            
      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        
        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">
            
            <table class="table table-bordered table-striped dt-responsive tablaVentas">
              
               <thead>

                 <tr>
                  <th style="width: 10px">#</th>
                  <th>Imagen</th>
                  <th>Descripcion</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>


      </div>

    </div>
   
  </section>

</div>

                <!--=====================================
                MODAL VER RECETASS
                ======================================-->

                <div id="modalVerhistoria" class="modal fade" role="dialog">

                  <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <!--=====================================
                        CABEZA DEL MODAL
                        ======================================-->

                        <div class="modal-header" style="background:#666F88; color:white">

                          <button type="button" class="close" data-dismiss="modal">&times;</button>

                          <h4 class="modal-title"><strong><i class="ion ion-arrow-right-a"></i> BUSCAR RECETA MÉDICA</strong></h4>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ======================================-->

                        <div class="modal-body">

                          <div class="box-body">

                            <div class="panel"><h3><b>DATOS DEL PACIENTE</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-4">
                                  <label class="form-label" for="form-wizard-progress-wizard-name"> CI/NIT: </label>                     
                                  <select class="selectpicker" name="traer_historia" id="traer_historia" class="selectpicker show-tick"

                                    data-max-options="6" 
                                    data-live-search="true" 
                                    data-width="fit" 
                                    title="CONSULTAR AQUÍ">

                                    <?php
                                

                                      $item = null;
                                    
                                      $valor = null;
                                    
                                      $cliente = ControladorHistorias::ctrMostrarHistorias($item, $valor);
                                    
                                
                                      echo '<option></option>';

                                      foreach($cliente as $keypac =>
                                      $data_pac){

                                        //aca muestra el CI del cliente pero en realidad el value es "id"

                                        echo '<option value="'.$data_pac["id"].'"> CI: '.$data_pac["documentoid"].' | N° Atención: '.$data_pac["id"].'</option>';

                                      }
                                      
                                    ?>

                                  </select> 
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Primer Nombre</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" required >
                                <input readonly type="hidden" name="id_historia" id="id_historia" required >
                              </div>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Primer Apellido</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoapellido" id="nuevoapellido" required >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputtelefono">Telefóno</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevotelefono" id="nuevotelefono" >
                              </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputnombre1">Fecha</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevafecha" id="nuevafecha" required >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputdireccion">Dirección</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevadireccion" id="nuevadireccion" >
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputhistoria">Anamnesis</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoanamnesis" id="nuevoanamnesis" placeholder="Ingresar Anamnesis" id="nuevoanamnesis" required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputhistoria">Antecedentes</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoantecedentes" id="nuevoantecedentes" placeholder="Ingresar Anamnesis" id="nuevoantecedentes" required>
                              </div>
                            </div><br>

                            <div class="panel"><h3><b>AGUDEZA VISUAL</b></h3></div>
                            <label><h3>PL</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>ODsc</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoODsc" id="nuevoODsc" placeholder="ODsc"  >
                              </div>
                            
                              <div class="form-group col-md-6">
                                <label>ODcc</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoODcc" id="nuevoODcc" placeholder="ODcc"  >
                              </div>
                            </div>
                            
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label>OIsc</label>
                                  <input readonly type="text" class="form-control input-lg" name="nuevoOIsc" id="nuevoOIsc" placeholder="OIsc"  >
                                </div>
                              
                              <div class="form-group col-md-6">
                                  <label>OIcc</label>
                                  <input readonly type="text" class="form-control input-lg" name="nuevoOIcc" id="nuevoOIcc" placeholder="OIcc"  >
                              </div>
                            </div>

                            <label><h3>PC</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>CC</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevacc" id="nuevacc" placeholder="M."  >
                              </div>
                            </div>
                            </div>
                            <div class="panel"><h3><b>REFRACCIÓN LEJOS</b></h3></div>
                            <label><h3>OJO DERECHO</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoesferaodlj" id="nuevoesferaodlj" placeholder="Ingresar esfera ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevocilindroodlj" id="nuevocilindroodlj" placeholder="Ingresar cilindro ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoejeodlj" id="nuevoejeodlj" placeholder="Ingresar eje ojo derecho" >
                              </div>
                            </div>
                            
                            <label><h3>OJO IZQUIERDO</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoesferaoilj" id="nuevoesferaoilj" placeholder="Ingresar esfera ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevocilindrooilj" id="nuevocilindrooilj" placeholder="Ingresar cilindro ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoejeoilj" id="nuevoejeoilj" placeholder="Ingresar eje ojo izquierdo" >
                              </div>
                            </div>

                            <div class="panel"><h3><b>REFRACCIÓN CERCA</b></h3></div>
                            <label><h3>OJO DERECHO</h3></label>
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoesferaodcc" id="nuevoesferaodcc" placeholder="Ingresar esfera ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevocilindroodcc" id="nuevocilindroodcc" placeholder="Ingresar cilindro ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoejeodcc" id="nuevoejeodcc" placeholder="Ingresar eje ojo izquierdo" >
                              </div>
                            </div>

                            
                            <label><h3>OJO IZQUIERDO</h3></label>

                            
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoesferaoicc" id="nuevoesferaoicc" placeholder="Ingresar esfera ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevocilindrooicc" id="nuevocilindrooicc" placeholder="Ingresar cilindro ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoejeoicc" id="nuevoejeoicc" placeholder="Ingresar eje ojo derecho" >
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="inputobservaciones">ADD</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevaADD" id="nuevaADD" placeholder="ADD"  >
                              </div>
                            
                              <div class="form-group col-md-6">
                                <label for="inputobservaciones">DP</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevaDP" id="nuevaDP" placeholder="DP"  >
                              </div>
                            </div>

                            <div class="panel"><h3><b>DIAGNÓSTICO</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                              <label for="inputobservaciones">Patologías</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevaPatologia" id="nuevaPatologia" placeholder="Patologías"  >
                              </div>
                            </div><br>

                            <label><h3><b>TONOMETRÍA</b></h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label>OD</label>
                                <label>mmHg.</label><input readonly type="text" class="form-control input-lg" name="nuevatonoOD" id="nuevatonoOD" placeholder="mmHg."  >
                              
                              </div>
                            </div>
                            <?//borrar?>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label>OI</label>
                                <label>mmHg.</label><input readonly type="text" class="form-control input-lg" name="nuevatonoOI" id="nuevatonoOI" placeholder="mmHg."  >
                              </div>
                              <div class="form-group col-md-4">
                                <label>Hora:</label> 
                                <input readonly type="text" class="form-control input-lg" name="nuevatonohora" id="nuevatonohora" placeholder="Hora Exácta">
                              </div>
                            </div>

                            <div class="panel"><h3><b>AGREGAR OBERVACIONES</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputobservaciones">Observaciones General</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevaobservaciones" id="nuevaobservaciones" placeholder="Ingresar observaciones"  >
                              </div>
                            </div>

                          </div>

                        
                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                          
                          <button class="btn btn-primary btnImprimirhistoria" id="historiaventa">
                         
                          <i class="fa fa-file-text-o"></i>

                          </button>

                        </div>

                    </div>

                  </div>

                </div>

                <!--=====================================
                MODAL ALERTAR TECNOLOGO
                ======================================-->

                <div id="modalAlertarTecnologo" class="modal fade" role="dialog">
                  
                  <div class="modal-dialog">

                    <div class="modal-content">

                      <form role="form" method="post">

                        <!--=====================================
                        CABEZA DEL MODAL
                        ======================================-->

                        <div class="modal-header" style="background:#666F88; color:white">

                          <button type="button" class="close" data-dismiss="modal">&times;</button>

                          <h4 class="modal-title"><i class="ion ion-arrow-right-a"></i> ALERTAR A TECNÓLOGO PARA SU PREPARACIÓN</h4>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ======================================-->

                        <div class="modal-body">
                        <Strong>Una vez seleccionado al cliente en la venta, los datos se cargarán aquí, luego entregale una observación al especialista, ayudará a tratar de mejor manera al paciente.</Strong>
                          <div class="box-body">

                            <!-- ENTRADA PARA EL NOMBRE -->

                            <div class="form-group">
                              
                              <div class="input-group">
                              
                                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                                <input readonly type="text" class="form-control input-lg" name="clienteAlerta" id="clienteAlerta" placeholder="Datos Paciente">
                             
                              </div>

                            </div>

                            <!-- ENTRADA PARA EL DOCUMENTO ID -->
                            
                            <div class="form-group">
                              
                              <div class="input-group">
                              
                                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                                <input type="text" class="form-control input-lg" name="observacionAlerta" placeholder="Observación">

                              </div>

                            </div>
                          
                          </div>

                        </div>

                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                          
                          <button type="submit" class="btn btn-primary"><i class="ion ion-arrow-right-a"></i> ALERTAR TECNÓLOGO</button>

                        </div>

                        </form>

                        <?php

                        $crearAlerta = new ControladorAlerta();
                        $crearAlerta -> ctrCrearAlerta();

                        ?>

                      </div>

                    </div>

                  </div>

<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#666F88; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title"><i class="ion ion-arrow-right-a"></i> CREAR CLIENTE</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
        <Strong>Mínimo: Nombre, CI y Teléfono.</Strong>
          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA LA apellido -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoapellido" placeholder="Ingresar apellido" >

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" min="0" class="form-control input-lg" name="nuevoDocumentoId" maxlength="10" required " placeholder="CI/NIT">

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email">

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección">

              </div>

            </div>

           
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary"><i class="ion ion-arrow-right-a"></i> Guardar cliente</button>

        </div>

      </form>

      <?php

        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();

      ?>






<script>
  function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
</script>

    </div>

  </div>

</div>