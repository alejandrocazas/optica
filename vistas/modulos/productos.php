<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

/* Guardas de acceso */
if (empty($_SESSION['iniciarSesion']) || $_SESSION['iniciarSesion'] !== 'ok') {
  header('Location: ?ruta=login'); exit;
}
if (!empty($_SESSION['perfil']) && in_array($_SESSION['perfil'], ['Vendedor','Oftalmologico'], true)) {
  header('Location: ?ruta=inicio'); exit;
}
?>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Productos <small>Administrar</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?= '?ruta=inicio' ?>"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Productos</li>
    </ol>
  </section>

  <section class="content">

    <div class="card-modern">

      <div class="clearfix" style="margin-bottom:12px">
        <div class="pull-left">
          <span class="badge-icon"><i class="fa fa-cubes"></i> Inventario</span>
        </div>
        <div class="pull-right">
          <button class="btn btn-primary-gradient" data-toggle="modal" data-target="#modalAgregarProducto">
            <i class="fa fa-plus"></i> Agregar producto
          </button>
          <a class="btn btn-soft" href="extensiones/tcpdf/pdf/inventario.php" target="_blank" rel="noopener">
            <i class="fa fa-print"></i> Imprimir inventario
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-modern table-bordered dt-responsive tablaProductos text-uppercase" width="100%">
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Imagen</th>
              <th>Lote</th>
              <th>Código</th>
              <th>Descripción</th>
              <th>Stock</th>
              <th>Precio compra</th>
              <th>Precio venta</th>
              <th>Agregado</th>
              <th style="width:160px">Acciones</th>
            </tr>
          </thead>
        </table>
      </div>

      <input type="hidden" value="<?= htmlspecialchars($_SESSION['perfil'] ?? '', ENT_QUOTES, 'UTF-8') ?>" id="perfilOculto">
    </div>

  </section>
</div>

<!-- =========================
     MODAL: Agregar producto
     ========================= -->
<div id="modalAgregarProducto" class="modal fade" role="dialog" aria-labelledby="modalAgregarProductoLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#0072ff,#00c6ff); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalAgregarProductoLabel"><i class="fa fa-plus-square"></i> Agregar producto</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <!-- Categoría -->
            <div class="form-group">
              <label for="nuevaCategoria">Categoría</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>
                  <option value="">Seleccionar categoría</option>
                  <?php
                    $categorias = ControladorCategorias::ctrMostrarCategorias(null, null);
                    if (is_array($categorias)):
                      foreach ($categorias as $c):
                  ?>
                        <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars(mb_strtoupper($c['categoria'], 'UTF-8'), ENT_QUOTES, 'UTF-8') ?></option>
                  <?php
                      endforeach;
                    endif;
                  ?>
                </select>
              </div>
            </div>

            <!-- Lote -->
            <div class="form-group">
              <label for="nuevolote">Lote</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-cubes"></i></span>
                <input type="text" class="form-control input-lg" id="nuevolote" name="nuevolote" placeholder="Ingresar lote" required>
              </div>
            </div>

            <!-- Código -->
            <div class="form-group">
              <label for="nuevoCodigo">Código</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar código" required>
              </div>
            </div>

            <!-- Descripción -->
            <div class="form-group">
              <label for="nuevaDescripcion">Descripción</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" id="nuevaDescripcion" name="nuevaDescripcion" placeholder="Ingresar descripción del producto" required>
              </div>
            </div>

            <!-- Stock -->
            <div class="form-group">
              <label for="nuevoStock">Stock</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" id="nuevoStock" name="nuevoStock" min="0" placeholder="Stock" required>
              </div>
            </div>

            <!-- Precios + % -->
            <div class="form-group row">
              <div class="col-xs-6">
                <label for="nuevoPrecioCompra">Precio de compra</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" step="any" min="0" placeholder="Precio de compra" required>
                </div>
              </div>
              <div class="col-xs-6">
                <label for="nuevoPrecioVenta">Precio de venta</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                  <input type="number" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" min="0" placeholder="Precio de venta" required>
                </div>

                <br>

                <div class="col-xs-6">
                  <div class="form-group" style="margin-bottom:8px">
                    <label style="font-weight:600">
                      <input type="checkbox" class="minimal porcentaje" checked> Utilizar porcentaje (margen de ganancia)
                    </label>
                  </div>
                </div>
                <div class="col-xs-6" style="padding:0">
                  <div class="input-group">
                    <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Imagen -->
            <div class="form-group">
              <label>Imagen del producto</label>
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="nuevaImagen" accept="image/*">
              <p class="help-block">Peso máximo de la imagen 2MB</p>
              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="120" alt="Previsualización">
            </div>

          </div>
        </div>

        <div class="modal-footer" style="border-top:none">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary-gradient">Guardar</button>
        </div>

        <?php
          $crearProducto = new ControladorProductos();
          $crearProducto->ctrCrearProducto();
        ?>
      </form>

    </div>
  </div>
</div>

<!-- =========================
     MODAL: Editar producto
     ========================= -->
