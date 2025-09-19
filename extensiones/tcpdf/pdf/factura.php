<?php

include "../fpdf/fpdf.php";

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/configuraciones.controlador.php";
require_once "../../../modelos/configuraciones.modelo.php";




class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["impuesto"],2);
$total = number_format($respuestaVenta["total"],2);
$abono = number_format($respuestaVenta["abono"],2);
$descuento = number_format($respuestaVenta["descuento"],2);
$totalfinal = number_format($respuestaVenta["totalfinal"],2);
$pendiente = number_format($respuestaVenta["pendiente"],2);

          $item4 = null;
          $valor4 = null;
          $nombret = null;
          $mercantil = null;
          $direcciont = null;
          $telefonot = null;
          $emailt = null;
          $fotot = null;
          $moneda = null;


     $configuraciones = Controladorconfiguraciones::ctrMostrarconfiguraciones($item4, $valor4);

          foreach ($configuraciones as $key => $value2) {

         $nombret = $value2["nombre"];
         $mercantil = $value2["configuracion"];
         $direcciont = $value2["direccion"];
         $direcciont2 = $value2["direccion2"];
         $telefonot = $value2["telefono"];
         $emailt = $value2["email"];
         $moneda = $value2["moneda"];
         
          

           if($value2["foto"] != ""){

                      $fotot = $value2["foto"];

                  }else{

                     $fotot = 'vistas/img/configuraciones/default/anonymous.png';

                  }

          }


//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);



//REQUERIMOS LA CLASE TCPDF



//---------------------------------------------------------
$pdf = new FPDF($orientation='P',$unit='mm', array(45,450));
$pdf->AddPage();

$pdf->SetFont('Arial','',40);    //Letra Arial, negrita (Bold), tam. 20
$textypos = 5;
$pdf->setY(5);
$pdf->setX(2);
$pdf->Cell(5,$textypos, $valorVenta);

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos);
$textypos+=6;

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam.
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,'-------------------------------------------------------------------');

$pdf->SetFont('Arial','B',15);
$pdf->setX(2);
$pdf->Cell(5);
//$pdf->Image('http://www.optalca.com/vistas/img/plantilla/logo' , 27, 18, 15, 15,'PNG', '');

$pdf->SetFont('Arial','B',8.4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos, $nombret);

$textypos+=6;
$pdf->setY(2);
$pdf->Cell(5,$textypos);
$textypos+=6;

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,("Direc: ").$direcciont);

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos, ("NIT: ").$mercantil);

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos, ("Tel: ").$telefonot);

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,("Email: ").$emailt);

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"***********************************************************************");

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 20
$textypos+=6;
$pdf->setX(13);
$pdf->Cell(5,$textypos,"DATOS DE CLIENTE");

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"Cliente: ".mb_strtoupper($respuestaCliente['nombre'])." ".mb_strtoupper($respuestaCliente['apellido']));

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"CI: ".$respuestaCliente['documento']);

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,utf8_decode("Telefóno: ").$respuestaCliente['telefono']);

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"Vendedor: ".$respuestaVendedor['usuario']);

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"***********************************************************************");

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 20
$textypos+=6;
$pdf->setX(13);
$pdf->Cell(5,$textypos,"ORDEN DE TRABAJO");

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,utf8_decode("Orden: N° ").$valorVenta);

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,utf8_decode("Ingreso: ").$respuestaVenta['fecha']);

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,utf8_decode("Retiro: ").$respuestaVenta['fechaentrega']);

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,utf8_decode("Estado orden: ").$respuestaVenta['estado']);

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,utf8_decode("Determinación: ").$respuestaVenta['estado_bulto']);
$pdf->Ln(75);

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 
$textypos=3;
$pdf->setX(2);
$pdf->MultiCell(41,$textypos,utf8_decode("Observacion: ".$respuestaVenta['observaciones']),1,1,false);

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,'------------------------------------------------------------------------------------');



foreach ($productos as $key => $item) {

$valorUnitario = number_format($item["precio"], 2);

$precioTotal = number_format($item["total"], 2);

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,$item['cantidad']. " X ".$moneda."  ".$valorUnitario);

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,mb_strtoupper($item['descripcion']));

