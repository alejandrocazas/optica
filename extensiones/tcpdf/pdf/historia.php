<?php
// ===== Dependencias de tu MVC =====
require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/historias.controlador.php";
require_once "../../../modelos/historias.modelo.php";

require_once "../../../controladores/configuraciones.controlador.php";
require_once "../../../modelos/configuraciones.modelo.php";

// ===== Evitar que NOTICES arruinen el PDF =====
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

// ===== Utilidades =====
function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
function toTitle($s){ return mb_convert_case(trim((string)$s), MB_CASE_UPPER, 'UTF-8'); }
function onlyDigits($s){ return preg_replace('/[^\d\-+\.]/', '', (string)$s); }
function ageFrom($ymd){
  if (!$ymd) return '';
  $b = DateTime::createFromFormat('Y-m-d', substr($ymd,0,10));
  if (!$b) return '';
  $t = new DateTime('today');
  return $b->diff($t)->y;
}

// ====== Parámetro ======
$codigo = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
date_default_timezone_set('America/La_Paz');
$hoyStr = date('d/m/Y');

// ====== Configuración del local ======
$nombret = $mercantil = $direcciont = $direcciont2 = $telefonot = $emailt = $fotot = '';
$configs = Controladorconfiguraciones::ctrMostrarconfiguraciones(null, null);
if (is_array($configs) && count($configs)) {
  $c = $configs[0];
  $nombret    = $c["nombre"] ?? '';
  $mercantil  = $c["configuracion"] ?? '';
  $direcciont = $c["direccion"] ?? '';
  $direcciont2= $c["direccion2"] ?? '';
  $telefonot  = $c["telefono"] ?? '';
  $emailt     = strtolower($c["email"] ?? '');
  $fotot      = !empty($c["foto"]) ? $c["foto"] : 'vistas/img/configuraciones/default/anonymous.png';
}

// ====== Buscar historia por id (codigo) ======
$h = null;
$historias = Controladorhistorias::ctrMostrarhistorias(null, null);
if (is_array($historias)) {
  foreach ($historias as $row) {
    if ((string)$row['id'] === (string)$codigo) { $h = $row; break; }
  }
}
if (!$h) { die("No se encontró la historia."); }

// ====== Datos historia / paciente ======
$idHistoria  = $h['id'];
$pacNombre   = toTitle(($h['nombre'] ?? '') . ' ' . ($h['apellido'] ?? ''));
$ci          = e($h['documentoid'] ?? '');

$fnacRaw     = substr((string)($h['edad'] ?? ''), 0, 10);
$fnacPrint   = $fnacRaw ?: '';
$edadYears   = ageFrom($fnacRaw);
$edadPrint   = $edadYears !== '' ? $edadYears.' años' : '';

// Diagnóstico / Observaciones
$diag        = e($h['diagnostico'] ?? '');
$observ      = e($h['observaciones'] ?? '');

// Refracción LEJOS
$esferaODL   = e($h['esferaodlj'] ?? '');
$cilindroODL = e($h['cilindroodlj'] ?? '');
$ejeODL      = e($h['ejeodlj'] ?? '');

$esferaOIL   = e($h['esferaoilj'] ?? '');
$cilindroOIL = e($h['cilindrooilj'] ?? '');
$ejeOIL      = e($h['ejeoilj'] ?? '');

// Refracción CERCA
$esferaODC   = e($h['esferaodcc'] ?? '');
$cilindroODC = e($h['cilindroodcc'] ?? '');
$ejeODC      = e($h['ejeodcc'] ?? '');

$esferaOIC   = e($h['esferaoicc'] ?? '');
$cilindroOIC = e($h['cilindrooicc'] ?? '');
$ejeOIC      = e($h['ejeoicc'] ?? '');

// ADD / DP
$add         = e($h['adicion'] ?? '0');
$dp          = e($h['dp'] ?? '');

// ====== TCPDF ======
require_once('tcpdf_include.php');

$pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(12, 14, 12);
$pdf->SetAutoPageBreak(true, 18);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// ====== Encabezado (logo + datos local + tel/email/fecha) ======
$logoPath = "../../../" . ltrim($fotot, '/');
$logoHtml = '
<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:6px;">
  <tbody>
    <tr>
      <td width="22%" style="vertical-align:top;">
        <table cellspacing="0" cellpadding="6" style="border:1px solid #2f80ed;background:#e8f1ff;">
          <tbody>
            <tr><td align="center"><img src="'.e($logoPath).'" width="105"></td></tr>
          </tbody>
        </table>
      </td>
      <td width="48%" style="vertical-align:top;padding-left:8px;">
        <span style="font-weight:bold;">'.e(toTitle($nombret)).'</span><br>
        <span style="font-size:9px;">NIT: '.e($mercantil).'</span><br>
        <span style="font-size:9px;">'.e($direcciont).'</span><br>
        <span style="font-size:9px;">'.e($direcciont2).'</span>
      </td>
      <td width="30%" style="vertical-align:top;text-align:right;">
        <span style="font-size:9px;">Tel: '.e($telefonot).'</span><br>
        <span style="font-size:9px;">Email: '.e($emailt).'</span><br>
        <span style="font-size:9px;">Fecha: '.e($hoyStr).'</span>
      </td>
    </tr>
  </tbody>
</table>';
$pdf->writeHTML($logoHtml, false, false, true, false, '');

// ====== Título receta ======
$pdf->SetFont('helvetica', 'B', 11);
$pdf->writeHTML('<div style="text-align:center;margin:2px 0 8px 0;">RECETA OFTALMOLÓGICA N° '.e($idHistoria).'</div>', false, false, true, false, '');
$pdf->SetFont('helvetica', '', 10);

// ====== Datos Paciente (sin dirección ni teléfono) ======
$pacHtml =
'<table width="100%" cellspacing="0" cellpadding="6" style="border:1px solid #d1d5db;border-radius:4px;margin-bottom:8px;background:#f8fafc;">
  <tbody>
    <tr>
      <td width="50%">
        <span style="font-size:9px;color:#6b7280">Paciente</span><br>
        <span style="font-weight:bold">'.e($pacNombre).'</span><br>
        <span style="font-size:9px;color:#6b7280">CI/NIT</span><br>
        <span>'.e($ci).'</span>
      </td>
      <td width="50%" style="text-align:right;vertical-align:top;">
        <span style="font-size:9px;color:#6b7280">F. Nacimiento / Edad</span><br>
        <span>'.e($fnacPrint).'   '.e($edadPrint).'</span>
      </td>
    </tr>
  </tbody>
</table>';
$pdf->writeHTML($pacHtml, false, false, true, false, '');

// ====== Refracción: estilos (azules suaves) ======
$tblHeadStyle = 'background:#eaf4ff;border:1px solid #60a5fa;font-weight:bold;text-align:center';
$cellStyle    = 'border:1px solid #cbd5e1;text-align:center';

// ====== Refracción LEJOS y CERCA (dos columnas) ======
$refracHtml =
'<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
  <tbody>
    <tr>
      <td width="49%" style="vertical-align:top;">
        <table width="100%" cellspacing="0" cellpadding="5">
          <tbody>
            <tr>
              <td colspan="4" style="'.$tblHeadStyle.'">REFRACCIÓN LEJOS</td>
            </tr>
            <tr>
              <td style="'.$tblHeadStyle.';width:16%;">Ojo</td>
              <td style="'.$tblHeadStyle.';width:28%;">Esfera</td>
              <td style="'.$tblHeadStyle.';width:28%;">Cilindro</td>
              <td style="'.$tblHeadStyle.';width:28%;">Eje</td>
            </tr>
            <tr>
              <td style="'.$cellStyle.'">OD</td>
              <td style="'.$cellStyle.'">'.e($esferaODL).'</td>
              <td style="'.$cellStyle.'">'.e($cilindroODL).'</td>
              <td style="'.$cellStyle.'">'.e($ejeODL).'</td>
            </tr>
            <tr>
              <td style="'.$cellStyle.'">OI</td>
              <td style="'.$cellStyle.'">'.e($esferaOIL).'</td>
              <td style="'.$cellStyle.'">'.e($cilindroOIL).'</td>
              <td style="'.$cellStyle.'">'.e($ejeOIL).'</td>
            </tr>
            <tr>
              <td style="'.$tblHeadStyle.'">ADD</td>
              <td colspan="3" style="'.$cellStyle.';text-align:left;">'.e($add).'</td>
            </tr>
          </tbody>
        </table>
      </td>
      <td width="2%"></td>
      <td width="49%" style="vertical-align:top;">
        <table width="100%" cellspacing="0" cellpadding="5">
          <tbody>
            <tr>
              <td colspan="4" style="'.$tblHeadStyle.'">REFRACCIÓN CERCA</td>
            </tr>
            <tr>
              <td style="'.$tblHeadStyle.';width:16%;">Ojo</td>
              <td style="'.$tblHeadStyle.';width:28%;">Esfera</td>
              <td style="'.$tblHeadStyle.';width:28%;">Cilindro</td>
              <td style="'.$tblHeadStyle.';width:28%;">Eje</td>
            </tr>
            <tr>
              <td style="'.$cellStyle.'">OD</td>
              <td style="'.$cellStyle.'">'.e($esferaODC).'</td>
              <td style="'.$cellStyle.'">'.e($cilindroODC).'</td>
              <td style="'.$cellStyle.'">'.e($ejeODC).'</td>
            </tr>
            <tr>
              <td style="'.$cellStyle.'">OI</td>
              <td style="'.$cellStyle.'">'.e($esferaOIC).'</td>
              <td style="'.$cellStyle.'">'.e($cilindroOIC).'</td>
              <td style="'.$cellStyle.'">'.e($ejeOIC).'</td>
            </tr>
            <tr>
              <td style="'.$tblHeadStyle.'">DP</td>
              <td colspan="3" style="'.$cellStyle.';text-align:left;">'.e($dp).'</td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>';
