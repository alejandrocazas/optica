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
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalVerhistoria">
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
      $img  = !empty($p['imagen']) ? $p['imagen'] : 'vistas/img/productos/default/anonymous.png';
      $desc = h($p['descripcion'] ?? '');

      // Nombre de categoría robusto
      $catName = '';
      if (isset($p['categoria']) && $p['categoria'] !== '') {
        $catName = $p['categoria'];
      } elseif (isset($p['id_categoria'])) {
        $catRow = ControladorCategorias::ctrMostrarCategorias("id", $p['id_categoria']);
        $catName = $catRow['categoria'] ?? '';
      }
      $catName = h($catName);

      $cod  = h($p['codigo'] ?? '');
      $pre  = isset($p['precio_venta']) ? number_format((float)$p['precio_venta'], 0, ',', '.') : '0';
      $stk  = (int)($p['stock'] ?? 0);
      $badge = ($stk < 10) ? 'bg-red' : (($stk <= 20) ? 'bg-yellow' : 'bg-green');
?>
  <tr>
    <td><?= $i++; ?></td>
    <td><img src="<?= h($img); ?>" alt="" style="width:38px;height:38px;border-radius:6px"></td>
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
<div id="modalVerhistoria" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#666F88;color:#fff">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong><i class="ion ion-arrow-right-a"></i> BUSCAR RECETA MÉDICA</strong></h4>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <div class="panel"><h3><b>DATOS DEL PACIENTE</b></h3></div>

          <div class="form-group">
            <label>CI/NIT</label>
            <select class="selectpicker" name="traer_historia" id="traer_historia"
                    data-live-search="true" data-width="100%" title="CONSULTAR AQUÍ">
              <?php
                $hist = ControladorHistorias::ctrMostrarHistorias(null, null);
                echo '<option></option>';
                foreach($hist as $hrow){
                  echo '<option value="'.$hrow["id"].'"> CI: '.$hrow["documentoid"].' | N° Atención: '.$hrow["id"].'</option>';
                }
              ?>
            </select>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <label>Primer Nombre</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoNombre">
              <input readonly type="hidden" id="id_historia">
            </div>
            <div class="col-sm-4">
              <label>Primer Apellido</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoapellido">
            </div>
            <div class="col-sm-4">
              <label>Teléfono</label>
              <input readonly type="text" class="form-control input-lg" id="nuevotelefono">
            </div>
          </div>

          <div class="row" style="margin-top:10px">
            <div class="col-sm-4">
              <label>Fecha</label>
              <input readonly type="text" class="form-control input-lg" id="nuevafecha">
            </div>
            <div class="col-sm-8">
              <label>Dirección</label>
              <input readonly type="text" class="form-control input-lg" id="nuevadireccion">
            </div>
          </div>

          <div class="form-group" style="margin-top:10px">
            <label>Anamnesis</label>
            <input readonly type="text" class="form-control input-lg" id="nuevoanamnesis">
          </div>

          <div class="form-group">
            <label>Antecedentes</label>
            <input readonly type="text" class="form-control input-lg" id="nuevoantecedentes">
          </div>

          <!-- Refracciones -->
          <div class="panel"><h3><b>REFRACCIÓN LEJOS</b></h3></div>
          <div class="row">
            <div class="col-sm-4">
              <label>OD Esfera</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoesferaodlj">
            </div>
            <div class="col-sm-4">
              <label>OD Cilindro</label>
              <input readonly type="text" class="form-control input-lg" id="nuevocilindroodlj">
            </div>
            <div class="col-sm-4">
              <label>OD Eje</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoejeodlj">
            </div>
          </div>
          <div class="row" style="margin-top:10px">
            <div class="col-sm-4">
              <label>OI Esfera</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoesferaoilj">
            </div>
            <div class="col-sm-4">
              <label>OI Cilindro</label>
              <input readonly type="text" class="form-control input-lg" id="nuevocilindrooilj">
            </div>
            <div class="col-sm-4">
              <label>OI Eje</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoejeoilj">
            </div>
          </div>

          <div class="panel" style="margin-top:10px"><h3><b>REFRACCIÓN CERCA</b></h3></div>
          <div class="row">
            <div class="col-sm-4">
              <label>OD Esfera</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoesferaodcc">
            </div>
            <div class="col-sm-4">
              <label>OD Cilindro</label>
              <input readonly type="text" class="form-control input-lg" id="nuevocilindroodcc">
            </div>
            <div class="col-sm-4">
              <label>OD Eje</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoejeodcc">
            </div>
          </div>
          <div class="row" style="margin-top:10px">
            <div class="col-sm-4">
              <label>OI Esfera</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoesferaoicc">
            </div>
            <div class="col-sm-4">
              <label>OI Cilindro</label>
              <input readonly type="text" class="form-control input-lg" id="nuevocilindrooicc">
            </div>
            <div class="col-sm-4">
              <label>OI Eje</label>
              <input readonly type="text" class="form-control input-lg" id="nuevoejeoicc">
            </div>
          </div>

          <div class="row" style="margin-top:10px">
            <div class="col-sm-6">
              <label>ADD</label>
              <input readonly type="text" class="form-control input-lg" id="nuevaADD">
            </div>
            <div class="col-sm-6">
              <label>DP</label>
              <input readonly type="text" class="form-control input-lg" id="nuevaDP">
            </div>
          </div>

          <div class="panel" style="margin-top:10px"><h3><b>DIAGNÓSTICO</b></h3></div>
          <div class="form-group">
            <label>Patologías</label>
            <input readonly type="text" class="form-control input-lg" id="nuevaPatologia">
          </div>

          <!-- Observaciones -->
          <div class="panel"><h3><b>OBSERVACIONES</b></h3></div>
          <div class="form-group">
            <input readonly type="text" class="form-control input-lg" id="nuevaobservaciones">
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button class="btn btn-primary btnImprimirhistoria" id="historiaventa"><i class="fa fa-file-text-o"></i></button>
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
// Recalcular importes
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

  document.getElementById('nuevoTotalVenta').value = sub.toFixed(2);
  document.getElementById('nuevoTotalFinal').value = total.toFixed(2);
  document.getElementById('totalVentaFinal').value = total.toFixed(2);
  document.getElementById('abonoNeto').value = abono.toFixed(2);
  document.getElementById('SaldoPendiente').value = saldo.toFixed(2);

  // Ocultos que algunos controladores exigen
  var impuesto = 0;
  document.getElementById('nuevoImpuestoVenta').value   = impuesto.toFixed(2);
  document.getElementById('nuevoPrecioImpuesto').value  = (sub * (impuesto/100)).toFixed(2);
  document.getElementById('nuevoPrecioNeto').value      = sub.toFixed(2);

  var forma = (document.getElementById('nuevoFormaPago')?.value || '').toUpperCase();
  document.getElementById('nuevoMetodoPago').value = 'Efectivo';
  document.getElementById('listaMetodoPago').value = JSON.stringify({
    forma: forma, abono: Number(isNaN(abono) ? 0 : abono), total: Number(total)
  });
}

