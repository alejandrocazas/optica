
<div class="content-wrapper">

  <?php

if($_SESSION["perfil"] == "Vendedor" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

  <section class="content-header">
    
    <h1>
      
      Administrar configuraciones
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar configuraciones</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <?php

          $item = null;
        $valor = null;
        $c = 0;

        $configuraciones = Controladorconfiguraciones::ctrMostrarconfiguraciones($item, $valor);

         foreach ($configuraciones as $key => $value){

           $c =  $c + 1;

         }

        if ($c < 1 ) {

          echo '<button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarconfiguracion">
          
          Agregar configuracion

        </button>';

          
        }



          ?>
  

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
            <th>Logo</th>
           <th>Empresa</th>
            <th>Direccion</th>
           <th>Telefono</th>
          
         
           <th>Email</th>
           <th>Tipo de Moneda</th>
    
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php



if ($_SESSION["perfil"] == "Administrador" ) {

       foreach ($configuraciones as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>';

                  if($value["foto"] != ""){

                    echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="80px"></td>';

                  }else{

                    echo '<td><img src="vistas/img/configuraciones/default/anonymous.png" class="img-thumbnail" width="80px"></td>';

                  }

                  echo '<td><b>'.$value["nombre"].'</b><br>
                  <b> '.$value["configuracion"].'</b></td>
                  <td>'.$value["direccion"].'<br>
                  '.$value["direccion2"].'</td>';


                  echo '<td>'.$value["telefono"].'</td>';

                  echo '<td>'.$value["email"].'</td>';      
                  echo '<td>'.$value["moneda"].'</td>';         

                  echo '
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarconfiguracion" idconfiguracion="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarconfiguracion"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarconfiguracion" idconfiguracion="'.$value["id"].'" fotoconfiguracion="'.$value["foto"].'" configuracion="'.$value["configuracion"].'"><i class="fa fa-times"></i></button>

                    </div>  

                  </td>

                </tr>';
        }
        }



       if ($_SESSION["perfil"] == "Vendedor" ) {

       foreach ($configuraciones as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>';

                  if($value["foto"] != ""){

                    echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="80px"></td>';

                  }else{

                    echo '<td><img src="vistas/img/configuraciones/default/anonymous.png" class="img-thumbnail" width="80px"></td>';

                  }

                  echo '<td><b>'.$value["nombre"].'</b><br>
                  <b> '.$value["configuracion"].'</b></td>
                   <td>'.$value["direccion"].'<br>
                  '.$value["direccion2"].'</td>';


                  echo '<td>'.$value["telefono"].'</td>';

                  echo '<td>'.$value["email"].'</td>'; 
                  echo '<td>'.$value["moneda"].'</td>';              

                  echo '
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarconfiguracion" idconfiguracion="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarconfiguracion"><i class="fa fa-pencil"></i></button>

                      

                    </div>  

                  </td>

                </tr>';
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
MODAL AGREGAR configuracion
======================================-->

<div id="modalAgregarconfiguracion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#2700ff; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar configuracion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i><b> Empresa/Tienda:</b></span> 

                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar nombre" required >

              </div>

            </div>

             <!-- ENTRADA PARA EL configuracion -->

             <div class="form-group">
              
              <div class="input-group">
              

                <span class="input-group-addon"><i class="fa fa-key"></i><b> NIT:</b></span> 

                <input type="text" class="form-control input-lg" name="nuevoconfiguracion" maxlength="10" required  placeholder=" NIT" id="nuevoconfiguracion" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL direccion -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa  fa-map-marker"></i><b> Dirección:</b></span> 

                <input type="text" class="form-control input-lg" name="nuevadireccion" placeholder="Ingresar direccion" required >

              </div>

            </div>

              <!-- ENTRADA PARA EL direccion 2 -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa  fa-map-marker"></i><b> Dirección 2:</b></span> 

                <input type="text" class="form-control input-lg" name="nuevadireccion2" placeholder="Ingresar direccion 2" required >

              </div>

            </div>

           



             <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></i><b> Email:</b></span> </span> 

                <input type="email" class="form-control input-lg" name="nuevoemail" placeholder="Ingresar email" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i><b> Telefono:</b></span> 

                <input type="text" class="form-control input-lg" name="nuevotelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask required>

              </div>

            </div>

              <!-- ENTRADA PARA EL moneda -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa  fa-map-marker"></i><b> Tipo de moneda:</b></span> 

                <input type="text" class="form-control input-lg" name="nuevomoneda" placeholder="Ingresar tipo de moneda" required >

              </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFoto" name="nuevaFoto">

              <p class="help-block">Peso máximo de la foto 2MB</p>

              <img src="vistas/img/configuraciones/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>



          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar configuracion</button>

        </div>

        <?php

          $crearconfiguracion = new Controladorconfiguraciones();
          $crearconfiguracion -> ctrCrearconfiguracion();

        ?>

      </form>

    </div>

  </div>

</div>


<!--=====================================
MODAL EDITAR configuracion
======================================-->

<div id="modalEditarconfiguracion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#2700ff; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar configuracion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i><b> Empresa/Tienda:</b></span> 

                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL direccion -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa  fa-map-marker"></i><b> Dirección:</b></span> 

                <input type="text" class="form-control input-lg" id="editardireccion" name="editardireccion" value="" required >

              </div>

            </div>

               <!-- ENTRADA PARA EL direccion 2 -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa  fa-map-marker"></i><b> Dirección 2:</b></span> 

                <input type="text" class="form-control input-lg" id="editardireccion2" name="editardireccion2" value="" required >

              </div>

            </div>

            <!-- ENTRADA PARA EL configuracion -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i><b> NIT:</b></span> 

                <input type="text" class="form-control input-lg" id="editarconfiguracion" name="editarconfiguracion" value="" readonly>

              </div>

            </div>

       


  <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i><b> Email:</b></span> 

                <input type="email" class="form-control input-lg" name="editaremail" id="editaremail" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i><b> Telefono:</b></span> 

                <input type="text" class="form-control input-lg" name="editartelefono" id="editartelefono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask required>

              </div>

            </div>

              <!-- ENTRADA PARA EL moneda -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa  fa-map-marker"></i><b> Tipo de moneda:</b></span> 

                <input type="text" class="form-control input-lg" id="editarmoneda" name="editarmoneda" value="" required >

              </div>

            </div>

        
      

            <!-- ENTRADA PARA SUBIR FOTO -->

             <div class="form-group">
              
              <div class="panel">SUBIR FOTO</div>

              <input type="file" class="nuevaFoto" name="editarFoto">

              <p class="help-block">Peso máximo de la foto 2MB</p>

              <img src="vistas/img/configuraciones/default/anonymous.png" class="img-thumbnail previsualizarEditar" width="100px">

              <input type="hidden" name="fotoActual" id="fotoActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Modificar configuracion</button>

        </div>

     <?php

          $editarconfiguracion = new Controladorconfiguraciones();
          $editarconfiguracion -> ctrEditarconfiguracion();

        ?> 

      </form>

    </div>

  </div>

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

<?php

  $borrarconfiguracion = new Controladorconfiguraciones();
  $borrarconfiguracion -> ctrBorrarconfiguracion();

?> 


