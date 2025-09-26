<?php
/* ==========
 * ESPACIO OFTALMOLÓGICO (HISTORIAS)
 * ========== */

// Bloqueo de acceso por perfil
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] === "Vendedor") {
  echo '<script>window.location="inicio";</script>';
  return;
}

// Helper de escape seguro
if (!function_exists('e')) {
  function e($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }
}
?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>Espacio Oftalmológico</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar atenciones</li>
    </ol>
  </section>

  <section class="content">

    <div class="box">
      <div class="box-header with-border">
        <?php if (in_array($_SESSION["perfil"] ?? '', ["Oftalmologico","Administrador"], true)): ?>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarhistoria">
            <i class="fa fa-stethoscope"></i> Realizar atención
          </button>
        <?php endif; ?>
      </div>

      <div class="box-body">
  <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
    <thead>
      <tr>
        <th style="width:10px">#</th>
        <th>Datos</th>
        <th>Atención</th>
        <th>Refracción lejos</th>
        <th>Refracción cerca</th>
        <th>DP/ADD</th>
        <th>Diagnóstico</th>
        <th>Observaciones</th>
        <th>Fecha de Atención</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // helper seguro por si no lo tienes ya en este archivo
        if (!function_exists('e')) { function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); } }

        $historias = Controladorhistorias::ctrMostrarhistorias(null, null);

        // ===== Perfil: ADMINISTRADOR =====
        if (($_SESSION["perfil"] ?? '') === "Administrador") {
          foreach ($historias as $k => $h) {
            echo '<tr>';

            // #
            echo '<td>'.($k+1).'</td>';

            // Datos
            echo '<td>
                    <b>Nombre:</b> '.e($h["nombre"]).' '.e($h["apellido"]).'<br>
                    <b>CI:</b> '.e($h["documentoid"]).'<br>
                    
                  </td>';

            // Atención
            echo '<td>
                    <b>Receta:</b> '.e($h["id"]).'<br>
                    <b>Anamnesis:</b> '.e($h["anamnesis"]).'<br>
                    <b>Antecedentes:</b> '.e($h["antecedentes"]).'
                  </td>';

            // Refracción lejos
            echo '<td>
                    <b>Ojo derecho</b><br>
                    <b>Esfera:</b> '.e($h["esferaodlj"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindroodlj"]).'<br>
                    <b>Eje:</b> '.e($h["ejeodlj"]).'<br><br>
                    <b>Ojo izquierdo</b><br>
                    <b>Esfera:</b> '.e($h["esferaoilj"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindrooilj"]).'<br>
                    <b>Eje:</b> '.e($h["ejeoilj"]).'
                  </td>';

            // Refracción cerca
            echo '<td>
                    <b>Ojo derecho</b><br>
                    <b>Esfera:</b> '.e($h["esferaodcc"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindroodcc"]).'<br>
                    <b>Eje:</b> '.e($h["ejeodcc"]).'<br><br>
                    <b>Ojo izquierdo</b><br>
                    <b>Esfera:</b> '.e($h["esferaoicc"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindrooicc"]).'<br>
                    <b>Eje:</b> '.e($h["ejeoicc"]).'
                  </td>';

            // Distancia interpupilar (ADD / DP)
            echo '<td>
                    <b>ADD:</b> '.e($h["adicion"]).'<br>
                    <b>DP:</b> '.e($h["dp"]).'
                  </td>';

            // Diagnóstico
            echo '<td><b>Patologías Médicas:</b> '.e($h["diagnostico"]).'</td>';

            // Observaciones
            echo '<td> '.e($h["observaciones"]).'</td>';

            // Fecha
            echo '<td><br>'.e($h["fecha"]).'</td>';

            // Acciones
            echo '<td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary btnImprimirhistoria" codigoVenta="'.e($h["id"]).'" title="Imprimir">
                        <i class="fa fa-file-text-o"></i>
                      </button>
                      <button type="button" class="btn btn-warning btnEditarhistoria" idhistoria="'.e($h["id"]).'" data-toggle="modal" data-target="#modalEditarhistoria" title="Editar">
                        <i class="fa fa-pencil"></i>
                      </button>
                      <button type="button" class="btn btn-danger btnEliminarhistoria" idhistoria="'.e($h["id"]).'" historia="'.e($h["documentoid"]).'" title="Eliminar">
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  </td>';

            echo '</tr>';
          }
        }

        // ===== Perfil: OFTALMOLÓGICO =====
        if (($_SESSION["perfil"] ?? '') === "Oftalmologico") {
          foreach ($historias as $k => $h) {
            echo '<tr>';

            echo '<td>'.($k+1).'</td>';

            echo '<td>
                    <b>CI:</b> '.e($h["documentoid"]).'<br>
                    <b>Nombre:</b> '.e($h["nombre"]).' '.e($h["apellido"]).'<br>
                    <b>Dirección:</b> '.e($h["direccion"]).'<br>
                    <b>Teléfono:</b> '.e($h["telefono"]).'<br>
                    <b>Edad:</b> '.e($h["edad"]).'
                  </td>';

            echo '<td>
                    <b>Receta:</b> '.e($h["id"]).'<br>
                    <b>Anamnesis:</b> '.e($h["anamnesis"]).'<br>
                    <b>Antecedentes:</b> '.e($h["antecedentes"]).'
                  </td>';

            echo '<td>
                    <b>Ojo derecho</b><br>
                    <b>Esfera:</b> '.e($h["esferaodlj"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindroodlj"]).'<br>
                    <b>Eje:</b> '.e($h["ejeodlj"]).'<br><br>
                    <b>Ojo izquierdo</b><br>
                    <b>Esfera:</b> '.e($h["esferaoilj"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindrooilj"]).'<br>
                    <b>Eje:</b> '.e($h["ejeoilj"]).'
                  </td>';

            echo '<td>
                    <b>Ojo derecho</b><br>
                    <b>Esfera:</b> '.e($h["esferaodcc"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindroodcc"]).'<br>
                    <b>Eje:</b> '.e($h["ejeodcc"]).'<br><br>
                    <b>Ojo izquierdo</b><br>
                    <b>Esfera:</b> '.e($h["esferaoicc"]).'<br>
                    <b>Cilindro:</b> '.e($h["cilindrooicc"]).'<br>
                    <b>Eje:</b> '.e($h["ejeoicc"]).'
                  </td>';

            echo '<td>
                    <b>ADD:</b> '.e($h["adicion"]).'<br>
                    <b>DP:</b> '.e($h["dp"]).'
                  </td>';

            echo '<td><b>Patologías Médicas:</b> '.e($h["diagnostico"]).'</td>';

            echo '<td><b>Observaciones:</b> '.e($h["observaciones"]).'</td>';

            echo '<td><b>Fecha de Atención:</b><br>'.e($h["fecha"]).'</td>';

            echo '<td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary btnImprimirhistoria" codigoVenta="'.e($h["id"]).'" title="Imprimir">
                        <i class="fa fa-file-text-o"></i>
                      </button>
                      <button type="button" class="btn btn-warning btnEditarhistoria" idhistoria="'.e($h["id"]).'" data-toggle="modal" data-target="#modalEditarhistoria" title="Editar">
                        <i class="fa fa-pencil"></i>
                      </button>
                    </div>
                  </td>';

            echo '</tr>';
          }
        }
      ?>
    </tbody>
  </table>
