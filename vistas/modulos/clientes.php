<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

/* Guardas de acceso (server-side, sin JS) */
if (empty($_SESSION['iniciarSesion']) || $_SESSION['iniciarSesion'] !== 'ok') {
  header('Location: ?ruta=login'); exit;
}

/* Datos */
$clientes = ControladorClientes::ctrMostrarClientes(null, null);
?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Clientes <small>Administrar</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?= '?ruta=inicio' ?>"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Clientes</li>
    </ol>
  </section>

  <section class="content">

    <div class="card-modern">

      <div class="clearfix" style="margin-bottom:12px">
        <div class="pull-left">
          <span class="badge-icon"><i class="fa fa-id-card"></i> Directorio de clientes</span>
        </div>
        <div class="pull-right">
          <button class="btn btn-primary-gradient" data-toggle="modal" data-target="#modalAgregarCliente">
            <i class="fa fa-user-plus"></i> Agregar cliente
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-modern table-bordered dt-responsive tablas table-hover" style="width:100%; font-size:14px">
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Cliente</th>
              <th>C.I.</th>
              <th>Datos</th>
              <th>Total compras</th>
              <th>Última compra</th>
              <th>Ingreso al sistema</th>
              <th style="width:200px">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php if (is_array($clientes)): ?>
            <?php foreach ($clientes as $i => $c): ?>
              <?php
                $id       = (int)($c['id'] ?? 0);
                $nombre   = htmlspecialchars($c['nombre']   ?? '', ENT_QUOTES, 'UTF-8');
                $apellido = htmlspecialchars($c['apellido'] ?? '', ENT_QUOTES, 'UTF-8');
                $documento= htmlspecialchars($c['documento']?? '', ENT_QUOTES, 'UTF-8');
                $dir      = htmlspecialchars($c['direccion']?? '', ENT_QUOTES, 'UTF-8');
                $tel      = htmlspecialchars($c['telefono'] ?? '', ENT_QUOTES, 'UTF-8');
                $mail     = htmlspecialchars($c['email']    ?? '', ENT_QUOTES, 'UTF-8');
                $compras  = htmlspecialchars($c['compras']  ?? '0', ENT_QUOTES, 'UTF-8');
                $ult      = htmlspecialchars($c['ultima_compra'] ?? '', ENT_QUOTES, 'UTF-8');
                $falta    = htmlspecialchars($c['fecha']    ?? '', ENT_QUOTES, 'UTF-8');
              ?>
              <tr>
                <td><?= (int)($i+1) ?></td>

                <td class="text-uppercase">
                  <strong><?= trim($nombre.' '.$apellido) ?></strong>
                </td>

                <td><?= $documento ?></td>

                <td class="text-uppercase">
                  <?php if ($dir): ?>
                    <i class="fa fa-map-marker"></i> <?= $dir ?><br>
                  <?php endif; ?>
                  <?php if ($tel): ?>
                    <i class="fa fa-phone"></i> <?= $tel ?><br>
                  <?php endif; ?>
                  <?php if ($mail): ?>
                    <i class="fa fa-envelope"></i> <?= $mail ?>
                  <?php endif; ?>
                  <?php if (!$dir && !$tel && !$mail): ?>
                    <span class="text-muted">Sin datos</span>
                  <?php endif; ?>
                </td>

                <td><?= $compras ?></td>
                <td><?= $ult ?: '<span class="text-muted">—</span>' ?></td>
                <td><?= $falta ?: '<span class="text-muted">—</span>' ?></td>

                <td class="table-actions">
                  <div class="btn-group" role="group" aria-label="Acciones">
                    <button class="btn btn-warning btn-sm btnEditarCliente"
                            data-toggle="modal" data-target="#modalEditarCliente"
                            idCliente="<?= $id ?>" title="Editar" data-toggle-tooltip="tooltip">
                      <i class="fa fa-pencil"></i>
                    </button>

                    <?php if (!empty($_SESSION['perfil']) && $_SESSION['perfil'] === 'Administrador'): ?>
                      <button class="btn btn-danger btn-sm btnEliminarCliente"
                              idCliente="<?= $id ?>" title="Eliminar" data-toggle-tooltip="tooltip">
                        <i class="fa fa-trash"></i>
                      </button>
                    <?php endif; ?>

                    <button class="btn btn-info btn-sm btnVerReceta"
                            idCliente="<?= $id ?>" title="Ver receta" data-toggle-tooltip="tooltip">
                      <i class="fa fa-eye"></i>
                    </button>

                    <button class="btn btn-default btn-sm btnHistorialVentas"
                            idCliente="<?= $id ?>" title="Historial de ventas" data-toggle-tooltip="tooltip">
                      <i class="fa fa-file-text-o"></i>
                    </button>
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
     MODAL: Agregar cliente
     ========================= -->
<div id="modalAgregarCliente" class="modal fade" role="dialog" aria-labelledby="modalAgregarClienteLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#0072ff,#00c6ff); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalAgregarClienteLabel"><i class="fa fa-user-plus"></i> Agregar cliente</h4>
        </div>

        <div class="modal-body">
          <strong>Mínimo: Nombre, CI y Teléfono.</strong>
          <div class="box-body">

            <div class="form-group">
              <label for="nuevoCliente">Nombre</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoCliente" name="nuevoCliente" placeholder="Ingresar nombre" required>
              </div>
            </div>

            <div class="form-group">
              <label for="nuevoapellido">Apellido</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user-o"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoapellido" name="nuevoapellido" placeholder="Ingresar apellido">
              </div>
            </div>

            <div class="form-group">
              <label for="nuevoDocumentoId">CI / NIT</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoDocumentoId" name="nuevoDocumentoId" maxlength="10" placeholder="CI/NIT" required>
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
              <label for="nuevoTelefono">Teléfono</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoTelefono" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'99999999'" data-mask required>
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
          $crearCliente = new ControladorClientes();
          $crearCliente->ctrCrearCliente();
        ?>
      </form>

    </div>
  </div>
</div>

<!-- =========================
     MODAL: Editar cliente
     ========================= -->
<div id="modalEditarCliente" class="modal fade" role="dialog" aria-labelledby="modalEditarClienteLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#02ac66,#22c38a); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalEditarClienteLabel"><i class="fa fa-pencil"></i> Editar cliente</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <div class="form-group">
              <label for="editarCliente">Nombre</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="editarCliente" id="editarCliente" required>
                <input type="hidden" id="idCliente" name="idCliente">
              </div>
            </div>

            <div class="form-group">
              <label for="editarapellido">Apellido</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user-o"></i></span>
                <input type="text" class="form-control input-lg" name="editarapellido" id="editarapellido">
              </div>
            </div>

            <div class="form-group">
              <label for="editarDocumentoId">CI / NIT</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="text" class="form-control input-lg" name="editarDocumentoId" id="editarDocumentoId" maxlength="10" placeholder="CI/NIT" required>
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
              <label for="editarTelefono">Teléfono</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'99999999'" data-mask required>
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
          $editarCliente = new ControladorClientes();
          $editarCliente->ctrEditarCliente();
        ?>
      </form>

    </div>
  </div>
</div>

<?php
  /* Eliminar */
  $eliminarCliente = new ControladorClientes();
  $eliminarCliente->ctrEliminarCliente();
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
