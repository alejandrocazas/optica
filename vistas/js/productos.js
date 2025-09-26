/* productos.js (limpio) */
(function ($) {
  'use strict';

  // ---- Helpers ----
  function money(n) { return (Number(n) || 0).toFixed(2); }

  // ---- Tabla de productos (DataTables) ----
  $(function () {
    // Evita que DataTables silencie errores
    if ($.fn.dataTable && $.fn.dataTable.ext) {
      $.fn.dataTable.ext.errMode = 'console';
    }

    var perfil = $('#perfilOculto').val() || '';

    if (!$.fn.DataTable) {
      console.error('DataTables no está cargado (revisa el orden de <script>)');
      return;
    }

    var tabla = $('.tablaProductos').DataTable({
      ajax: 'ajax/datatable-productos.ajax.php?perfilOculto=' + encodeURIComponent(perfil),
      deferRender: true,
      retrieve: true,
      processing: true,
      responsive: true,
      order: [[0, 'asc']],
      language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
      columnDefs: [
        { targets: [0], width: 60 },
        { targets: -1, orderable: false, searchable: false, width: 160 }
      ]
    });

    // ---- Cálculo por porcentaje (margen) en formularios de producto ----
    // .porcentaje (checkbox) / .nuevoPorcentaje (input %)
    $(document).on('change', '.porcentaje', function () {
      var checked = $(this).is(':checked');
      $('#editarPrecioVenta, #nuevoPrecioVenta').prop('readonly', checked);

      if (checked) {
        $('.nuevoPorcentaje').trigger('input');
      }
    });

    $(document).on('input', '.nuevoPorcentaje', function () {
      if (!$('.porcentaje').is(':checked')) return;

      var p = parseFloat($(this).val() || '0');
      var compra = parseFloat($('#nuevoPrecioCompra').val() || $('#editarPrecioCompra').val() || '0');

      var pv = compra + (compra * p / 100);
      $('#nuevoPrecioVenta, #editarPrecioVenta').val(money(pv)).prop('readonly', true);
    });

    // ---- Validación + previsualización de imagen ----
    $(document).on('change', '.nuevaImagen', function () {
      var file = this.files && this.files[0];
      if (!file) return;

      if (!/image\/(jpeg|png)/i.test(file.type)) {
        $(this).val('');
        swal({ title: 'Error al subir la imagen',
               text: '¡La imagen debe estar en formato JPG o PNG!',
               type: 'error', confirmButtonText: 'Cerrar' });
        return;
      }

      if (file.size > 2 * 1024 * 1024) {
        $(this).val('');
        swal({ title: 'Error al subir la imagen',
               text: '¡La imagen no debe pesar más de 2MB!',
               type: 'error', confirmButtonText: 'Cerrar' });
        return;
      }

      var reader = new FileReader();
      reader.onload = function (e) {
        $('.previsualizar').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    });

    // ---- Editar producto (abrir modal con datos) ----
    $('.tablaProductos tbody').on('click', '.btnEditarProducto', function () {
      var idProducto = $(this).attr('idProducto');
      if (!idProducto) return;

      var fd = new FormData();
      fd.append('idProducto', idProducto);

      $.ajax({
        url: 'ajax/productos.ajax.php',
        method: 'POST',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json'
      }).done(function (r) {
        // Completa campos del modal Editar
        // Categoría
        var fd2 = new FormData();
        fd2.append('idCategoria', r.id_categoria);
        $.ajax({
          url: 'ajax/categorias.ajax.php',
          method: 'POST',
          data: fd2,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json'
        }).done(function (cat) {
          $('#editarCategoria').val(cat.categoria);
          $('#editarCategoriaSelect').html(
            '<option value="'+r.id_categoria+'" selected>'+ (cat.categoria||'') +'</option>'
          );
        });

        $('#editarDescripcion').val(r.descripcion || '');
        $('#editarCodigo').val(r.codigo || '');
        $('#editarlote').val(r.lote || '');
        $('#editarStock').val(r.stock || 0);

        $('#editarPrecioCompra').val(r.precio_compra || 0);
        $('#editarPrecioVenta').val(r.precio_venta || 0);

        if (r.imagen) {
          $('#imagenActual').val(r.imagen);
          $('.previsualizar').attr('src', r.imagen);
        } else {
          $('#imagenActual').val('');
          $('.previsualizar').attr('src', 'vistas/img/productos/default/anonymous.png');
        }
      });
    });

    // ---- Eliminar producto ----
    $('.tablaProductos tbody').on('click', '.btnEliminarProducto', function () {
      var idProducto = $(this).attr('idProducto');
      var codigo     = $(this).attr('codigo') || '';
      var imagen     = $(this).attr('imagen') || '';

      swal({
        title: '¿Está seguro de borrar el producto?',
        text: '¡Si no lo está puede cancelar la acción!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
      }).then(function (result) {
        if (result && result.value) {
          // Redirección clásica del template
          window.location = 'index.php?ruta=productos&idProducto=' + encodeURIComponent(idProducto) +
                            '&imagen=' + encodeURIComponent(imagen) +
                            '&codigo=' + encodeURIComponent(codigo);
        }
      });
    });

  });
})(jQuery);
