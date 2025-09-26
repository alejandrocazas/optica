<?php
if($_SESSION["perfil"] == "Especial"){
  echo '<script>window.location="inicio";</script>';
  return;
}

/* Helpers */
if (!function_exists('proper_case')) {
  function proper_case($s) {
    $s = mb_strtolower((string)$s, 'UTF-8');
    return mb_convert_case($s, MB_CASE_TITLE, 'UTF-8');
  }
}
if (!function_exists('h')) {
  function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

/* Traer productos para buscador y catálogo (3er parámetro = orden) */
$prods = ControladorProductos::ctrMostrarProductos(null, null, "id");

?>
<div class="content-wrapper">

  <section class="content-header">
    <h1><i class="ion ion-arrow-right-a"></i> CREAR ORDEN DE TRABAJO.</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Crear Orden</li>
    </ol>
  </section>

  <section class="content">

    <div class="row">

      <!-- ===================== -->
      <!--   FORMULARIO (IZQ)    -->
      <!-- ===================== -->
      <div class="col-lg-5 col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioVenta">
            <div class="box-body">
              <div class="box">

                <!-- VENDEDOR -->
                <div class="form-group">
                  <label style="display:block;margin-bottom:6px;color:#2f855a;font-weight:600;">Vendedor</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo h($_SESSION["nombre"]); ?>" readonly>
                    <input type="hidden" name="idVendedor" value="<?php echo (int)$_SESSION["id"]; ?>">
                    <span class="input-group-addon" style="background:#e6ffed;border-left:0">
                      <span class="label label-success" style="display:inline-block;padding:5px 8px;border-radius:10px">ID: <?php echo (int)$_SESSION["id"]; ?></span>
                    </span>
                  </div>
                </div>

                <!-- N° ORDEN -->
                <div class="form-group">
                  <label>N° orden</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <?php
                      $ventas = ControladorVentas::ctrMostrarVentas(null, null);
                      if(!$ventas){
                        $codigo = 10001;
                      }else{
                        $ultimo = end($ventas);
                        $codigo = ((int)$ultimo["codigo"]) + 1;
                      }
                    ?>
                    <input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="<?php echo h($codigo); ?>" readonly>
                  </div>
                </div>

                <!-- CLIENTE -->
                <div class="form-group">
                  <label>Cliente (CI/NIT)</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <select class="selectpicker" name="seleccionarCliente" id="seleccionarCliente"
                            data-live-search="true" data-width="100%" title="CONSULTAR AQUÍ" required>
                      <?php
                        $clientes = ControladorClientes::ctrMostrarClientes(null, null);
                        echo '<option></option>';
                        foreach ($clientes as $c){
                          $id = (int)$c['id'];
                          $doc = h($c['documento']);
                          $nom = proper_case($c['nombre']);
                          $ape = proper_case($c['apellido']);
                          echo '<option value="'.$id.'">'.$doc.' - '.$nom.' '.$ape.'</option>';
                        }
                      ?>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalAgregarCliente">
                        <i class="fa fa-user-plus"></i> Nuevo
                      </button>
                    </span>
                  </div>
                </div>

                <!-- BOTONES AUX -->
                <div class="form-group">
                  <div class="btn-group">
                    <button type="button"
        id="btnVerReceta"
        class="btn btn-info"
        data-toggle="modal"
        data-target="#modalVerReceta">
  <i class="fa fa-eye"></i> Ver receta médica
</button>

                    <button type="button" class="btn btn-warning btnTecnologo" data-toggle="modal" data-target="#modalAlertarTecnologo">
                      <i class="fa fa-bell"></i> Alertar tecnólogo
                    </button>
                  </div>
                </div>

                <!-- AGREGAR PRODUCTO (buscador + Añadir) -->
                <div class="form-group">
                  <label>Agregar productos</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <select id="buscarProducto" class="form-control">
                      <option value="" selected disabled>Buscar producto (código / descripción)…</option>
                      <?php
                        if (is_array($prods)) {
                          foreach ($prods as $p) {
                            $precio = isset($p["precio_venta"]) ? (float)$p["precio_venta"] : (isset($p["precio_compra"]) ? (float)$p["precio_compra"] : 0);
                            $desc = trim(($p["codigo"] ?? '') . ' - ' . ($p["descripcion"] ?? ''));
                            echo '<option value="'.h($p["id"]).'"
                                     data-codigo="'.h($p["codigo"] ?? '').'"
                                     data-descripcion="'.h($p["descripcion"] ?? '').'"
                                     data-precio="'.h(number_format($precio,2,'.','')).'"
                                     data-stock="'.h($p["stock"] ?? 0).'">'
                                  .h($desc).'</option>';
                          }
                        }
                      ?>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" id="btnAgregarProductoBusqueda" class="btn btn-success">
                        <i class="fa fa-plus"></i> Añadir
                      </button>
                    </span>
                  </div>
                  <p class="help-block">Selecciona y pulsa “Añadir”.</p>
                </div>

                <!-- Líneas de la venta -->
                <div class="form-group nuevoProducto">
                  <table class="table table-condensed table-hover" id="tablaLineas">
                    <thead>
                      <tr>
                        <th style="width:15%">Código</th>
                        <th>Descripción</th>
                        <th style="width:18%">Precio</th>
                        <th style="width:16%">Cant.</th>
                        <th style="width:18%">Subtotal</th>
                        <th style="width:7%"></th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <hr>

                <!-- TOTALES sin impuesto -->
                <div class="row">
                  <div class="col-xs-12 pull-right">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="width:40%">Sub total</th>
                          <th style="width:30%">Descuento</th>
                          <th style="width:30%">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <!-- SUBTOTAL -->
                          <td>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-cash"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" value="0.00" readonly>
                              <input type="hidden" id="totalVenta" name="totalVenta" value="0">
                            </div>
                          </td>
                          <!-- DESCUENTO monto -->
                          <td>
                            <div class="input-group">
                              <input type="number" min="0" step="0.01" class="form-control input-lg"
                                     id="nuevoDescuentoVenta" name="nuevoDescuentoVenta" value="0"
                                     oninput="SumarDatosFinancieros()">
                              <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                            </div>
                          </td>
                          <!-- TOTAL -->
                          <td>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-checkmark"></i></span>
                              <input type="text" class="form-control input-lg" id="nuevoTotalFinal" name="nuevoTotalFinal" value="0.00" readonly>
                              <input type="hidden" id="totalVentaFinal" name="totalVentaFinal" value="0">
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <hr>

                <!-- FORMA DE PAGO: solo Contado / Abono -->
                <div class="form-group row">
                  <div class="col-xs-6" style="padding-right:0">
                    <div class="input-group">
                      <select class="form-control" id="nuevoFormaPago" name="nuevoFormaPago" required>
                        <option value="">FORMA DE PAGO</option>
                        <option value="CONTADO">Contado</option>
                        <option value="ABONO">Abono</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- ABONO y SALDO -->
                <div class="row">
                  <div class="col-xs-12 pull-right">
                    <table class="table">
                      <thead>
                        <tr>
                          <th style="width:50%">Abono</th>
                          <th style="width:50%">Saldo Pendiente</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="input-group">
                              <input type="number" class="form-control input-lg" min="0" step="0.01"
                                     id="Abono" name="Abono" value="0" oninput="SumarDatosFinancieros()">
                              <input type="hidden" id="abonoNeto" name="abonoNeto" value="0">
                              <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                            </div>
                          </td>
                          <td>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-arrow-right-a"></i></span>
                              <input type="text" class="form-control input-lg" id="SaldoPendiente" name="SaldoPendiente" value="0.00" readonly>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- OBS / FECHA ENTREGA -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="ion ion-compose"></i> Observación: </span>
                    <input type="text" class="form-control input-lg" id="Observaciones" name="Observaciones" required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="ion ion-calendar"></i> Fecha de Entrega: </span>
                    <input type="datetime-local" class="form-control input-lg" id="FechaEntrega" name="FechaEntrega" required>
                  </div>
                </div>

                <!-- === Compat con Controlador === -->
                <input type="hidden" name="nuevoMetodoPago" id="nuevoMetodoPago" value="Efectivo">
                <input type="hidden" name="listaMetodoPago" id="listaMetodoPago" value="{}">
                <input type="hidden" name=" nuevoImpuestoVenta" id="nuevoImpuestoVenta" value="0">
                <input type="hidden" name="nuevoPrecioImpuesto" id="nuevoPrecioImpuesto" value="0">
                <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" value="0">
                <!-- =============================== -->

              </div><!-- /.box -->
            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" id="CrearVenta" class="btn btn-danger pull-right">
                <i class="ion ion-arrow-right-a"></i> REALIZAR VENTA
              </button>
            </div>
          </form>

          <?php
            $guardarVenta = new ControladorVentas();
            $guardarVenta -> ctrCrearVenta();
          ?>

        </div>
      </div>

      <!-- ===================== -->
      <!--   CATÁLOGO (DER)      -->
      <!-- ===================== -->
      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list-alt"></i> Catálogo de productos</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th style="width:10px">#</th>
                  <th>Imagen</th>
                  <th>Descripción</th>
                  <th>Categoría</th>
                  <th>Código</th>
                  <th>Precio</th>
                  <th>Stock</th>
                </tr>
              </thead>
              <tbody>
<?php
  $i = 1;
  if (is_array($prods)) {
    foreach ($prods as $p):

      // 1) Tomamos el valor de BD y normalizamos separadores
      $imgDb = trim($p['imagen'] ?? '');
      $imgDb = str_replace('\\', '/', $imgDb);

      // 2) Si viene absoluta (http/https), úsala tal cual
      if ($imgDb !== '' && (stripos($imgDb, 'http://') === 0 || stripos($imgDb, 'https://') === 0)) {
        $imgWeb = $imgDb;
        $fsPath = null; // no comprobamos fs
      } else {
        // 3) Si es relativa: si no empieza por 'vistas/', prepéndalo
        if ($imgDb !== '' && strpos($imgDb, 'vistas/') !== 0) {
          $imgWeb = 'vistas/img/productos/' . ltrim($imgDb, '/');
        } else {
          $imgWeb = $imgDb;
        }

        // 4) Construimos base de proyecto (dos niveles arriba de /vistas/modulos/)
        $projectBase = dirname(__DIR__, 2); // => ruta absoluta al root del proyecto
        $fsPath = $projectBase . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, ltrim($imgWeb, '/'));

        // 5) Si no existe el archivo, placeholder
        if ($imgWeb === '' || !is_file($fsPath)) {
          $imgWeb = 'vistas/img/productos/default/anonymous.png';
        }
      }

      $desc = h($p['descripcion'] ?? '');

      // categoría
      $catName = '';
      if (!empty($p['categoria'])) {
        $catName = $p['categoria'];
      } elseif (!empty($p['id_categoria'])) {
        $catRow = ControladorCategorias::ctrMostrarCategorias('id', $p['id_categoria']);
        $catName = $catRow['categoria'] ?? '';
      }
      $catName = h($catName);

      $cod   = h($p['codigo'] ?? '');
      $pre   = isset($p['precio_venta']) ? number_format((float)$p['precio_venta'], 0, ',', '.') : '0';
      $stk   = (int)($p['stock'] ?? 0);
      $badge = ($stk < 10) ? 'bg-red' : (($stk <= 20) ? 'bg-yellow' : 'bg-green');
?>
  <tr>
    <td><?= $i++; ?></td>
    <td>
      <img src="<?= h($imgWeb); ?>" alt=""
           style="width:38px;height:38px;border-radius:6px;object-fit:cover;">
    </td>
    <td><?= $desc; ?></td>
    <td><?= $catName; ?></td>
    <td class="text-monospace"><?= $cod; ?></td>
    <td><?= $pre; ?></td>
    <td><span class="badge <?= $badge ?>"><?= $stk; ?></span></td>
  </tr>
<?php
    endforeach;
  }
