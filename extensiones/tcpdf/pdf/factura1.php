<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/categorias.controlador.php";
require_once "../../../modelos/categorias.modelo.php";

require_once "../../../controladores/configuraciones.controlador.php";
require_once "../../../modelos/configuraciones.modelo.php";


class imprimirFactura1{

public $codigo;

public function traerImpresionFactura1(){

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
$observaciones = $respuestaVenta["observaciones"];
$pendiente = number_format($respuestaVenta["pendiente"],2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

$item4 = null;
          $valor4 = null;
          $nombret = null;
          $mercantil = null;
          $direcciont = null;
          $direcciont2 = null;
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




//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------


$bloque8 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
				
		<td style="background-color:#B5B2B2; width:540px; text-align:center"><b>ORDEN DE TRABAJO N° $valorVenta </b></td>  

		</tr>

		<tr>
		
		<td style="background-color: white; width:500px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');

// ---------------------------------------------------------



$bloque1 = <<<EOF

  <table>
          
          <tr>
			   
			   <td style="background-color: #B5B2B2;  width:100px">
   
			   <img style= "padding:5px" src="../../../$fotot" width="100px" height="60">   
   
			   </td>
   
			   <td style="border: 1px solid white; background-color: #5dc19c; width:270px; text-align:right">
			   
			   <div style="font-size:9px; text-align:left;"> 

			   <b>CENTRO OFTALMOLÓGICO:</b> $nombret
			   <br>
			   <b>NIT:</b> $mercantil
			   <br>
			   <b>DIRECCIÓN 1:</b> $direcciont
			   <br>
			   <b>DIRECCIÓN 2:</b> $direcciont2
			   <br> 
			   <b>TEL:</b> $telefonot
			   <br>
			   <b>CORREO:</b>$emailt
			   <br>

		       </div>
   
			   </td>

               <td style="background-color:white; width:120px; text-align:right; color:red"> </td>
             

          </tr>

     </table>
EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$apellidocliente =null;
$nombrecliente = null;

$nombrecliente = mb_strtoupper($respuestaCliente["nombre"]);
$apellidocliente = mb_strtoupper($respuestaCliente["apellido"]);
$direccioncliente = mb_strtoupper($respuestaCliente["direccion"]);

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
				
		<td style="background-color:#B5B2B2; width:540px; text-align:center"><b>DATOS DEL CLIENTE</b></td>  

		</tr>
	
		<tr>
		
			<td style="border: 1px solid white; background-color: #5dc19c;  width:270px">

				<b>Cliente:</b> $nombrecliente $apellidocliente

			</td>

			<td style="border: 1px solid white; background-color: #5dc19c; width:270px; text-align:right">
			
				<b>Fecha / Hora:</b> $respuestaVenta[fecha]

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid white; background-color: #5dc19c; width:270px">

				<b>Rut:</b> $respuestaCliente[documento]

			</td>

			<td style="border: 1px solid white; background-color: #5dc19c; width:270px; text-align:right">
			
				<b>N° Compra:</b> $valorVenta

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid white; background-color: #5dc19c; width:270px">

				<b>Dirección:</b> $direccioncliente

			</td>

			<td style="border: 1px solid white; background-color: #5dc19c; width:270px; text-align:right">
			
				<b>Vendedor:</b> $respuestaVendedor[usuario]

			</td>

		</tr>
		<tr>
		
			<td style="border: 1px solid white; background-color: #5dc19c; width:270px">

				<b>Telefóno:</b> $respuestaCliente[telefono]

			</td>

			<td style="border: 1px solid white; background-color: #5dc19c; width:270px; text-align:right">
			
				

			</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color: white; width:500px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:#B5B2B2; width:270px; text-align:center"><b>Producto</b></td>
		<td style="border: 1px solid #666; background-color:#B5B2B2; width:65px; text-align:center"><b>PCS</b></td>
		<td style="border: 1px solid #666; background-color:#B5B2B2; width:100px; text-align:center"><b>Precio c/u</b></td>
		<td style="border: 1px solid #666; background-color:#B5B2B2; width:100px; text-align:center"><b>Cobro</b></td>
		

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {



$valorUnitario = number_format($item["precio"], 2);

$SubTotal = number_format($item["total"], 2);

$auxproducto = mb_strtoupper($item["descripcion"]);

$itemProducto = "descripcion";

$valorProducto = $item["descripcion"];


$orden = null;

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto, $orden);




$bloque4 = <<<EOF

	<table style="font-size: 8px; padding:5px 8px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:270px; text-align:center">
				$auxproducto 
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:65px; text-align:center">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$moneda $valorUnitario
				
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$moneda $SubTotal 
				
			</td>	


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 0px solid white; background-color:white; width:335px; text-align:rigth">MÉTODO DE PAGO: $respuestaVenta[metodo_pago]</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Neto:</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">$moneda $neto</td>
		

		</tr>
		<tr>
		
		<td style="border: 0px solid white; background-color:white; width:335px; text-align:rigth">ABONO: $abono</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">IVA:</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">$moneda $impuesto</td>
		

		</tr>

		<tr>
		
		<td style="border: 0px solid white; background-color:white; width:335px; text-align:rigth"> PENDIENTE: $pendiente</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>SubTotal:</b></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>$moneda $total</b></td>
		

		</tr>

		<tr>
		
		<td style="border: 0px solid white; background-color:white; width:265px; text-align:center"></td>
		<td style="border: 0px solid white; background-color:white; width:70px; text-align:center"></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>Descuento:</b></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>$moneda $descuento</b></td>
		

		</tr>

		<tr>
		
		<td style="border: 0px solid white; background-color:white; width:265px; text-align:center"></td>
		<td style="border: 0px solid white; background-color:white; width:70px; text-align:center"></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>Total:</b></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>$moneda $totalfinal</b></td>
		

		</tr>





	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


// ---------------------------------------------------------



$bloque6 = <<<EOF



         <table style="font-size:12px; padding:5px 10px;">

     <tr>
          
               <td style="  width:500px">

          
               </td>

         

          </tr>

         

        

     </table>



EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');


// ---------------------------------------------------------



$bloque7 = <<<EOF



<br><br>
     <table style="font-size:10px; padding:5px 5px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:#B5B2B2; width:525px; text-align:center"><b>OBSERVACIÓN DE LA VENTA</b></td>  



          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:525px; text-align:left">
          
          <b>OBS. VENTA:</b> $observaciones<br>
     
          
          
          </td>

          </tr>


     </table>


EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');



// ---------------------------------------------------------



$bloque6 = <<<EOF



         <table style="font-size:12px; padding:5px 10px;">

     <tr>
          
               <td style="  width:500px">

          
               </td>

         

          </tr>

         

        

     </table>



EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');


// ---------------------------------------------------------


$bloque9 = <<<EOF



<br><br>
     <table style="font-size:5px; padding:5px 5px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:#B5B2B2; width:524px; text-align:center"><b>POLÍTICA Y PRIVACIDAD DE NUESTRA EMPRESA</b>
		 
		  </td> 

          </tr>

		  <tr>
          
          <td style="border-left: 1px solid #666; border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:312px; text-align:left">

		  1.- La garantía max. de sus anteojos tendrá 3 meses de vigencia para hacer uso de ella con ésta orden de trabajo. <br>
		  2.- El uso de su garantía será siempre y cuando sus lentes tengan fallas técnicas y no por su mal uso.<br>
		  3.- Su garantía NO CUBRE: Armazón o cristal en mal estado.<br>
		  4.- El tiempo máximo que tiene para retirar sus anteojos será de 60 días a contar de que firme éste documento.<br>
		  5.- En el caso de que no retire sus lentes dentro de los 60 días, perderá el abono y deberá volver a realizar el pago. <br> 
           
		  </td>

		  <td style="border-left: 1px solid #666; border-right: 1px solid #666; border-bottom: 1px solid #666; background-color:white; width:212px; text-align:left">

		  FIRME AQUÍ: <br>
		  </td>
		  
          </tr>


     </table>


EOF;

$pdf->writeHTML($bloque9, false, false, false, false, '');



// ---------------------------------------------------------



//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
$pdf->Output('factura1.pdf');

}

}

$factura = new imprimirFactura1();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionFactura1();

?>