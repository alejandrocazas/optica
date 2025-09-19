<?php

if($_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar proveedores
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar proveedores</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarproveedor">
          
          Agregar proveedor

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Dirección</th>
           <th>Contactos</th>
      
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $proveedores = Controladorproveedores::ctrMostrarproveedores($item, $valor);

          foreach ($proveedores as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                  
                    <td class="text-uppercase"><b>'.$value["nombre"].'</b><br>
                    '.$value["registro"].'


                    </td>
                     <td class="text-uppercase"><i class="fa fa-map-marker"></i> '.$value["direccion"].'</td>
                     
                     <td class="text-uppercase"><i class="fa fa-phone"></i> '.$value["telefono"].' / '.$value["telefono2"].' / '.$value["telefono3"].'<br>
                     <i class="fa fa-envelope"></i> '.$value["email"].' <br>
                     <i class="fa fa-instagram"></i> '.$value["instagram"].' <br>
                     <i class="fa fa-whatsapp"></i> '.$value["whatsapp"].' <br>



                     </td>
                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarproveedor" data-toggle="modal" data-target="#modalEditarproveedor" idproveedor="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarproveedor" idproveedor="'.$value["id"].'"><i class="fa fa-times"></i></button>';

                      }

                      echo '</div>  

                    </td>

                  </tr>';
          
            }

        ?>
   
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR proveedor
======================================-->

<div id="modalAgregarproveedor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#00bfff; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar proveedor</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoproveedor" placeholder="Ingresar nombre" required>

              </div>

            </div>

              <!-- ENTRADA PARA EL registro -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoregistro" placeholder="Ingresar registro" required>

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

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO2 -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTelefono2" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>

              </div>

            </div>

<!-- ENTRADA PARA EL TELÉFONO3 -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTelefono3" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>

              </div>

            </div>

               <!-- ENTRADA PARA EL instagram -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-instagram"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoinstagram" placeholder="Ingresar instagram">

              </div>

            </div>

            <!-- ENTRADA PARA EL whatsapp -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevowhatsapp" placeholder="Ingresar whatsapp" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>

              </div>

            </div>


            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" >

              </div>

            </div>

  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar proveedor</button>

        </div>

      </form>

      <?php

        $crearproveedor = new Controladorproveedores();
        $crearproveedor -> ctrCrearproveedor();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR proveedor
======================================-->

<div id="modalEditarproveedor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#00bfff; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar proveedor</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="editarproveedor" id="editarproveedor" required>
                <input type="hidden" id="idproveedor" name="idproveedor">
              </div>

            </div>

                  <!-- ENTRADA PARA EL registro -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="text" class="form-control input-lg" name="editarregistro" id="editarregistro" required>

              </div>

            </div>


            <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail" >

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask >

              </div>

            </div>

             <!-- ENTRADA PARA EL TELÉFONO2 -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="editarTelefono2" id="editarTelefono2" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask >

              </div>

            </div>
             <!-- ENTRADA PARA EL TELÉFONO3 -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="editarTelefono3" id="editarTelefono3" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask >

              </div>

            </div>

                  <!-- ENTRADA PARA EL instagram -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-instagram"></i></span> 

                <input type="text" class="form-control input-lg" name="editarinstagram" id="editarinstagram" >

              </div>

            </div>

             <!-- ENTRADA PARA EL whatsapp -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span> 

                <input type="text" class="form-control input-lg" name="editarwhatsapp" id="editarwhatsapp" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask >

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion"  >

              </div>

            </div>

           
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php

        $editarproveedor = new Controladorproveedores();
        $editarproveedor -> ctrEditarproveedor();

      ?>

    

    </div>

  </div>

</div>

<?php

  $eliminarproveedor = new Controladorproveedores();
  $eliminarproveedor -> ctrEliminarproveedor();

?>