?>


              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div><!-- /.row -->

  </section>

</div>

<!-- ========================= -->
<!--   MODAL: VER RECETA       -->
<!-- ========================= -->
<!-- ================================
     MODAL: BUSCAR / VER RECETA
================================ -->
<div id="modalVerReceta" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header" style="background:#5c657d;color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-user-md"></i> Buscar receta médica</h4>
      </div>

      <div class="modal-body" style="padding-top:10px">
        <!-- Datos del paciente -->
        <div class="box" style="border:1px solid #e5e7eb">
          <div class="box-header" style="background:#f3f4f6;border-bottom:1px solid #e5e7eb">
            <h4 class="box-title" style="margin:8px 0">Datos del paciente</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-sm-4">
                <label>CI/NIT</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-id-card"></i></span>
                  <input type="text" class="form-control" id="rx_doc_ci" readonly>
                </div>
                <small class="text-muted" id="rx_num_atencion"></small>
              </div>

              <div class="col-sm-4">
                <label>Primer Nombre</label>
                <input type="text" class="form-control" id="rx_nombre" readonly>
              </div>

              <div class="col-sm-4">
                <label>Primer Apellido</label>
                <input type="text" class="form-control" id="rx_apellido" readonly>
              </div>

              <div class="col-sm-4">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="rx_telefono" readonly>
              </div>

              <div class="col-sm-8">
                <label>Dirección</label>
                <input type="text" class="form-control" id="rx_direccion" readonly>
              </div>

              <div class="col-sm-12">
                <label>Anamnesis</label>
                <input type="text" class="form-control" id="rx_anamnesis" readonly>
              </div>

              <div class="col-sm-12">
                <label>Antecedentes</label>
                <input type="text" class="form-control" id="rx_antecedentes" readonly>
              </div>
            </div>
          </div>
        </div>

        <!-- Refracción: LEJOS -->
        <div class="box" style="border:1px solid #dbeafe">
          <div class="box-header" style="background:#eaf4ff;border-bottom:1px solid #60a5fa">
            <h4 class="box-title" style="margin:8px 0">Refracción lejos</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-sm-4">
                <label>OD Esfera</label>
                <input type="text" class="form-control" id="rx_lejos_od_esfera" readonly>
              </div>
              <div class="col-sm-4">
                <label>OD Cilindro</label>
                <input type="text" class="form-control" id="rx_lejos_od_cilindro" readonly>
              </div>
              <div class="col-sm-4">
                <label>OD Eje</label>
                <input type="text" class="form-control" id="rx_lejos_od_eje" readonly>
              </div>

              <div class="col-sm-4">
                <label>OI Esfera</label>
                <input type="text" class="form-control" id="rx_lejos_oi_esfera" readonly>
              </div>
              <div class="col-sm-4">
                <label>OI Cilindro</label>
                <input type="text" class="form-control" id="rx_lejos_oi_cilindro" readonly>
              </div>
              <div class="col-sm-4">
                <label>OI Eje</label>
                <input type="text" class="form-control" id="rx_lejos_oi_eje" readonly>
              </div>

              <div class="col-sm-4">
                <label>ADD</label>
                <input type="text" class="form-control" id="rx_add" readonly>
              </div>
              <div class="col-sm-4">
                <label>DP</label>
                <input type="text" class="form-control" id="rx_dp" readonly>
              </div>
            </div>
          </div>
        </div>

        <!-- Refracción: CERCA -->
        <div class="box" style="border:1px solid #d1fae5">
          <div class="box-header" style="background:#ecfdf5;border-bottom:1px solid #34d399">
            <h4 class="box-title" style="margin:8px 0">Refracción cerca</h4>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-sm-4">
                <label>OD Esfera</label>
                <input type="text" class="form-control" id="rx_cerca_od_esfera" readonly>
              </div>
              <div class="col-sm-4">
                <label>OD Cilindro</label>
                <input type="text" class="form-control" id="rx_cerca_od_cilindro" readonly>
              </div>
              <div class="col-sm-4">
                <label>OD Eje</label>
                <input type="text" class="form-control" id="rx_cerca_od_eje" readonly>
              </div>

              <div class="col-sm-4">
                <label>OI Esfera</label>
                <input type="text" class="form-control" id="rx_cerca_oi_esfera" readonly>
              </div>
              <div class="col-sm-4">
                <label>OI Cilindro</label>
                <input type="text" class="form-control" id="rx_cerca_oi_cilindro" readonly>
              </div>
              <div class="col-sm-4">
                <label>OI Eje</label>
                <input type="text" class="form-control" id="rx_cerca_oi_eje" readonly>
              </div>
            </div>
          </div>
        </div>

      </div><!-- /.modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>


