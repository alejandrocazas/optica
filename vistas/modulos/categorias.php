<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

/* Guardas de acceso */
if (empty($_SESSION['iniciarSesion']) || $_SESSION['iniciarSesion'] !== 'ok') {
  header('Location: ?ruta=login'); exit;
}
if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'Vendedor') {
  header('Location: ?ruta=inicio'); exit;
}

/* Datos */
$item = null; $valor = null;
$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Categorías <small>Administrar</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?= '?ruta=inicio' ?>"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Categorías</li>
    </ol>
  </section>

  <section class="content">

    <!-- Card contenedor -->
    <div class="card-modern">

      <div class="clearfix" style="margin-bottom:12px">
        <div class="pull-left">
          <span class="badge-icon"><i class="fa fa-tags"></i> Maestro de categorías</span>
        </div>
        <div class="pull-right">
          <button class="btn btn-primary-gradient" data-toggle="modal" data-target="#modalAgregarCategoria">
            <i class="fa fa-plus"></i> Agregar categoría
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table id="tablaCategorias" class="table table-striped table-modern table-bordered dt-responsive tablas" width="100%">
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Categoría</th>
              <th style="width:160px">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php if (is_array($categorias)): ?>
            <?php foreach ($categorias as $i => $cat): ?>
              <tr>
                <td><?= (int)($i+1) ?></td>
                <td class="text-uppercase"><?= htmlspecialchars($cat['categoria'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td class="table-actions">
                  <div class="btn-group" role="group" aria-label="Acciones">
                    <button class="btn btn-warning btnEditarCategoria"
                            idCategoria="<?= (int)$cat['id'] ?>"
                            data-toggle="modal" data-target="#modalEditarCategoria"
                            data-toggle-tooltip="tooltip" title="Editar">
                      <i class="fa fa-pencil"></i>
                    </button>
                    <?php if (!empty($_SESSION['perfil']) && $_SESSION['perfil'] === 'Administrador'): ?>
                      <button class="btn btn-danger btnEliminarCategoria"
                              idCategoria="<?= (int)$cat['id'] ?>"
                              data-toggle-tooltip="tooltip" title="Eliminar">
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
     MODAL: Agregar categoría
     ========================= -->
<div id="modalAgregarCategoria" class="modal fade" role="dialog" aria-labelledby="modalAgregarCategoriaLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#0072ff,#00c6ff); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalAgregarCategoriaLabel"><i class="fa fa-tag"></i> Agregar categoría</h4>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="nuevaCategoria">Nombre de la categoría</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-th"></i></span>
              <input type="text" class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria"
                     placeholder="Ingresar categoría" required>
            </div>
          </div>
        </div>

        <div class="modal-footer" style="border-top:none">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary-gradient">Guardar</button>
        </div>

        <?php
          $crearCategoria = new ControladorCategorias();
          $crearCategoria->ctrCrearCategoria();
        ?>
      </form>

    </div>
  </div>
</div>

<!-- =========================
     MODAL: Editar categoría
     ========================= -->
<div id="modalEditarCategoria" class="modal fade" role="dialog" aria-labelledby="modalEditarCategoriaLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#0072ff,#00c6ff); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalEditarCategoriaLabel"><i class="fa fa-pencil"></i> Editar categoría</h4>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="editarCategoria">Nombre de la categoría</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-th"></i></span>
              <input type="text" class="form-control input-lg" name="editarCategoria" id="editarCategoria" required>
              <input type="hidden" name="idCategoria" id="idCategoria" required>
            </div>
          </div>
        </div>

        <div class="modal-footer" style="border-top:none">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary-gradient">Guardar cambios</button>
        </div>

        <?php
          $editarCategoria = new ControladorCategorias();
          $editarCategoria->ctrEditarCategoria();
        ?>
      </form>

    </div>
  </div>
</div>

<?php
  /* Eliminar */
  $borrarCategoria = new ControladorCategorias();
  $borrarCategoria->ctrBorrarCategoria();
?>

<script>
$(function () {
  // Tooltips
  $('[data-toggle-tooltip="tooltip"]').tooltip();

  // Si no inicializas DataTables en otro archivo, puedes hacerlo aquí:
  if ($.fn.DataTable && !$.fn.dataTable.isDataTable('#tablaCategorias')) {
    $('#tablaCategorias').DataTable({
      pageLength: 10,
      lengthChange: true,
      order: [[0, 'asc']],
      language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
    });
  }
});
</script>