// ===== util JS para escapar texto en plantillas (evita usar h() PHP en JS)
function esc(s){
  return String(s).replace(/[&<>"']/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]); });
}

// Gestionar líneas
(function(){
  var btnAdd = document.getElementById('btnAgregarProductoBusqueda');
  var selProd = document.getElementById('buscarProducto');
  var tbody = document.querySelector('#tablaLineas tbody');

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
    var id = opt.value;
    var codigo = opt.getAttribute('data-codigo') || '';
    var desc = opt.getAttribute('data-descripcion') || '';
    var price = parseFloat(opt.getAttribute('data-precio') || '0') || 0;
    var stock = parseInt(opt.getAttribute('data-stock') || '0') || 0;

    // Si ya existe la línea, solo incrementa cantidad si hay stock
    var existing = tbody.querySelector('tr[data-id="'+id+'"]');
    if (existing){
      var qtyInput = existing.querySelector('.js-qty');
      var current = parseInt(qtyInput.value || '1') || 1;
      if (current + 1 > stock) { alert('Stock insuficiente.'); return; }
      qtyInput.value = current + 1;
      var sub = (price * (current + 1));
      existing.querySelector('.js-sub').textContent = sub.toFixed(2);
      recalcTotals();
      return;
    }

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
    btnAdd.addEventListener('click', function(){
      var opt = selProd.options[selProd.selectedIndex];
      if (!opt || !opt.value) { alert('Selecciona un producto.'); return; }
      addLineFromOption(opt);
    });
  }

  tbody.addEventListener('input', function(e){
    var el = e.target;
    if (el.classList.contains('js-qty')){
      var tr = el.closest('tr');
      var price = parseFloat(tr.getAttribute('data-price') || '0') || 0;
      var stock = parseInt(tr.getAttribute('data-stock') || '0') || 0;
      var qty = parseInt(el.value || '1') || 1;
      if (qty < 1) qty = 1;
      if (qty > stock) qty = stock;
      el.value = qty;
      tr.querySelector('.js-sub').textContent = (price * qty).toFixed(2);
      recalcTotals();
    }
  });

  tbody.addEventListener('click', function(e){
    var btn = e.target.closest('.js-del');
    if (!btn) return;
    var tr = btn.closest('tr');
    tr.parentNode.removeChild(tr);
    recalcTotals();
  });

  // Serializar y validar antes de enviar
  var form = document.querySelector('form.formularioVenta');
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
      // submit continua
    });
  }
})();