$pdf->writeHTML($refracHtml, false, false, true, false, '');

// ====== Diagnóstico & Observaciones ======
$diagObsHtml =
'<table width="100%" cellspacing="0" cellpadding="6" style="border:1px solid #d1d5db;margin-bottom:10px;">
  <tbody>
    <tr>
      <td width="20%" style="background:#f3f4f6;"><b>Diagnóstico</b></td>
      <td width="80%">'.e($diag).'</td>
    </tr>
    <tr>
      <td width="20%" style="background:#f3f4f6;"><b>Observaciones</b></td>
      <td width="80%">'.e($observ).'</td>
    </tr>
  </tbody>
</table>';
$pdf->writeHTML($diagObsHtml, false, false, true, false, '');

// ====== Checklist TARJETAS (Material / Tratamiento / Diseño) ======
$box = '<span style="display:inline-block;width:10px;height:10px;border:1px solid #555;margin-right:6px;"></span>';
$cardHead = 'style="background:#fff3e0;border:1px solid #f59e0b;border-bottom:3px solid #10b981;font-weight:bold;padding:6px 8px"';
$cardBodyTd = 'style="border-left:1px solid #f59e0b;border-right:1px solid #f59e0b;border-bottom:1px solid #f59e0b;padding:8px 10px;line-height:1.9"';

$checkHtml =
'<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
  <tbody>
    <tr>
      <td width="32%">
        <table width="100%" cellspacing="0" cellpadding="0">
          <tbody>
            <tr><td '.$cardHead.'>MATERIAL</td></tr>
            <tr><td '.$cardBodyTd.'>'.
                $box.'Resina<br>'.
                $box.'Alto índice 1.60<br>'.
                $box.'Alto índice 1.67<br>'.
                $box.'Policarbonato'.
            '</td></tr>
          </tbody>
        </table>
      </td>
      <td width="2%"></td>
      <td width="32%">
        <table width="100%" cellspacing="0" cellpadding="0">
          <tbody>
            <tr><td '.$cardHead.'>TRATAMIENTO</td></tr>
            <tr><td '.$cardBodyTd.'>'.
                $box.'Antirreflejo<br>'.
                $box.'Blue-blocker<br>'.
                $box.'Filtro UV<br>'.
                $box.'Fotocromático'.
            '</td></tr>
          </tbody>
        </table>
      </td>
      <td width="2%"></td>
      <td width="32%">
        <table width="100%" cellspacing="0" cellpadding="0">
          <tbody>
            <tr><td '.$cardHead.'>DISEÑO</td></tr>
            <tr><td '.$cardBodyTd.'>'.
                $box.'Monofocal<br>'.
                $box.'Bifocal<br>'.
                $box.'Multifocal tradicional<br>'.
                $box.'Multifocal avanzado'.
            '</td></tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>';
$pdf->writeHTML($checkHtml, false, false, true, false, '');

// ====== Espacio + línea firma ======
$pdf->Ln(8);
$pdf->writeHTML(
  '<div style="text-align:center;margin-top:14px;">
     <span style="display:inline-block;border-top:1px solid #9ca3af;width:55%;"></span><br>
     <span style="font-size:9px;color:#6b7280">Sello y firma profesional</span>
   </div>',
  false, false, true, false, ''
);

// ====== Salida ======
if (ob_get_length()) { ob_end_clean(); }
$pdf->Output('historia.pdf', 'I');
