<?php
require_once "../controladores/historias.controlador.php";
require_once "../modelos/historias.modelo.php";

class AjaxHistorias {

  /* ============================
   *  A) EDITAR (traer por id)
   * ============================ */
  public $idhistoria;

  public function ajaxEditarHistoria() {
    $item  = "id";
    $valor = $this->idhistoria;
    $respuesta = Controladorhistorias::ctrMostrarhistorias($item, $valor);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($respuesta ?: []);
  }

  /* ===============================================
   *  B) ÚLTIMA HISTORIA POR CLIENTE (para la venta)
   *    POST: op=ultima_por_cliente, cliente_id=ID
   * =============================================== */
  public $cliente_id;

  public function ajaxUltimaPorCliente() {
    // En tu Modelo: ctrMostrarhistorias(null,null) devuelve todas.
    // Aquí filtramos por cliente en PHP y tomamos la última (id más alta).
    $todo = Controladorhistorias::ctrMostrarhistorias(null, null);
    $last = null;

    if (is_array($todo)) {
      foreach ($todo as $row) {
        // Campo que relaciona con cliente: suele ser documentoid o id_cliente.
        // Si tu historia guarda el ID de cliente como 'id_cliente', cámbialo aquí.
        // En tus tablas estás guardando CI (documentoid). Usaremos ambos caminos:

        $coincide = false;
        if (isset($row['id_cliente']) && (string)$row['id_cliente'] === (string)$this->cliente_id) {
          $coincide = true;
        } elseif (isset($row['documentoid']) && isset($_POST['cliente_ci'])) {
          $coincide = ((string)$row['documentoid'] === (string)$_POST['cliente_ci']);
        }

        if ($coincide) {
          if ($last === null || (int)$row['id'] > (int)$last['id']) {
            $last = $row;
          }
        }
      }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($last ?: []);
  }
}

/* ------------ Ruteo sencillo por POST ------------ */
if (isset($_POST['op']) && $_POST['op'] === 'ultima_por_cliente') {
  $ajax = new AjaxHistorias();
  $ajax->cliente_id = $_POST['cliente_id'] ?? null;
  $ajax->ajaxUltimaPorCliente();
  exit;
}

/* Editar por id */
if (isset($_POST['idhistoria'])) {
  $ajax = new AjaxHistorias();
  $ajax->idhistoria = $_POST['idhistoria'];
  $ajax->ajaxEditarHistoria();
  exit;
}
