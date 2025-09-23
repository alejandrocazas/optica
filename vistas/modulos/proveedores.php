<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

/* Guardas de acceso (server-side, sin JS) */
if (empty($_SESSION['iniciarSesion']) || $_SESSION['iniciarSesion'] !== 'ok') {
  header('Location: ?ruta=login'); exit;
}
if (!empty($_SESSION['perfil']) && $_SESSION['perfil'] === 'Vendedor') {
  header('Location: ?ruta=inicio'); exit;
}

/* Datos */
$proveedores = Controladorproveedores::ctrMostrarproveedores(null, null);
?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Proveedores <small>Administrar</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?= '?ruta=inicio' ?>"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Proveedores</li>
    </ol>
  </section>

  <section class="content">
    <div class="card-modern">

      <div class="clearfix" style="margin-bottom:12px">
        <div class="pull-left">
          <span class="badge-icon"><i class="fa fa-truck"></i> Catálogo de proveedores</span>
        </div>
        <div class="pull-right">
          <button class="btn btn-primary-gradient" data-toggle="modal" data-target="#modalAgregarproveedor">
            <i class="fa fa-plus"></i> Agregar proveedor
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-modern table-bordered dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Nombre</th>
              <th>Dirección</th>
              <th>Contactos</th>
              <th style="width:160px">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php if (is_array($proveedores)): ?>
            <?php foreach ($proveedores as $i => $p): ?>
              <?php
                $id         = (int)($p['id'] ?? 0);
                $nombre     = htmlspecialchars($p['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
                $registro   = htmlspecialchars($p['registro'] ?? '', ENT_QUOTES, 'UTF-8');
                $direccion  = htmlspecialchars($p['direccion'] ?? '', ENT_QUOTES, 'UTF-8');
                $tel1       = htmlspecialchars($p['telefono']  ?? '', ENT_QUOTES, 'UTF-8');
                $tel2       = htmlspecialchars($p['telefono2'] ?? '', ENT_QUOTES, 'UTF-8');
                $tel3       = htmlspecialchars($p['telefono3'] ?? '', ENT_QUOTES, 'UTF-8');
                $email      = htmlspecialchars($p['email']     ?? '', ENT_QUOTES, 'UTF-8');
                $ig         = htmlspecialchars($p['instagram'] ?? '', ENT_QUOTES, 'UTF-8');
                $wa         = htmlspecialchars($p['whatsapp']  ?? '', ENT_QUOTES, 'UTF-8');
              ?>
              <tr>
                <td><?= (int)($i+1) ?></td>

                <td class="text-uppercase">
                  <strong><?= $nombre ?></strong><br>
                  <small class="text-muted"><?= $registro ?></small>
                </td>

                <td class="text-uppercase">
                  <i class="fa fa-map-marker"></i>
                  <?= $direccion !== '' ? $direccion : '<span class="text-muted">Sin dirección</span>' ?>
                </td>

                <td class="text-uppercase">
                  <?php if ($tel1 || $tel2 || $tel3): ?>
                    <i class="fa fa-phone"></i>
                    <?= trim($tel1.' '.($tel2? ' / '.$tel2 : '').($tel3? ' / '.$tel3 : '')) ?><br>
                  <?php endif; ?>

                  <?php if ($email): ?>
                    <i class="fa fa-envelope"></i> <?= $email ?><br>
                  <?php endif; ?>

                  <?php if ($ig): ?>
                    <i class="fa fa-instagram"></i> <?= $ig ?><br>
                  <?php endif; ?>

                  <?php if ($wa): ?>
                    <i class="fa fa-whatsapp"></i> <?= $wa ?>
                  <?php endif; ?>

                  <?php if (!$tel1 && !$tel2 && !$tel3 && !$email && !$ig && !$wa): ?>
                    <span class="text-muted">Sin datos de contacto</span>
                  <?php endif; ?>
                </td>

                <td class="table-actions">
                  <div class="btn-group" role="group" aria-label="Acciones">
                    <button class="btn btn-warning btnEditarproveedor"
                            data-toggle="modal" data-target="#modalEditarproveedor"
                            idproveedor="<?= $id ?>" data-toggle-tooltip="tooltip" title="Editar">
                      <i class="fa fa-pencil"></i>
                    </button>
                    <?php if (!empty($_SESSION['perfil']) && $_SESSION['perfil'] === 'Administrador'): ?>
                      <button class="btn btn-danger btnEliminarproveedor"
                              idproveedor="<?= $id ?>" data-toggle-tooltip="tooltip" title="Eliminar">
                        <i class="fa fa-times"></i>
                      </button>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div><!-- /.card-modern -->
  </section>
</div>

<!-- =========================
     MODAL: Agregar proveedor
     ========================= -->
<div id="modalAgregarproveedor" class="modal fade" role="dialog" aria-labelledby="modalAgregarproveedorLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#00bfff,#00d5ff); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalAgregarproveedorLabel"><i class="fa fa-user-plus"></i> Agregar proveedor</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group">
              <label for="nuevoproveedor">Nombre</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoproveedor" name="nuevoproveedor" placeholder="Ingresar nombre" required>
              </div>
            </div>

            <div class="form-group">
              <label for="nuevoregistro">Registro / NIT</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoregistro" name="nuevoregistro" placeholder="Ingresar registro" required>
              </div>
            </div>

            <div class="form-group">
              <label for="nuevoEmail">Email</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control input-lg" id="nuevoEmail" name="nuevoEmail" placeholder="Ingresar email">
              </div>
            </div>

            <div class="form-group">
              <label for="nuevoTelefono">Teléfono(s)</label>
              <div class="input-group" style="margin-bottom:8px">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoTelefono"  name="nuevoTelefono"  placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
              <div class="input-group" style="margin-bottom:8px">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoTelefono2" name="nuevoTelefono2" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoTelefono3" name="nuevoTelefono3" placeholder="Ingresar teléfono" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
            </div>

            <div class="form-group">
              <label for="nuevoinstagram">Instagram</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoinstagram" name="nuevoinstagram" placeholder="Ingresar instagram">
              </div>
            </div>

            <div class="form-group">
              <label for="nuevowhatsapp">WhatsApp</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                <input type="text" class="form-control input-lg" id="nuevowhatsapp" name="nuevowhatsapp" placeholder="Ingresar WhatsApp" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
            </div>

            <div class="form-group">
              <label for="nuevaDireccion">Dirección</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" id="nuevaDireccion" name="nuevaDireccion" placeholder="Ingresar dirección">
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer" style="border-top:none">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary-gradient">Guardar</button>
        </div>

        <?php
          $crearproveedor = new Controladorproveedores();
          $crearproveedor->ctrCrearproveedor();
        ?>
      </form>

    </div>
  </div>
</div>

<!-- =========================
     MODAL: Editar proveedor
     ========================= -->
<div id="modalEditarproveedor" class="modal fade" role="dialog" aria-labelledby="modalEditarproveedorLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#00bfff,#00d5ff); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalEditarproveedorLabel"><i class="fa fa-pencil"></i> Editar proveedor</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group">
              <label for="editarproveedor">Nombre</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="editarproveedor" id="editarproveedor" required>
                <input type="hidden" id="idproveedor" name="idproveedor">
              </div>
            </div>

            <div class="form-group">
              <label for="editarregistro">Registro / NIT</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="editarregistro" id="editarregistro" required>
              </div>
            </div>

            <div class="form-group">
              <label for="editarEmail">Email</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control input-lg" name="editarEmail" id="editarEmail">
              </div>
            </div>

            <div class="form-group">
              <label>Teléfono(s)</label>
              <div class="input-group" style="margin-bottom:8px">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="editarTelefono"  id="editarTelefono"  data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
              <div class="input-group" style="margin-bottom:8px">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="editarTelefono2" id="editarTelefono2" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="editarTelefono3" id="editarTelefono3" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
            </div>

            <div class="form-group">
              <label for="editarinstagram">Instagram</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                <input type="text" class="form-control input-lg" name="editarinstagram" id="editarinstagram">
              </div>
            </div>

            <div class="form-group">
              <label for="editarwhatsapp">WhatsApp</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                <input type="text" class="form-control input-lg" name="editarwhatsapp" id="editarwhatsapp" data-inputmask="'mask':' +99(9) 9999-9999'" data-mask>
              </div>
            </div>

            <div class="form-group">
              <label for="editarDireccion">Dirección</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion">
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer" style="border-top:none">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary-gradient">Guardar cambios</button>
        </div>

        <?php
          $editarproveedor = new Controladorproveedores();
          $editarproveedor->ctrEditarproveedor();
        ?>
      </form>

    </div>
  </div>
</div>

<?php
  /* Eliminar */
  $eliminarproveedor = new Controladorproveedores();
  $eliminarproveedor->ctrEliminarproveedor();
?>

<script>
$(function () {
  $('[data-toggle-tooltip="tooltip"]').tooltip();

  // Inicializa DataTables aquí si no lo haces globalmente
  if ($.fn.DataTable && !$.fn.dataTable.isDataTable('.tablas')) {
    $('.tablas').DataTable({
      pageLength: 10,
      lengthChange: true,
      order: [[0, 'asc']],
      language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
    });
  }
});
</script>
