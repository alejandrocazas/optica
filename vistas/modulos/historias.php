
<div class="content-wrapper">

<?php

if($_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

  <section class="content-header">

    <h1>

      Espacio Oftalmológico

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar atenciones</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <?php

        if ($_SESSION["perfil"] == "Oftalmologico" || $_SESSION["perfil"] == "Administrador" ) {

          echo '<button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarhistoria">

          Realizar atención

          </button>';


        }

        ?>

      </div>

      <div class="box-body">

       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

        <thead>

         <tr>

           <th style="width:10px">#</th>
           <th>Datos</th>
           <th>Atención</th>
           <th>AV.</th>
           <th>Refracción lejos</th>
           <th>Refracción cerca</th>
           <th>Distancia Interpupilar</th>
           <th>Diagnóstico</th>
           <th>Tonometría</th>
           <th>Observaciones</th>
           <th>Fecha</th>
           <th>Acciones</th>

         </tr> 

       </thead>

       <tbody>

        <?php

        $item = null;
        $valor = null;

        $historias = Controladorhistorias::ctrMostrarhistorias($item, $valor);

        if ($_SESSION["perfil"] == "Administrador" ) {

         foreach ($historias as $key => $value){

          echo ' <tr>
          <td>'.($key+1).'</td>

          <td>
          
          <b>CI:</b> '.$value["documentoid"].'<br>
          <b>Nombre:</b> '.$value["nombre"].'<br>'.$value["apellido"].'<br>
          <b> Dirección:</b> '.$value["direccion"].'</b><br>
          <b> Telefono:</b> '.$value["telefono"].'</b><br>
          <b> Fecha de Nacimiento:</b> '.$value["edad"].'</b><br>

          </td>
          
          <td>
          
          <b>Receta:</b> '.$value["id"].'<br>
          <b>Anamnesis:</b> '.$value["anamnesis"].'<br>
          <b>Antecedentes:</b> '.$value["antecedentes"].'<br>

          </td>

          <td>
          
          PL<br><br>
          <b>ODsc:</b> '.$value["odsc"].'<br>
          <b>ODcc:</b> '.$value["odcc"].'<br>
          <b>OIsc:</b> '.$value["oisc"].'<br>
          <b>OIcc:</b> '.$value["oicc"].'<br><br>
          PC<br><br>
          <b>Cc:</b> '.$value["cc"].'<br>
          
          
          </td>

          <td>

          Ojo derecho <br>
          <b>Esfera:</b> '.$value["esferaodlj"].'<br>
          <b>Cilindro:</b> '.$value["cilindroodlj"].'<br>
          <b>Eje:</b> '.$value["ejeodlj"].'<br>

          Ojo izquierdo <br>
          <b>Esfera:</b> '.$value["esferaoilj"].'<br>
          <b>Cilindro:</b> '.$value["cilindrooilj"].'<br>
          <b>Eje:</b> '.$value["ejeoilj"].'<br><br>

          </td>

          <td>

          Ojo derecho <br>
          <b>Esfera:</b> '.$value["esferaodcc"].'<br>
          <b>Cilindro:</b> '.$value["cilindroodcc"].'<br>
          <b>Eje:</b> '.$value["ejeodcc"].'<br>

          Ojo izquierdo <br>
          <b>Esfera:</b> '.$value["esferaoicc"].'<br>
          <b>Cilindro:</b> '.$value["cilindrooicc"].'<br>
          <b>Eje:</b> '.$value["ejeoicc"].'<br>
          

          </td>

          
          <td>
    
          <b> ADD:</b> '.$value["adicion"].'<br>
          <b> DP:</b> '.$value["dp"].'<br>

          </td>
          

          <td>
    
          <b> Patologías Medicas:</b> '.$value["diagnostico"].'<br>

          </td>

          <td>
    
          <b> OD mmHg.:</b> '.$value["tonood"].'<br>
          <b> OI mmHg.:</b> '.$value["tonooi"].'<br>
          <b> Momento Exácto:</b> '.$value["tonohora"].'<br>

          </td>

          <td><b>Observaciones:</b> '.$value["observaciones"].'<br><br>
          </td>



          ';

          echo '<td><b>Fecha de Atención:</b><br>'.$value["fecha"].'

          </td>';

          echo '<td>

          <div class="btn-group">

          <button class="btn btn-primary btnImprimirhistoria" codigoVenta="'.$value["id"].'">

          <i class="fa fa-file-text-o"></i>

          </button>

          <button class="btn btn-warning btnEditarhistoria" idhistoria="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarhistoria"><i class="fa fa-pencil"></i></button>

          <button class="btn btn-danger btnEliminarhistoria" idhistoria="'.$value["id"].'" historia="'.$value["documentoid"].'"><i class="fa fa-times"></i></button>

          </div>  

          </td>';


        }
      }

      if ($_SESSION["perfil"] == "Oftalmologico" ) {

         foreach ($historias as $key => $value){

          echo '  <tr>
          <td>'.($key+1).'</td>

          <td>
          
          <b>Rut:</b> '.$value["documentoid"].'<br>
          <b>Nombre:</b> '.$value["nombre"].'<br>'.$value["nombre2"].' <br>'.$value["apellido"].'<br> '.$value["apellido2"].'<br>
          <b> Dirección:</b> '.$value["direccion"].'</b><br>
          <b> Telefono:</b> '.$value["telefono"].'</b><br>
          <b> Edad:</b> '.$value["edad"].'</b><br>

          </td>
          
          <td>
          
          <b>Receta:</b> '.$value["id"].'<br>
          <b>Anamnesis:</b> '.$value["anamnesis"].'<br>
          <b>Antecedentes:</b> '.$value["antecedentes"].'<br>

          </td>

          <td>
          
          PL<br><br>
          <b>ODsc:</b> '.$value["odsc"].'<br>
          <b>ODcc:</b> '.$value["odcc"].'<br>
          <b>OIsc:</b> '.$value["oisc"].'<br>
          <b>OIcc:</b> '.$value["oicc"].'<br><br>
          PC<br><br>
          <b>Cc:</b> '.$value["cc"].'<br>
          
          
          </td>

          <td>

          Ojo derecho <br>
          <b>Esfera:</b> '.$value["esferaodlj"].'<br>
          <b>Cilindro:</b> '.$value["cilindroodlj"].'<br>
          <b>Eje:</b> '.$value["ejeodlj"].'<br>

          Ojo izquierdo <br>
          <b>Esfera:</b> '.$value["esferaoilj"].'<br>
          <b>Cilindro:</b> '.$value["cilindrooilj"].'<br>
          <b>Eje:</b> '.$value["ejeoilj"].'<br><br>

          </td>

          <td>

          Ojo derecho <br>
          <b>Esfera:</b> '.$value["esferaodcc"].'<br>
          <b>Cilindro:</b> '.$value["cilindroodcc"].'<br>
          <b>Eje:</b> '.$value["ejeodcc"].'<br>

          Ojo izquierdo <br>
          <b>Esfera:</b> '.$value["esferaoicc"].'<br>
          <b>Cilindro:</b> '.$value["cilindrooicc"].'<br>
          <b>Eje:</b> '.$value["ejeoicc"].'<br>
          

          </td>

          
          <td>
    
          <b> ADD:</b> '.$value["adicion"].'<br>
          <b> DP:</b> '.$value["dp"].'<br>

          </td>
          

          <td>
    
          <b> Patologías Medicas:</b> '.$value["diagnostico"].'<br>

          </td>

          <td>
    
          <b> OD mmHg.:</b> '.$value["tonood"].'<br>
          <b> OI mmHg.:</b> '.$value["tonooi"].'<br>
          <b> Momento Exácto:</b> '.$value["tonohora"].'<br>

          </td>

          <td><b>Observaciones:</b> '.$value["observaciones"].'<br><br>
          </td>



          ';

          echo '<td><b>Fecha de Atención:</b><br>'.$value["fecha"].'

          </td>';

          echo '<td>

          <div class="btn-group">

          <button class="btn btn-primary btnImprimirhistoria" codigoVenta="'.$value["id"].'">

          <i class="fa fa-file-text-o"></i>

          </button>

          <button class="btn btn-warning btnEditarhistoria" idhistoria="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarhistoria"><i class="fa fa-pencil"></i></button>

          </div>  

          </td>';


        }
      }


    ?> 

  </tbody>

</table>

</div>

</div>

</section>

</div>

                <!--=====================================
                MODAL AGREGAR historia
                ======================================-->

                <div id="modalAgregarhistoria" class="modal fade" role="dialog">

                  <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                      <form role="form" method="post" enctype="multipart/form-data">

                        <!--=====================================
                        CABEZA DEL MODAL
                        ======================================-->

                        <div class="modal-header" style="background:#666F88; color:white">

                          <button type="button" class="close" data-dismiss="modal">&times;</button>

                          <h4 class="modal-title">Realizar atención al cliente</h4>

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
                                  <select class="selectpicker" name="traer_cliente" id="traer_cliente" class="selectpicker show-tick"

                                    data-max-options="6" 
                                    data-live-search="true" 
                                    data-width="fit" 
                                    title="CONSULTAR AQUÍ">

                                    <?php
                                

                                      $item = null;
                                    
                                      $valor = null;
                                    
                                      $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);
                                    
                                
                                      echo '<option></option>';

                                      foreach($cliente as $keypac =>
                                      $data_pac){

                                        //aca muestra el ci del cliente pero en realidad el value es "id"

                                        echo '<option value="'.$data_pac["id"].'">CI: '.$data_pac["documento"].'</option>';

                                      }
                                      
                                    ?>

                                  </select> 
                                </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Primer Nombre</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" required >
                                <input readonly type="hidden" class="form-control input-lg" name="nuevodocumentoid" id="nuevodocumentoid" required >
                              </div>
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
                              <div class="form-group col-md-8">
                                <label for="inputdireccion">Dirección</label>
                                <input readonly type="text" class="form-control input-lg" name="nuevadireccion" id="nuevadireccion" >
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputhistoria">Anamnesis</label>
                                <input type="text" class="form-control input-lg" name="nuevoanamnesis" placeholder="Ingresar Anamnesis" id="nuevoanamnesis" required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-8">
                                <label for="inputhistoria">Antecedentes</label>
                                <input type="text" class="form-control input-lg" name="nuevoantecedentes" placeholder="Ingresar Anamnesis" id="nuevoantecedentes" required>
                              </div>
                              <div class="form-group col-md-4">
                                <label>Fecha de nacimiento</label> 
                                <input type="date" class="form-control input-lg" name="nuevaedad" id="nuevaedad">
                              </div>
                            </div><br>

                            <div class="panel"><h3><b>AGUDEZA VISUAL</b></h3></div>
                            <label><h3>PL</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>ODsc</label>
                                <input type="text" class="form-control input-lg" name="nuevoODsc" placeholder="ODsc"  >
                              </div>
                            
                              <div class="form-group col-md-6">
                                <label>ODcc</label>
                                <input type="text" class="form-control input-lg" name="nuevoODcc" placeholder="ODcc"  >
                              </div>
                            </div>
                            
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label>OIsc</label>
                                  <input type="text" class="form-control input-lg" name="nuevoOIsc" placeholder="OIsc"  >
                                </div>
                              
                              <div class="form-group col-md-6">
                                  <label>OIcc</label>
                                  <input type="text" class="form-control input-lg" name="nuevoOIcc" placeholder="OIcc"  >
                              </div>
                            </div>

                            <label><h3>PC</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>CC</label>
                                <input type="text" class="form-control input-lg" name="nuevacc" placeholder="M."  >
                              </div>
                            </div>
                            </div>
                            <div class="panel"><h3><b>REFRACCIÓN LEJOS</b></h3></div>
                            <label><h3>OJO DERECHO</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="nuevoesferaodlj" placeholder="Ingresar esfera ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="nuevocilindroodlj" placeholder="Ingresar cilindro ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="nuevoejeodlj" placeholder="Ingresar eje ojo derecho" >
                              </div>
                            </div>
                            
                            <label><h3>OJO IZQUIERDO</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="nuevoesferaoilj" placeholder="Ingresar esfera ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="nuevocilindrooilj" placeholder="Ingresar cilindro ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="nuevoejeoilj" placeholder="Ingresar eje ojo izquierdo" >
                              </div>
                            </div>

                            <div class="panel"><h3><b>REFRACCIÓN CERCA</b></h3></div>
                            <label><h3>OJO DERECHO</h3></label>
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="nuevoesferaodcc" placeholder="Ingresar esfera ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="nuevocilindroodcc" placeholder="Ingresar cilindro ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="nuevoejeodcc" placeholder="Ingresar eje ojo izquierdo" >
                              </div>
                            </div>

                            
                            <label><h3>OJO IZQUIERDO</h3></label>

                            
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="nuevoesferaoicc" placeholder="Ingresar esfera ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="nuevocilindrooicc" placeholder="Ingresar cilindro ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="nuevoejeoicc" placeholder="Ingresar eje ojo derecho" >
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="inputobservaciones">ADD</label>
                                <input type="text" class="form-control input-lg" name="nuevaADD" placeholder="ADD"  >
                              </div>
                            
                              <div class="form-group col-md-6">
                                <label for="inputobservaciones">DP</label>
                                <input type="text" class="form-control input-lg" name="nuevaDP" placeholder="DP"  >
                              </div>
                            </div>

                            <div class="panel"><h3><b>DIAGNÓSTICO</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="checkbox" name="diagnostico[]" value="MIOPIA" >  <strong>MIOPIA</strong><br>
                                <input type="checkbox" name="diagnostico[]" value="ASTIGMATISMO">  <strong>ASTIGMATISMO</strong><br>
                                <input type="checkbox" name="diagnostico[]" value="HIPERMETROPÍA">  <strong>HIPERMETROPÍA</strong><br>
                                <input type="checkbox" name="diagnostico[]" value="PRESBICIA">  <strong>PRESBICIA</strong><br>
                              </div>
                            </div><br>

                            <label><h3><b>TONOMETRÍA</b></h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label>OD</label>
                                <label>mmHg.</label><input type="text" class="form-control input-lg" name="nuevatonoOD" placeholder="mmHg."  >
                              </div>
                              <div class="form-group col-md-4">
                                <label>OI</label>
                                <label>mmHg.</label><input type="text" class="form-control input-lg" name="nuevatonoOI" placeholder="mmHg."  >
                              </div>
                              <div class="form-group col-md-4">
                                <label>Hora:</label> 
                                <input type="datetime-local" class="form-control input-lg" name="nuevatonohora">
                              </div>
                            </div>

                            <div class="panel"><h3><b>AGREGAR OBERVACIONES</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputobservaciones">Observaciones General</label>
                                <input type="text" class="form-control input-lg" name="nuevaobservaciones" placeholder="Ingresar observaciones"  >
                              </div>
                            </div>

                          </div>

                        

                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                          <button type="submit" class="btn btn-primary">Guardar historia</button>

                        </div>

                        <?php

                        $crearhistoria = new Controladorhistorias();
                        $crearhistoria -> ctrCrearhistoria();

                        ?>

                      </form>

                    </div>

                  </div>

                </div>


                <!--=====================================
                MODAL EDITAR historia
                ======================================-->

                <div id="modalEditarhistoria" class="modal  fade" role="dialog">

                  <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                      <form role="form" method="post" enctype="multipart/form-data">

                        <!--=====================================
                        CABEZA DEL MODAL
                        ======================================-->

                        <div class="modal-header" style="background:#02ac66; color:white">

                          <button type="button" class="close" data-dismiss="modal">&times;</button>

                          <h4 class="modal-title">Editar historia</h4>

                        </div>

                        <!--=====================================
                        CUERPO DEL MODAL
                        ======================================-->

                        <div class="modal-body">

                          <div class="box-body">

                            <div class="panel"><h3><b>DATOS DEL PACIENTE</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputdocumentoid">CI:</label>
                                <input type="text" class="form-control input-lg" name="editardocumentoid" id="editardocumentoid" maxlength="10" required  placeholder="NIT/CI"  >
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Primer Nombre</label>
                                <input type="text" class="form-control input-lg" name="editarNombre" id="editarNombre" placeholder="Ingresar 1er nombre" required >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre2">Segundo Nombre</label>
                                <input type="text" class="form-control input-lg" name="editarNombre2" id="editarNombre2" placeholder="Ingresar 2do nombre"  >
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Primer Apellido</label>
                                <input type="text" class="form-control input-lg" name="editarapellido" id="editarapellido" placeholder="Ingresar 1er apellido" required >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Segundo Apellido</label>
                                <input type="text" class="form-control input-lg" name="editarapellido2" id="editarapellido2" placeholder="Ingresar 2do apellido"  >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputtelefono">Telefóno</label>
                                <input type="text" class="form-control input-lg" name="editartelefono" id="editartelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputdireccion">Dirección</label>
                                <input type="text" class="form-control input-lg" name="nuevadireccion" id="nuevadireccion"  placeholder="Ingresar dirección"  >
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputhistoria">Anamnesis</label>
                                <input type="text" class="form-control input-lg" name="editaranamnesis" id="editaranamnesis" placeholder="Ingresar Anamnesis" id="editaranamnesis" required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-8">
                                <label for="inputhistoria">Antecedentes</label>
                                <input type="text" class="form-control input-lg" name="editarantecedentes" id="editarantecedentes" placeholder="Ingresar Anamnesis" id="editarantecedentes" required>
                              </div>
                              <div class="form-group col-md-4">
                                <label>Fecha de nacimiento</label> 
                                <input type="date" class="form-control input-lg" name="editarnuevaedad" id="editarnuevaedad">
                              </div>
                            </div><br>

                            <div class="panel"><h3><b>AGUDEZA VISUAL</b></h3></div>
                            <label><h3>PL</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>ODsc</label>
                                <input type="text" class="form-control input-lg" name="editarODsc" id="editarODsc" placeholder="ODsc"  >
                              </div>
                            
                              <div class="form-group col-md-6">
                                <label>ODcc</label>
                                <input type="text" class="form-control input-lg" name="editarODcc" id="editarODcc" placeholder="ODcc"  >
                              </div>
                            </div>
                            
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label>OIsc</label>
                                  <input type="text" class="form-control input-lg" name="editarOIsc" id="editarOIsc" placeholder="OIsc"  >
                                </div>
                              
                              <div class="form-group col-md-6">
                                  <label>OIcc</label>
                                  <input type="text" class="form-control input-lg" name="editarOIcc" id="editarOIcc" placeholder="OIcc"  >
                              </div>
                            </div>

                            <label><h3>PC</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label>CC</label>
                                <input type="text" class="form-control input-lg" name="editarnuevacc" id="editarnuevacc" placeholder="M."  >
                              </div>
                            </div>
                            </div>
                            <div class="panel"><h3><b>REFRACCIÓN LEJOS</b></h3></div>
                            <label><h3>OJO DERECHO</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="editaresferaodlj" id="editaresferaodlj" placeholder="Ingresar esfera ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="editarcilindroodlj" id="editarcilindroodlj" placeholder="Ingresar cilindro ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="editarejeodlj" id="editarejeodlj" placeholder="Ingresar eje ojo derecho" >
                              </div>
                            </div>
                            
                            <label><h3>OJO IZQUIERDO</h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="editaresferaoilj" id="editaresferaoilj" placeholder="Ingresar esfera ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="editarcilindrooilj" id="editarcilindrooilj" placeholder="Ingresar cilindro ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="editarejeoilj" id="editarejeoilj" placeholder="Ingresar eje ojo izquierdo" >
                              </div>
                            </div>

                            <div class="panel"><h3><b>REFRACCIÓN CERCA</b></h3></div>
                            <label><h3>OJO DERECHO</h3></label>
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="editaresferaodcc" id="editaresferaodcc" placeholder="Ingresar esfera ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="editarcilindroodcc" id="editarcilindroodcc" placeholder="Ingresar cilindro ojo izquierdo" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="editarejeodcc" id="editarejeodcc" placeholder="Ingresar eje ojo izquierdo" >
                              </div>
                            </div>

                            
                            <label><h3>OJO IZQUIERDO</h3></label>

                            
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputapellido1">Esfera.</label>
                                <input type="text" class="form-control input-lg" name="editaresferaoicc" id="editaresferaoicc" placeholder="Ingresar esfera ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputapellido2">Cilindro.</label>
                                <input type="text" class="form-control input-lg" name="editarcilindrooicc" id="editarcilindrooicc" placeholder="Ingresar cilindro ojo derecho" >
                              </div>
                              <div class="form-group col-md-4">
                                <label for="inputnombre1">Eje.</label>
                                <input type="text" class="form-control input-lg" name="editarejeoicc" id="editarejeoicc" placeholder="Ingresar eje ojo derecho" >
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="inputobservaciones">ADD</label>
                                <input type="text" class="form-control input-lg" name="editarnuevaADD" id="editarnuevaADD" placeholder="ADD"  >
                              </div>
                            
                              <div class="form-group col-md-6">
                                <label for="inputobservaciones">DP</label>
                                <input type="text" class="form-control input-lg" name="editarnuevaDP" id="editarnuevaDP" placeholder="DP"  >
                              </div>
                            </div>

                            <div class="panel"><h3><b>DIAGNÓSTICO</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <input type="checkbox" name="editardiagnostico[]" id="editardiagnostico" value="MIOPIA" >  <strong>MIOPIA</strong><br>
                                <input type="checkbox" name="editardiagnostico[]" id="editardiagnostico" value="ASTIGMATISMO">  <strong>ASTIGMATISMO</strong><br>
                                <input type="checkbox" name="editardiagnostico[]" id="editardiagnostico" value="HIPERMETROPÍA">  <strong>HIPERMETROPÍA</strong><br>
                                <input type="checkbox" name="editardiagnostico[]" id="editardiagnostico" value="PRESBICIA">  <strong>PRESBICIA</strong><br>
                                <input type="checkbox" name="editardiagnostico[]" id="editardiagnostico" value="NINGUNO">  <strong>NINGUNO</strong><br> 
                              </div>
                            </div><br>

                            <label><h3><b>TONOMETRÍA</b></h3></label>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label>OD</label>
                                <label>mmHg.</label><input type="text" class="form-control input-lg" name="editarnuevatonoOD" id="editarnuevatonoOD" placeholder="mmHg."  > 
                              </div>
                            </div>
                            <?//borrar?>
                            <div class="form-row">
                              <div class="form-group col-md-4">
                                <label>OI</label>
                                <label>mmHg.</label><input type="text" class="form-control input-lg" name="editarnuevatonoOI" id="editarnuevatonoOI" placeholder="mmHg."  >
                              </div>
                              <div class="form-group col-md-4">
                                <label>Hora:</label> 
                                <input type="datetime-local" class="form-control input-lg" name="editarnuevatonohora" id="editarnuevatonohora">
                              </div>
                            </div>

                            <div class="panel"><h3><b>AGREGAR OBERVACIONES</b></h3></div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="inputobservaciones">Observaciones General</label>
                                <input type="text" class="form-control input-lg" name="editarnuevaobservaciones" id="editarnuevaobservaciones" placeholder="Ingresar observaciones"  >
                              </div>
                            </div>

                        </div>

                        <!--=====================================
                        PIE DEL MODAL
                        ======================================-->

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                          <button type="submit" class="btn btn-primary">Modificar historia</button>

                        </div>

                        <?php

                        $editarhistoria = new Controladorhistorias();
                        $editarhistoria -> ctrEditarhistoria();

                        ?> 

                        </form>

                        <?php

                        $borrarhistoria = new Controladorhistorias();
                        $borrarhistoria -> ctrBorrarhistoria();

                        ?> 
                      
                    </div>

                </div>

            </div>



<!--***********************************
ALGORTITMO RUT
************************************-->

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