$textypos+=6;
$pdf->setX(31);
$pdf->Cell(5,$textypos,$moneda." ".$precioTotal);

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,'------------------------------------------------------------------------------------');


}


$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"NETO:                                                               ".$moneda." ".$neto );

$textypos+=6;
$pdf->setX(2); 
$pdf->Cell(5,$textypos,"IVA:                                                                              ". $impuesto );

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"SUBTOTAL:                                                       ".$moneda." ". $total );

$textypos+=6;
$pdf->setX(2); 
$pdf->Cell(5,$textypos,"DESCUENTO:                                                     ".$moneda." ". $descuento );

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"TOTAL:                                         ".$moneda." ". $totalfinal );

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2); 
$pdf->Cell(5,$textypos,"ABONO:                                                               ".$moneda." ". $abono );


$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,"PENDIENTE:                                                       ".$moneda." ". $pendiente );


$pdf->SetFont('Arial','B',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;  
$pdf->setX(2);
$pdf->Cell(5,$textypos,"METODO PAGO: " .$respuestaVenta['metodo_pago']."");

$pdf->setX(1);
$pdf->Cell(5,$textypos);
$textypos+=3;

$pdf->SetFont('Arial','B',4.7);    //Letra Arial, negrita (Bold), tam. 20
$pdf->setX(1);
$pdf->Cell(5,$textypos+6,'POLITICA Y PRIVACIDAD DE NUESTRA EMPRESA');

$pdf->setX(1);
$pdf->Cell(5,$textypos);
$textypos+=2;

$textypos+=6;
$pdf->setX(1);
$pdf->Cell(5,$textypos,'--------------------------------------------------------------------------');

$pdf->SetFont('Arial','B',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;  
$pdf->setX(1);
$pdf->Cell(5,$textypos,utf8_decode("CONDICIONES DE SERVICIO"));

$pdf->SetFont('Arial','B',3);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(1);
$pdf->Cell(5,$textypos,'-------------------------------------------------------------------------------------------------------------------');


$pdf->SetFont('Arial','B',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;  
$pdf->setX(1);
$pdf->Cell(5,$textypos,"El cliente declara conocer y aceptar las siguientes clausulas:");
$pdf->Ln(70);

$pdf->SetFont('Arial','',4);    //Letra Arial, negrita (Bold), tam. 
$textypos=3;  
$pdf->setX(1);
$pdf->MultiCell(43,$textypos,utf8_decode("1.- La garantía max. de sus anteojos tendrá 3 meses de vigencia para hacer uso de ella con ésta orden de trabajo.
2.- El uso de su garantía será siempre y cuando sus lentes tengan fallas técnicas y no por su mal uso.
3.- Su garantía NO CUBRE: Armazón o cristal en mal estado.
4.- El tiempo máximo que tiene para retirar sus anteojos será de 60 días a contar de que firme éste documento.
5.- En el caso de que no retire sus lentes dentro de los 60 días, perderá el abono y deberá volver a realizar el pago."),0,1,false);

$pdf->setX(1);
$pdf->Cell(5,$textypos);
$textypos+=6;

$pdf->SetFont('Arial','B',4);    //Letra Arial, negrita (Bold), tam. 
$textypos+=6;
$pdf->setX(1);
$pdf->Cell(5,$textypos,'FIRMA: _______________________________________');

$pdf->setX(1);
$pdf->Cell(5,$textypos);
$textypos+=6;

$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 20
$pdf->setX(9);
$pdf->Cell(5,$textypos+6,'GRACIAS POR PREFERIRNOS');

$textypos+=6;
$pdf->setX(1);
$pdf->Cell(5,$textypos);
$textypos+=2;

$pdf->SetFont('Arial','B',4);
$textypos+=6;
$pdf->setX(1);
$pdf->Cell(5,$textypos,'---------------------------------------------------------------------------------------');

$pdf->SetFont('Arial','B',3.8);
$textypos+=6;
$pdf->setX(1);
$pdf->Cell(5,$textypos,"* Automatizacion y Procesos al --> +59175839845 *" );

$textypos+=6;
$pdf->setX(1);
$pdf->Cell(5,$textypos,'-------------------------------------------------------------------------------------------');

$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos);
$textypos+=6;

//$pdf->output();

$pdf->Output('factura.pdf','I');

// ---------------------------------------------------------


}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura();

?>