</div>


    </div>

  </section>

</div>

<!-- =====================================
MODAL: REALIZAR ATENCIÓN (CREAR)
===================================== -->
<div id="modalAgregarhistoria" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-modern">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-stethoscope"></i> Realizar atención al cliente</h4>
        </div>

        <div class="modal-body">

          <!-- DATOS DEL PACIENTE -->
          <div class="form-section">
            <h5>Datos del paciente</h5>
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-4">
                <label>CI/NIT</label>
                <select class="selectpicker form-control" name="traer_cliente" id="traer_cliente"
                        data-live-search="true" data-width="100%" title="Buscar CI/NIT…">
                  <?php
                    $cliente = ControladorClientes::ctrMostrarClientes(null, null);
                    echo '<option></option>';
                    foreach ($cliente as $c) {
                      echo '<option value="'.e($c["id"]).'">CI: '.e($c["documento"]).'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-4">
                <label>Nombre(s)</label>
                <input readonly type="text" class="form-control input-soft" id="nuevoNombre" name="nuevoNombre">
                <input readonly type="hidden" id="nuevodocumentoid" name="nuevodocumentoid">
              </div>
              <div class="col-sm-4">
                <label>Apellidos</label>
                <input readonly type="text" class="form-control input-soft" id="nuevoapellido" name="nuevoapellido">
              </div>

              <div class="col-sm-4">
                <label>Teléfono</label>
                <input readonly type="text" class="form-control input-soft" id="nuevotelefono" name="nuevotelefono">
              </div>
              <div class="col-sm-8">
                <label>Dirección</label>
                <input readonly type="text" class="form-control input-soft" id="nuevadireccion" name="nuevadireccion">
              </div>

              <div class="col-sm-8">
                <label>Anamnesis</label>
                <input type="text" class="form-control" id="nuevoanamnesis" name="nuevoanamnesis" placeholder="Ingresar Anamnesis" required>
              </div>
              <div class="col-sm-4">
                <label>Fecha de nacimiento</label>
                <input type="date" class="form-control" id="nuevaedad" name="nuevaedad">
              </div>

              <div class="col-sm-12">
                <label>Antecedentes</label>
                <input type="text" class="form-control" id="nuevoantecedentes" name="nuevoantecedentes" placeholder="Ingresar Antecedentes" required>
              </div>
            </div>
          </div>

          <!-- REFRACCIÓN LEJOS -->
          <div class="form-section">
            <h5>Refracción lejos</h5>
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-6">
                <span class="badge-eye od">Ojo derecho</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoesferaodlj"    placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevocilindroodlj"  placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoejeodlj"       placeholder="Eje"></div>
                </div>
              </div>
              <div class="col-sm-6">
                <span class="badge-eye oi">Ojo izquierdo</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoesferaoilj"    placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevocilindrooilj"  placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoejeoilj"       placeholder="Eje"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- REFRACCIÓN CERCA -->
          <div class="form-section">
            <h5>Refracción cerca</h5>
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-6">
                <span class="badge-eye od">Ojo derecho</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoesferaodcc"    placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevocilindroodcc"  placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoejeodcc"       placeholder="Eje"></div>
                </div>
              </div>
              <div class="col-sm-6">
                <span class="badge-eye oi">Ojo izquierdo</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoesferaoicc"    placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevocilindrooicc"  placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" name="nuevoejeoicc"       placeholder="Eje"></div>
                </div>
              </div>
            </div>

            <hr class="hr-soft">
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-6">
                <label>ADD</label>
                <input type="text" class="form-control" name="nuevaADD" placeholder="ADD">
              </div>
              <div class="col-sm-6">
                <label>DP</label>
                <input type="text" class="form-control" name="nuevaDP" placeholder="DP">
              </div>
            </div>
          </div>

          <!-- DIAGNÓSTICO -->
          <div class="form-section">
            <h5>Diagnóstico</h5>
            <div class="dx-group">
              <label class="checkbox-inline"><input type="checkbox" name="diagnostico[]" value="MIOPIA"> Miopía</label>
              <label class="checkbox-inline"><input type="checkbox" name="diagnostico[]" value="ASTIGMATISMO"> Astigmatismo</label>
              <label class="checkbox-inline"><input type="checkbox" name="diagnostico[]" value="HIPERMETROPÍA"> Hipermetropía</label>
              <label class="checkbox-inline"><input type="checkbox" name="diagnostico[]" value="PRESBICIA"> Presbicia</label>
            </div>
            <div class="row" style="margin-top:10px">
              <div class="col-sm-12">
                <label>Observaciones</label>
                <input type="text" class="form-control" name="nuevaobservaciones" placeholder="Observaciones generales">
              </div>
            </div>
          </div>

          <!-- compat -->
          <input type="hidden" name="nuevoODsc" value="">
          <input type="hidden" name="nuevoODcc" value="">
          <input type="hidden" name="nuevoOIsc" value="">
          <input type="hidden" name="nuevoOIcc" value="">
          <input type="hidden" name="nuevacc" value="">
          <input type="hidden" name="nuevatonoOD" value="">
          <input type="hidden" name="nuevatonoOI" value="">
          <input type="hidden" name="nuevatonohora" value="">
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar atención</button>
        </div>

        <?php
          $crearhistoria = new Controladorhistorias();
          $crearhistoria->ctrCrearhistoria();
        ?>
      </form>
    </div>
  </div>
</div>



<!-- =====================================
MODAL: EDITAR ATENCIÓN
===================================== -->
<div id="modalEditarhistoria" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-modern">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header" style="background:#0b9a6a">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-pencil"></i> Editar atención</h4>
        </div>

        <div class="modal-body">
          <!-- DATOS -->
          <div class="form-section">
            <h5>Datos del paciente</h5>
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-4">
                <label>CI</label>
                <input type="text" class="form-control" id="editardocumentoid" name="editardocumentoid" maxlength="10" required>
              </div>
              <div class="col-sm-4">
                <label>Nombre(s)</label>
                <input type="text" class="form-control" id="editarNombre" name="editarNombre" required>
              </div>
              <div class="col-sm-4">
                <label>Apellidos</label>
                <input type="text" class="form-control" id="editarapellido" name="editarapellido" required>
              </div>
              <div class="col-sm-4">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="editartelefono" name="editartelefono" data-inputmask="'mask':' 99999999'" data-mask>
              </div>
              <div class="col-sm-12">
                <label>Dirección</label>
                  <input type="text" class="form-control" id="editardireccion" name="editardireccion">
                </div>
              <div class="col-sm-8">
                <label>Anamnesis</label>
                <input type="text" class="form-control" id="editaranamnesis" name="editaranamnesis" required>
              </div>
              <div class="col-sm-4">
                <label>Fecha de nacimiento</label>
                <input type="date" class="form-control" id="editarnuevaedad" name="editarnuevaedad">
              </div>
              <div class="col-sm-12">
                <label>Antecedentes</label>
                <input type="text" class="form-control" id="editarantecedentes" name="editarantecedentes" required>
              </div>
            </div>
          </div>

          <!-- LEJOS -->
          <div class="form-section">
            <h5>Refracción lejos</h5>
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-6">
                <span class="badge-eye od">Ojo derecho</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" id="editaresferaodlj"  name="editaresferaodlj"  placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarcilindroodlj" name="editarcilindroodlj" placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarejeodlj"    name="editarejeodlj"    placeholder="Eje"></div>
                </div>
              </div>
              <div class="col-sm-6">
                <span class="badge-eye oi">Ojo izquierdo</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" id="editaresferaoilj"  name="editaresferaoilj"  placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarcilindrooilj" name="editarcilindrooilj" placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarejeoilj"    name="editarejeoilj"    placeholder="Eje"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- CERCA -->
          <div class="form-section">
            <h5>Refracción cerca</h5>
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-6">
                <span class="badge-eye od">Ojo derecho</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" id="editaresferaodcc"  name="editaresferaodcc"  placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarcilindroodcc" name="editarcilindroodcc" placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarejeodcc"    name="editarejeodcc"    placeholder="Eje"></div>
                </div>
              </div>
              <div class="col-sm-6">
                <span class="badge-eye oi">Ojo izquierdo</span>
                <div class="row row-gutter-8">
                  <div class="col-xs-4"><input type="text" class="form-control" id="editaresferaoicc"  name="editaresferaoicc"  placeholder="Esfera"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarcilindrooicc" name="editarcilindrooicc" placeholder="Cilindro"></div>
                  <div class="col-xs-4"><input type="text" class="form-control" id="editarejeoicc"    name="editarejeoicc"    placeholder="Eje"></div>
                </div>
              </div>
            </div>

            <hr class="hr-soft">
            <div class="row row-gutter-8 form-compact">
              <div class="col-sm-6">
                <label>ADD</label>
                <input type="text" class="form-control" id="editarnuevaADD" name="editarnuevaADD" placeholder="ADD">
              </div>
              <div class="col-sm-6">
                <label>DP</label>
                <input type="text" class="form-control" id="editarnuevaDP" name="editarnuevaDP" placeholder="DP">
              </div>
            </div>
          </div>

          <!-- DIAGNÓSTICO -->
          <div class="form-section">
            <h5>Diagnóstico</h5>
            <div class="dx-group">
              <label class="checkbox-inline"><input type="checkbox" name="editardiagnostico[]" value="MIOPIA"> Miopía</label>
              <label class="checkbox-inline"><input type="checkbox" name="editardiagnostico[]" value="ASTIGMATISMO"> Astigmatismo</label>
              <label class="checkbox-inline"><input type="checkbox" name="editardiagnostico[]" value="HIPERMETROPÍA"> Hipermetropía</label>
              <label class="checkbox-inline"><input type="checkbox" name="editardiagnostico[]" value="PRESBICIA"> Presbicia</label>
              <label class="checkbox-inline"><input type="checkbox" name="editardiagnostico[]" value="NINGUNO"> Ninguno</label>
            </div>
            <div class="row" style="margin-top:10px">
              <div class="col-sm-12">
                <label>Observaciones</label>
                <input type="text" class="form-control" id="editarnuevaobservaciones" name="editarnuevaobservaciones" placeholder="Observaciones generales">
              </div>
            </div>

            <!-- compat -->
            <input type="hidden" name="editarODsc" value="">
            <input type="hidden" name="editarODcc" value="">
            <input type="hidden" name="editarOIsc" value="">
            <input type="hidden" name="editarOIcc" value="">
            <input type="hidden" name="editarnuevacc" value="">
            <input type="hidden" name="editarnuevatonoOD" value="">
            <input type="hidden" name="editarnuevatonoOI" value="">
            <input type="hidden" name="editarnuevatonohora" value="">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

        <?php
          $editarhistoria = new Controladorhistorias();
          $editarhistoria->ctrEditarhistoria();

          $borrarhistoria = new Controladorhistorias();
          $borrarhistoria->ctrBorrarhistoria();
        ?>
      </form>
    </div>
  </div>
</div>



<!-- =========================
     JS: SHIMS / FALLBACKS
     ========================= -->
<script>
  // Asegura que los dropdowns del navbar y treeview funcionen (si no está ya en la plantilla)
  $(function () {
    // Persistencia de sidebar (si no lo tienes ya global)
    var key = 'lte2-sidebar-collapsed';
    var saved = localStorage.getItem(key);
    if (saved === '1') document.body.classList.add('sidebar-collapse');
    $(document).on('click', '[data-toggle="push-menu"]', function () {
      setTimeout(function () {
        localStorage.setItem(key, document.body.classList.contains('sidebar-collapse') ? '1' : '0');
      }, 150);
    });

    // Bootstrap-select (defensivo)
    if ($.fn.selectpicker) {
      $('.selectpicker').selectpicker();
      $('#modalAgregarhistoria').on('shown.bs.modal', function () {
        $('.selectpicker', this).selectpicker('render');
      });
    }
  });

  // Fallback: abrir modales si data-toggle falla por algún conflicto
  $(document).on('click', '[data-target="#modalAgregarhistoria"]', function (e) {
    e.preventDefault();
    $('#modalAgregarhistoria').modal('show');
  });
  $(document).on('click', '[data-target="#modalEditarhistoria"]', function (e) {
    if (!$('#modalEditarhistoria').hasClass('in')) {
      $('#modalEditarhistoria').modal('show');
    }
  });

  // Delegación de eventos (para que funcionen en tabla y tarjetas)
  // EDITAR
  $(document).on('click', '.btnEditarhistoria', function () {
    var id = $(this).attr('idhistoria');
    if (!id) return;
    // Aquí normalmente llamas por AJAX para traer los datos y llenar el modal.
    // Ejemplo (ajusta URL/clave según tu backend):
    /*
    $.ajax({
      url: 'ajax/historias.ajax.php',
      method: 'POST',
      data: { idhistoria: id },
      dataType: 'json'
    }).done(function (data) {
      // Rellena los campos del modal con "data"
      $('#editardocumentoid').val(data.documentoid || '');
      $('#editarNombre').val(data.nombre || '');
      // ...
      $('#modalEditarhistoria').modal('show');
    });
    */
  });

  // IMPRIMIR
  $(document).on('click', '.btnImprimirhistoria', function () {
    var codigo = $(this).attr('codigoVenta');
    if (!codigo) return;
    // Descomenta si este es tu flujo
    // window.open('extensiones/tcpdf/pdf/historia.php?codigo=' + encodeURIComponent(codigo), '_blank');
  });

  // ELIMINAR (confirmación; asume que tu historias.js ya gestiona SweetAlert)
  $(document).on('click', '.btnEliminarhistoria', function () {
    var id = $(this).attr('idhistoria');
    var doc = $(this).attr('historia');
    if (!id) return;
    // Deja que tu lógica existente maneje el borrado (SweetAlert + POST)
  });
</script>