<!-- ========================= -->
<!--   MODAL: ALERTAR TECN.    -->
<!-- ========================= -->
<div id="modalAlertarTecnologo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header" style="background:#666F88;color:#fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="ion ion-arrow-right-a"></i> ALERTAR A TECNÓLOGO PARA SU PREPARACIÓN</h4>
        </div>
        <div class="modal-body">
          <strong>Una vez seleccionado el cliente, los datos se cargarán aquí. Deja una observación para el especialista.</strong>
          <div class="form-group" style="margin-top:10px">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input readonly type="text" class="form-control input-lg" id="clienteAlerta" name="clienteAlerta" placeholder="Datos Paciente">
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input type="text" class="form-control input-lg" name="observacionAlerta" placeholder="Observación">
          </div>
        </div>
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

<!-- ========================= -->
<!--   MODAL: NUEVO CLIENTE    -->
<!-- ========================= -->
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <div class="modal-header" style="background:#666F88;color:#fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="ion ion-arrow-right-a"></i> CREAR CLIENTE</h4>
        </div>
        <div class="modal-body">
          <strong>Mínimo: Nombre, CI y Teléfono.</strong>
          <div class="form-group" style="margin-top:10px">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control input-lg" name="nuevoapellido" placeholder="Ingresar apellido">
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input type="text" class="form-control input-lg" name="nuevoDocumentoId" maxlength="10" placeholder="CI/NIT" required>
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email">
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            <input type="text" class="form-control input-lg" name="nuevoTelefono" data-inputmask="'mask':' 99999999'" data-mask placeholder="Ingresar teléfono" required>
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
            <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary"><i class="ion ion-arrow-right-a"></i> Guardar cliente</button>
        </div>
      </form>
      <?php
        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();
      ?>
    </div>
  </div>