<div id="modalEditarProducto" class="modal fade" role="dialog" aria-labelledby="modalEditarProductoLabel">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:16px">

      <form role="form" method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="modal-header" style="border-bottom:none; background:linear-gradient(135deg,#0072ff,#00c6ff); color:#fff; border-top-left-radius:16px; border-top-right-radius:16px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modalEditarProductoLabel"><i class="fa fa-pencil-square-o"></i> Editar producto</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <!-- Categoría (solo lectura) -->
            <div class="form-group">
              <label for="editarCategoria">Categoría</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select class="form-control input-lg" name="editarCategoria" id="editarCategoriaSelect" readonly required>
                  <option id="editarCategoria"></option>
                </select>
              </div>
            </div>

            <!-- Lote -->
            <div class="form-group">
              <label for="editarlote">Lote</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-cubes"></i></span>
                <input type="text" class="form-control input-lg" id="editarlote" name="editarlote" readonly required>
              </div>
            </div>

            <!-- Código -->
            <div class="form-group">
              <label for="editarCodigo">Código</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" readonly required>
              </div>
            </div>

            <!-- Descripción -->
            <div class="form-group">
              <label for="editarDescripcion">Descripción</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required>
              </div>
            </div>

            <!-- Stock -->
            <div class="form-group">
              <label for="editarStock">Stock</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" min="0" required>
              </div>
            </div>

            <!-- Precios + % -->
            <div class="form-group row">
              <div class="col-xs-6">
                <label for="editarPrecioCompra">Precio de compra</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                  <input type="number" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>
                </div>
              </div>
              <div class="col-xs-6">
                <label for="editarPrecioVenta">Precio de venta</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                  <input type="number" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" step="any" min="0" readonly required>
                </div>

                <br>

                <div class="col-xs-6">
                  <div class="form-group" style="margin-bottom:8px">
                    <label style="font-weight:600">
                      <input type="checkbox" class="minimal porcentaje" checked> Utilizar porcentaje (margen de ganancia)
                    </label>
                  </div>
                </div>
                <div class="col-xs-6" style="padding:0">
                  <div class="input-group">
                    <input type="number" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Imagen -->
            <div class="form-group">
              <label>Imagen del producto</label>
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="editarImagen" accept="image/*">
              <p class="help-block">Peso máximo de la imagen 2MB</p>
              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="120" alt="Previsualización">
              <input type="hidden" name="imagenActual" id="imagenActual">
            </div>

          </div>
        </div>

        <div class="modal-footer" style="border-top:none">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary-gradient">Guardar cambios</button>
        </div>

        <?php
          $editarProducto = new ControladorProductos();
          $editarProducto->ctrEditarProducto();
        ?>
      </form>

    </div>
  </div>
</div>

<?php
  $eliminarProducto = new ControladorProductos();
  $eliminarProducto->ctrEliminarProducto();
?>


<script>
/*  Este bloque:
    1) Verifica que jQuery y DataTables estén cargados
    2) Evita “already initialized”
    3) Inicializa la tabla y muestra errores útiles en consola
*/
(function initProductosDT() {
  // 0) Verificación: jQuery + DataTables cargados
  if (typeof jQuery === 'undefined') {
    console.error('jQuery no está cargado. Asegúrate de incluirlo ANTES de este bloque.');
    return;
  }
  if (!jQuery.fn || !jQuery.fn.DataTable) {
    console.error('DataTables no está cargado. Incluye los JS/CSS de DataTables antes del init.');
    return;
  }
  jQuery.fn.dataTable.ext.errMode = 'console';

  jQuery(function ($) {
    var perfil = $('#perfilOculto').val() || '';
    var $tabla = $('.tablaProductos');

    // 1) Evita re-inicializar
    if ($.fn.dataTable.isDataTable($tabla)) {
      $tabla.DataTable().destroy();
      $tabla.find('tbody').empty();
    }

    // 2) Inicializa con AJAX
    $tabla.DataTable({
      ajax: {
        url: 'ajax/datatable-productos.ajax.php',
        type: 'GET',
        data: { perfilOculto: perfil },
        dataSrc: function (json) {
          // Si el PHP imprimió un Notice/Warning, verás HTML aquí
          if (!json || typeof json !== 'object') {
            console.error('Respuesta no JSON de datatable-productos.ajax.php:', json);
            return [];
          }
          if (!('data' in json)) {
            console.error('JSON sin propiedad "data":', json);
            return [];
          }
          return json.data;
        },
        error: function (xhr) {
          console.error('AJAX error datatable-productos.ajax.php',
            { status: xhr.status, statusText: xhr.statusText, body: xhr.responseText });
        }
      },
      deferRender: true,
      retrieve: true,
      processing: true,
      responsive: true,
      order: [[0, 'asc']],
      language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
      // Si el AJAX devuelve ya filas "listas" (arrays/cadenas HTML), no declares "columns".
      // Si devolviera objetos: usa columns: [...]
    });
  });
})();
</script>