// Implementación alternativa (de respaldo) para añadir/serializar (puedes dejarla)
(function() {
  const $sel = document.getElementById('buscarProducto');
  const $btn = document.getElementById('btnAgregarProductoBusqueda');
  const $wrap = document.querySelector('.nuevoProducto');
  const $totalOculto = document.getElementById('totalVenta');
  const $totalVis = document.getElementById('nuevoTotalVenta');
  const $lista = document.getElementById('listaProductos');

  if (!$sel || !$btn || !$wrap) return;

  function ensureTable() {
    if ($wrap.querySelector('table')) return;
    const table = document.createElement('table');
    table.className = 'table table-condensed';
    table.innerHTML = `
      <thead>
        <tr>
          <th style="width:40%">Producto</th>
          <th style="width:15%">Precio</th>
          <th style="width:15%">Cant.</th>
          <th style="width:20%">Subtotal</th>
          <th style="width:10%"></th>
        </tr>
      </thead>
      <tbody></tbody>`;
    $wrap.appendChild(table);
  }

  function number(n){ return parseFloat((n||'0').toString().replace(',', '.')) || 0; }
  function money(n){ return (Number(n)||0).toFixed(2); }

  function recalc() {
    const rows = $wrap.querySelectorAll('tbody tr');
    let sub = 0;
    rows.forEach(tr => {
      const qty = number(tr.querySelector('.js-qty').value);
      const price = number(tr.dataset.price);
      const st = qty * price;
      tr.querySelector('.js-sub').textContent = money(st);
      sub += st;
    });
    $totalOculto.value = money(sub);
    $totalVis.value = money(sub);
    if (typeof SumarDatosFinancieros === 'function') SumarDatosFinancieros();
    serialize();
  }

  function serialize() {
    const rows = $wrap.querySelectorAll('tbody tr');
    const payload = [];
    rows.forEach(tr => {
      payload.push({
        id: tr.dataset.id,
        codigo: tr.dataset.codigo,
        descripcion: tr.querySelector('.js-desc') ? tr.querySelector('.js-desc').textContent.trim() : '',
        cantidad: Number(tr.querySelector('.js-qty')?.value || 0),
        stock: Number(tr.dataset.stock || 0),
        precio: Number(tr.dataset.price || 0),
        total: Number(tr.querySelector('.js-sub')?.textContent || 0)
      });
    });
    $lista.value = JSON.stringify(payload);
  }

  function addOrInc({id, codigo, desc, price, stock}) {
    ensureTable();
    const tbody = $wrap.querySelector('tbody');
    let row = tbody.querySelector('tr[data-id="'+id+'"]');

    if (row) {
      const qtyInput = row.querySelector('.js-qty');
      let qty = Number(qtyInput.value) + 1;
      if (qty > stock) qty = stock;
      qtyInput.value = qty;
    } else {
      row = document.createElement('tr');
      row.dataset.id = id;
      row.dataset.codigo = codigo;
      row.dataset.price = price;
      row.dataset.stock = stock;
      row.innerHTML = `
        <td class="js-desc text-uppercase">${esc(desc)}</td>
        <td>$ <span class="js-price">${money(price)}</span></td>
        <td>
          <input type="number" class="form-control input-sm js-qty" value="1" min="1" max="${stock}">
          <small class="text-muted">Stock: ${stock}</small>
        </td>
        <td>$ <span class="js-sub">${money(price)}</span></td>
        <td>
          <button type="button" class="btn btn-danger btn-xs js-del"><i class="fa fa-trash"></i></button>
        </td>`;
      tbody.appendChild(row);
    }
    recalc();
  }

  $wrap.addEventListener('input', function(e){
    if (e.target.classList.contains('js-qty')) {
      const tr = e.target.closest('tr');
      const max = Number(tr.dataset.stock);
      let v = Number(e.target.value || 1);
      if (v < 1) v = 1;
      if (v > max) v = max;
      e.target.value = v;
      recalc();
    }
  });
  $wrap.addEventListener('click', function(e){
    if (e.target.closest('.js-del')) {
      const tr = e.target.closest('tr');
      tr.parentNode.removeChild(tr);
      if (!$wrap.querySelector('tbody tr')) $wrap.innerHTML = '';
      recalc();
    }
  });

  $btn.addEventListener('click', function(){
    const opt = $sel.options[$sel.selectedIndex];
    if (!opt || !opt.value) return;

    const id = opt.value;
    const codigo = opt.getAttribute('data-codigo') || '';
    const desc = (opt.getAttribute('data-descripcion') || '').trim();
    const price = number(opt.getAttribute('data-precio'));
    const stock = Number(opt.getAttribute('data-stock')) || 0;

    if (stock <= 0) {
      alert('Sin stock disponible para este producto.');
      return;
    }
    addOrInc({id, codigo, desc, price, stock});
  });

  $sel.addEventListener('keydown', function(e){
    if (e.key === 'Enter') {
      e.preventDefault();
      $btn.click();
    }
  });
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
</script>
<?php
// limpiar flags para que no se repitan
unset($_SESSION['venta_ok'], $_SESSION['cliente_ok'], $_SESSION['venta_error'], $_SESSION['cliente_error']);
?>