</div>

<!-- ========================= -->
<!--  JS de líneas y totales   -->
<!-- ========================= -->
<script>
/* =========================
   TOTALES (sin impuestos)
   ========================= */
function SumarDatosFinancieros(){
  var sub = parseFloat((document.getElementById('totalVenta')?.value || "0").replace(',', '.')) || 0;

  var subVis = parseFloat((document.getElementById('nuevoTotalVenta')?.value || "0").toString().replace(',', '.')) || 0;
  if (sub === 0 && subVis > 0) sub = subVis;

  var desc = parseFloat((document.getElementById('nuevoDescuentoVenta')?.value || "0").replace(',', '.')) || 0;
  if (desc < 0) desc = 0;
  if (desc > sub) desc = sub;

  var total = sub - desc;

  var abono = parseFloat((document.getElementById('Abono')?.value || "0").replace(',', '.')) || 0;
  if (abono < 0) abono = 0;
  if (abono > total) abono = total;

  var saldo = total - abono;

  document.getElementById('nuevoTotalVenta').value   = sub.toFixed(2);
  document.getElementById('nuevoTotalFinal').value   = total.toFixed(2);
  document.getElementById('totalVentaFinal').value   = total.toFixed(2);
  document.getElementById('abonoNeto').value         = abono.toFixed(2);
  document.getElementById('SaldoPendiente').value    = saldo.toFixed(2);

  // campos ocultos esperados por el backend
  var impuesto = 0;
  document.getElementById('nuevoImpuestoVenta').value  = impuesto.toFixed(2);
  document.getElementById('nuevoPrecioImpuesto').value = (sub * (impuesto/100)).toFixed(2);
  document.getElementById('nuevoPrecioNeto').value     = sub.toFixed(2);

  var forma = (document.getElementById('nuevoFormaPago')?.value || '').toUpperCase();
  document.getElementById('nuevoMetodoPago').value = 'Efectivo';
  document.getElementById('listaMetodoPago').value = JSON.stringify({
    forma: forma, abono: Number(isNaN(abono) ? 0 : abono), total: Number(total)
  });
}

// util para escapar texto al inyectar HTML
function esc(s){
  return String(s).replace(/[&<>"']/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]); });
}

/* =========================
   LÍNEAS DE VENTA (ÚNICO)
   ========================= */
(function(){
  var btnAdd = document.getElementById('btnAgregarProductoBusqueda');
  var selProd = document.getElementById('buscarProducto');
  var tbody = document.querySelector('#tablaLineas tbody');
  var form = document.querySelector('form.formularioVenta');

  function recalcTotals(){
    var total = 0;
    (tbody.querySelectorAll('tr') || []).forEach(function(tr){
      var sub = parseFloat((tr.querySelector('.js-sub')?.textContent || '0').replace(',', '.')) || 0;
      total += sub;
    });
    document.getElementById('totalVenta').value = total.toFixed(2);
    document.getElementById('nuevoTotalVenta').value = total.toFixed(2);
    SumarDatosFinancieros();
  }

  function addLineFromOption(opt){
    var id     = opt.value;
    var codigo = opt.getAttribute('data-codigo') || '';
    var desc   = opt.getAttribute('data-descripcion') || '';
    var price  = parseFloat(opt.getAttribute('data-precio') || '0') || 0;
    var stock  = parseInt(opt.getAttribute('data-stock') || '0') || 0;

    // Si ya existe la línea, incrementa hasta el stock máximo
    var existing = tbody.querySelector('tr[data-id="'+id+'"]');
    if (existing){
      var qtyInput = existing.querySelector('.js-qty');
      var current  = parseInt(qtyInput.value || '1') || 1;
      var next     = current + 1;
      if (next > stock) { alert('Stock insuficiente.'); return; }
      qtyInput.value = next;
      existing.querySelector('.js-sub').textContent = (price * next).toFixed(2);
      recalcTotals();
      return;
    }

    // Nueva fila con cantidad 1 por defecto
    var tr = document.createElement('tr');
    tr.setAttribute('data-id', id);
    tr.setAttribute('data-codigo', codigo);
    tr.setAttribute('data-price', price);
    tr.setAttribute('data-stock', stock);

    tr.innerHTML = ''
      + '<td class="text-monospace">'+esc(codigo)+'</td>'
      + '<td class="js-desc">'+esc(desc)+'</td>'
      + '<td>'+price.toFixed(2)+'</td>'
      + '<td><input type="number" class="form-control input-sm js-qty" value="1" min="1" max="'+stock+'"></td>'
      + '<td class="js-sub">'+price.toFixed(2)+'</td>'
      + '<td><button type="button" class="btn btn-xs btn-danger js-del"><i class="fa fa-trash"></i></button></td>';

    tbody.appendChild(tr);
    recalcTotals();
  }

  if (btnAdd && selProd){
    // única vinculación del botón
    btnAdd.addEventListener('click', function(){
      var opt = selProd.options[selProd.selectedIndex];
      if (!opt || !opt.value) { alert('Selecciona un producto.'); return; }
      addLineFromOption(opt);
    });

    // permitir Enter en el select para añadir
    selProd.addEventListener('keydown', function(e){
      if (e.key === 'Enter') {
        e.preventDefault();
        btnAdd.click();
      }
    });
  }

  // cambios de cantidad
  tbody.addEventListener('input', function(e){
    var el = e.target;
    if (el.classList.contains('js-qty')){
      var tr    = el.closest('tr');
      var price = parseFloat(tr.getAttribute('data-price') || '0') || 0;
      var stock = parseInt(tr.getAttribute('data-stock') || '0') || 0;
      var qty   = parseInt(el.value || '1') || 1;
      if (qty < 1) qty = 1;
      if (qty > stock) qty = stock;
      el.value = qty;
      tr.querySelector('.js-sub').textContent = (price * qty).toFixed(2);
      recalcTotals();
    }
  });

  // eliminar línea
  tbody.addEventListener('click', function(e){
    var btn = e.target.closest('.js-del');
    if (!btn) return;
    var tr = btn.closest('tr');
    tr.parentNode.removeChild(tr);
    recalcTotals();
  });

  // serializar antes de enviar + validaciones
  function serializeLineas(){
    var rows = tbody.querySelectorAll('tr');
    var payload = [];
    rows.forEach(function(tr){
      payload.push({
        id: tr.dataset.id,
        codigo: tr.dataset.codigo,
        descripcion: (tr.querySelector('.js-desc')?.textContent || '').trim(),
        cantidad: Number(tr.querySelector('.js-qty')?.value || 0),
        stock: Number(tr.dataset.stock || 0),
        precio: Number(tr.dataset.price || 0),
        total: Number((tr.querySelector('.js-sub')?.textContent || '0').replace(',', '.')) || 0
      });
    });
    var hidden = document.getElementById('listaProductos');
    if (hidden) hidden.value = JSON.stringify(payload);
    return payload;
  }

  if (form){
    form.addEventListener('submit', function(e){
      var productos = serializeLineas();
      SumarDatosFinancieros();

      var selCliente = document.getElementById('seleccionarCliente');
      if (!selCliente || !selCliente.value) {
        e.preventDefault();
        alert('Selecciona un cliente.');
        return;
      }
      if (!productos || !productos.length) {
        e.preventDefault();
        alert('Agrega al menos un producto.');
        return;
      }
      var total = parseFloat((document.getElementById('totalVentaFinal')?.value || "0").replace(',', '.')) || 0;
      if (total <= 0) {
        e.preventDefault();
        alert('El total debe ser mayor a 0.');
        return;
      }
      // si pasa validación, deja enviar
    });
  }
})();
</script>


<!-- ========================= -->
<!--  SweetAlert2 + Triggers   -->
<!-- ========================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
/* 
  Flags que deberían setear los controladores al terminar con éxito:
  $_SESSION['venta_ok']     = 'ok';
  $_SESSION['cliente_ok']   = 'ok';
  (y opcionalmente mensajes de error)
  $_SESSION['venta_error']  = '...';
  $_SESSION['cliente_error']= '...';

  También soportamos ?venta=ok y ?cliente=ok como respaldo.
*/
$ventaOkBySession    = !empty($_SESSION['venta_ok']) && $_SESSION['venta_ok'] === 'ok';
$clienteOkBySession  = !empty($_SESSION['cliente_ok']) && $_SESSION['cliente_ok'] === 'ok';
$ventaOkByQuery      = (isset($_GET['venta'])   && $_GET['venta']   === 'ok');
$clienteOkByQuery    = (isset($_GET['cliente']) && $_GET['cliente'] === 'ok');

$ventaErrorMsg       = !empty($_SESSION['venta_error'])   ? $_SESSION['venta_error']   : '';
$clienteErrorMsg     = !empty($_SESSION['cliente_error']) ? $_SESSION['cliente_error'] : '';
?>
<script>
(function(){
  function go(route){
    if(route){ window.location = route; }
    else { window.location.reload(); }
  }

  // Venta OK
  <?php if ($ventaOkBySession || $ventaOkByQuery): ?>
  Swal.fire({
    icon: 'success',
    title: '¡Venta registrada!',
    text: 'La venta se realizó correctamente.',
    confirmButtonText: 'Aceptar'
  }).then(() => {
    go('ventas'); // ir al listado
  });
  <?php endif; ?>

  // Cliente OK
  <?php if ($clienteOkBySession || $clienteOkByQuery): ?>
  Swal.fire({
    icon: 'success',
    title: '¡Cliente creado!',
    text: 'El cliente se guardó correctamente.',
    confirmButtonText: 'Aceptar'
  }).then(() => {
    go(); // recarga para que aparezca en el select
  });
  <?php endif; ?>

  // Errores
  <?php if (!empty($ventaErrorMsg)): ?>
  Swal.fire({
    icon: 'error',
    title: 'Error al registrar venta',
    text: <?php echo json_encode($ventaErrorMsg); ?>,
    confirmButtonText: 'Entendido'
  });
  <?php endif; ?>

  <?php if (!empty($clienteErrorMsg)): ?>
  Swal.fire({
    icon: 'error',
    title: 'Error al crear cliente',
    text: <?php echo json_encode($clienteErrorMsg); ?>,
    confirmButtonText: 'Entendido'
  });
  <?php endif; ?>
})();

<script>
// helper para poner Mayúscula Inicial
function properCase(s){ return (s||'').toString()
  .toLowerCase().replace(/(^|\s)\p{L}/gu,m=>m.toUpperCase()); }
// helper que intenta varias llaves (por si cambian nombres en BD)
function pick(row, keys, def=''){ for (var k of keys){ if (row && row[k]!=null && row[k]!== '') return row[k]; } return def; }
// limpia teléfono a dígitos y +
function cleanPhone(s){ s = String(s||''); // deja + y dígitos
  return s.replace(/[^\d+]/g,''); }
// muestra valor en input (si existe)
function setVal(id, val){ var el = document.getElementById(id); if(el){ el.value = val; } }

$(function(){

  // Quita máscara automática si algún plugin la aplica globalmente
  $('#modalVerhistoria').on('shown.bs.modal', function(){
    var $t = $('#nuevotelefono');
    if ($t.inputmask) $t.inputmask('remove');
  });

  // Al elegir una historia
  $('#traer_historia').on('changed.bs.select', function(){
    var id = $(this).val(); if (!id) return;

    $.ajax({
      url: 'ajax/historias.ajax.php',
      method: 'POST',
      data: { idhistoria: id },
      dataType: 'json'
    }).done(function(row){
      if(!row || row.ok === false){
        toastr && toastr.error ? toastr.error('No se pudo traer la historia') : alert('No se pudo traer la historia');
        return;
      }

      // ====== DATOS BÁSICOS ======
      setVal('nuevoNombre',    properCase(pick(row, ['primernombre','nombre','primer_nombre'])));
      setVal('nuevoapellido',  properCase(pick(row, ['primerapellido','apellido','primer_apellido'])));
      setVal('nuevotelefono',  cleanPhone(pick(row, ['telefono','celular','telefono1','telefono_contacto'])));
      setVal('nuevadireccion', pick(row, ['direccion','direcciondomicilio','dir','domicilio']));

      // fecha (formato visible)
      var f = pick(row, ['fecha','created_at','updated_at','fechahistoria']);
      if (f) {
        f = String(f).replace('T',' ');
        setVal('nuevafecha', f.length>16 ? f.substr(0,16) : f);
      } else {
        setVal('nuevafecha','');
      }

      // ====== REFRACCIÓN LEJOS ======
      // OJO DERECHO (OD) lejos
      setVal('nuevoesferaodlj',   pick(row, ['esferaodlj','od_esfera_lj','esfera_od_lejos','od_esfera_lejos']));
      setVal('nuevocilindroodlj', pick(row, ['cilindroodlj','od_cilindro_lj','cilindro_od_lejos','od_cilindro_lejos']));
      setVal('nuevoejeodlj',      pick(row, ['ejeodlj','od_eje_lj','eje_od_lejos','od_eje_lejos']));

      // OJO IZQUIERDO (OI) lejos
      setVal('nuevoesferaoilj',   pick(row, ['esferaoilj','oi_esfera_lj','esfera_oi_lejos','oi_esfera_lejos']));
      setVal('nuevocilindrooilj', pick(row, ['cilindrooilj','oi_cilindro_lj','cilindro_oi_lejos','oi_cilindro_lejos']));
      setVal('nuevoejeoilj',      pick(row, ['ejeoilj','oi_eje_lj','eje_oi_lejos','oi_eje_lejos']));

      // ====== REFRACCIÓN CERCA (si tienes esos campos) ======
      setVal('nuevoesferaodcc',   pick(row, ['esferaodcc','od_esfera_cc','esfera_od_cerca','od_esfera_cerca']));
      setVal('nuevocilindroodcc', pick(row, ['cilindroodcc','od_cilindro_cc','cilindro_od_cerca','od_cilindro_cerca']));
      setVal('nuevoejeodcc',      pick(row, ['ejeodcc','od_eje_cc','eje_od_cerca','od_eje_cerca']));

      setVal('nuevoesferaoicc',   pick(row, ['esferaoicc','oi_esfera_cc','esfera_oi_cerca','oi_esfera_cerca']));
      setVal('nuevocilindrooicc', pick(row, ['cilindrooicc','oi_cilindro_cc','cilindro_oi_cerca','oi_cilindro_cerca']));
      setVal('nuevoejeoicc',      pick(row, ['ejeoicc','oi_eje_cc','eje_oi_cerca','oi_eje_cerca']));

      // Otros campos
      setVal('nuevoanamnesis',    pick(row, ['anamnesis','anamnesis_texto','motivo']));
      setVal('nuevoantecedentes', pick(row, ['antecedentes','antecedentes_texto']));
      setVal('nuevaADD',          pick(row, ['add','adicion','adicion_total']));
      setVal('nuevaDP',           pick(row, ['dp','distanciapupilar','distancia_pupilar']));
      setVal('nuevaPatologia',    pick(row, ['patologias','diagnostico','dx']));
      setVal('nuevaobservaciones',pick(row, ['observaciones','observacion','obs']));

    }).fail(function(){
      alert('Error al consultar la historia.');
    });
  });
});
</script>

</script>
<?php
// limpiar flags para que no se repitan
unset($_SESSION['venta_ok'], $_SESSION['cliente_ok'], $_SESSION['venta_error'], $_SESSION['cliente_error']);
?>
