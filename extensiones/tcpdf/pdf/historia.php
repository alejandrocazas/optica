<?php

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

class imprimirhistoria {

public $codigo;

public function traerImpresionhistoria(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemhistoria = "codigo";
$valorhistoria = $this->codigo;


//fecha
date_default_timezone_set('America/Bogota');

$fecha = date('d-m-Y');


$item4 = null;
          $valor4 = null;

          $nombret = null;
          $mercantil = null;
          $direcciont = null;
          $direcciont2 = null;
          $telefonot = null;
          $emailt = null;
          $fotot = null;


     $configuraciones = Controladorconfiguraciones::ctrMostrarconfiguraciones($item4, $valor4);

          foreach ($configuraciones as $key => $value2) {

          $nombret = $value2["nombre"];
          $mercantil = $value2["configuracion"];
          $direcciont = $value2["direccion"];
          $direcciont2 = $value2["direccion2"];
          $telefonot = $value2["telefono"];
          $emailt = $value2["email"];
          
          if($value2["foto"] != ""){

                    $fotot = $value2["foto"];

                  }else{

                    $fotot = 'vistas/img/configuraciones/default/anonymous.png';

                  }

          }





//TRAEMOS LA INFORMACIÓN DE la historia

          $item1 = null;
          $valor1 = null;

          //datos cliente
          $auxid = null;
          $auxnombre1er = null;
          $auxnombre2do = null;
          $auxapellido1er = null;
          $auxapellido2do = null;
          $auxdocumentoid = null;
          $auxdireccion = null;
          $auxtelefono = null;

          //ojo derecho
          $auxesferaod = null;
          $auxcilindrood = null;
          $auxejeod= null;
     
           //ojo izq
          $auxesferaoi = null;
          $auxcilindrooi = null;
          $auxejeoi= null;

          //nota
          $auxnotaoi = null;
          $auxnotaod = null;
          $auxobservaciones = null;
      
   

          $historias = Controladorhistorias::ctrMostrarhistorias($item1, $valor1);

          foreach ($historias as $key => $value2) {

               if ($value2["id"] == $valorhistoria) {


          //datos cliente
          $id = $value2["id"];
          $auxnombre1er = $value2["nombre"];
          $auxapellido1er = $value2["apellido"];
          $auxdocumentoid = $value2["documentoid"];
          $auxdireccion = $value2["direccion"];
          $auxtelefono = $value2["telefono"];
          $auxedad = $value2["edad"];
         
          //atencion

          $anamnesis = $value2["anamnesis"];
          $antecedentes = $value2["antecedentes"];

          //av

          $odsc = $value2["odsc"];
          $odcc = $value2["odcc"];
          $oisc = $value2["oisc"];
          $oicc = $value2["oicc"];
          $cc = $value2["cc"];

          //refraccion lejos

          //ojo der
          $esferalj_OD = $value2["esferaodlj"];
          $cilindrolj_OD = $value2["cilindroodlj"];
          $ejelj_OD = $value2["ejeodlj"];

          //ojo iz
          $esferalj_OI = $value2["esferaoilj"];
          $cilindrolj_OI = $value2["cilindrooilj"];
          $ejelj_OI = $value2["ejeoilj"];

          //refraccion CERCA

          //ojo der
          $esferacc_OD = $value2["esferaodcc"];
          $cilindrocc_OD = $value2["cilindroodcc"];
          $ejecc_OD = $value2["ejeodcc"];

          //ojo iz
          $esferacc_OI = $value2["esferaoicc"];
          $cilindrocc_OI = $value2["cilindrooicc"];
          $ejecc_OI = $value2["ejeoicc"];

          //Distancia Interpupilar

          $add = $value2["adicion"];
          $dp = $value2["dp"];

          //diagnostico

          $patologia = $value2["diagnostico"];

          //tonometria

          $ODmmHg = $value2["tonood"];
          $OImmHg = $value2["tonooi"];
          $tonohora = $value2["tonohora"];

          //observacion

          $auxobservaciones = $value2["observaciones"];
               }     
          
          }



//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setPrintHeader(false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------



$bloque1 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
				
		<td style="background-color:#B5B2B2; width:540px; text-align:center"><b>RECETA DIGITAL OFTALMOLÓGICA N° $id </b></td>  

		</tr>

	</table>


     <table>
          
          <tr>
			   
			   <td style="background-color: #B5B2B2;  width:100px">
   
			   <img style= "padding:5px" src="../../../$fotot" width="100px" height="60">   
   
			   </td>
   
			   <td style="border: 1px solid white; background-color: #5dafc1; width:440px; text-align:right">
			   
			   <div style="font-size:9px; text-align:left;"> 

			   <b>CENTRO OFTALMOLÓGICO:</b> $nombret
			   <br>
			   <b> NIT:</b> $mercantil
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



$bloque2 = <<<EOF



	<table style="font-size:10px; padding:5px 10px;">

		<tr>
				
		<td style="background-color:#B5B2B2; width:540px; text-align:center"><b>DATOS DEL PACIENTE</b></td>  

		</tr>
	
		<tr>
		
			<td style="border: 1px solid white; background-color: #5dafc1; width:270px">

				<b>Cliente:</b> $auxnombre1er $auxapellido1er 

			</td>

               <td style="border: 1px solid white; background-color: #5dafc1; width:270px">

				<b>CI:</b> $auxdocumentoid

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid white; background-color: #5dafc1; width:270px">

				<b>Dirección:</b> $auxdireccion

			</td>

               <td style="border: 1px solid white; background-color: #5dafc1; width:270px">

				<b>Telefóno:</b> $auxtelefono

			</td>

		</tr>

		<tr>

               <td style="border: 1px solid white; background-color: #5dafc1; width:270px">

                    <b>Fecha de Nacimiento:</b> $auxedad

               </td>

               <td style="border: 1px solid white; background-color: #5dafc1; width:270px">

               

               </td>
		

		</tr>

          <tr>
		
		<td style="background-color: white; width:540px"></td>

		</tr>


	</table>









EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');




// ---------------------------------------------------------


$bloque10 = <<<EOF

     <table style="font-size:10px; padding:5px 10px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:200px; text-align:center"><b>AGUDEZA VISUAL</b></td>    

          </tr>


          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:100px; text-align:left">
          
          PL <br><br>
          <b>ODsc:</b> $odsc <br>
          <b>ODcc:</b> $odcc <br>
          <b>OIsc:</b> $oisc <br>
          <b>OIcc:</b> $oicc 

          </td>   
          
          
          <td style="border: 1px solid #666; background-color:white; width:100x; text-align:left">
          
          PC <br><br>
          <b>Cc:</b> $cc 

          </td>   

          </tr>

     </table>
     


EOF;

$pdf->writeHTML($bloque10, false, false, false, false, '');

// ---------------------------------------------------------


$bloque11 = <<<EOF



         <table style="font-size:12px; padding:2px 5px;">

     <tr>
          
               <td style="  width:500px">

          
               </td>

         

          </tr>

         

        

     </table>



EOF;

$pdf->writeHTML($bloque11, false, false, false, false, '');

//-------------------------------------------------------------

$bloque14 = <<<EOF



     <table style="font-size:10px; padding:5px 10px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:100px; text-align:center"><b>ANAMNESIS</b></td>    

          <td style="border: 1px solid #666; background-color:white; width:320px; text-align:left">
          $anamnesis
          
          </td>    

          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:100px; text-align:center"><b>ANTECEDENT.</b></td>    

          <td style="border: 1px solid #666; background-color:white; width:320px; text-align:left">
          $antecedentes
          
          </td>    

          </tr>


</table>


EOF;

$pdf->writeHTML($bloque14, false, false, false, false, '');


// ---------------------------------------------------------

$bloque11 = <<<EOF



         <table style="font-size:12px; padding:5px 10px;">

     <tr>
          
               <td style="  width:500px">

          
               </td>

         

          </tr>

         

        

     </table>



EOF;

$pdf->writeHTML($bloque11, false, false, false, false, '');

//-------------------------------------------------------------



$bloque3 = <<<EOF

     <table style="font-size:10px; padding:5px 10px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:60px; text-align:center"><b>LEJOS</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>ESFERA</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>CILINDRO</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>EJE</b></td>
                
          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:60px; text-align:center"><b>DER.</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$esferalj_OD</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$cilindrolj_OD</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$ejelj_OD</b></td>

          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:60px; text-align:center"><b>IZQ.</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$esferalj_OI</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$cilindrolj_OI</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$ejelj_OI</b></td>     

          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:60px; text-align:center"><b>CERCA</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>ESFERA</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>CILINDRO</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>EJE</b></td>
                
          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:60px; text-align:center"><b>DER.</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$esferacc_OD</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$cilindrocc_OD</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$ejecc_OD</b></td>
              
          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:60px; text-align:center"><b>IZQ.</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$esferacc_OI</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$cilindrocc_OI</b></td>
          <td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>$ejecc_OI</b></td>      

          </tr>


     </table>


EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

$bloque4 = <<<EOF



     <table style="font-size:12px; padding:5px 10px;">

     <tr>
          
               <td style="  width:500px">

          
               </td>

         

          </tr>

         

        

     </table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');


// ---------------------------------------------------------



$bloque7 = <<<EOF

     <table style="font-size:10px; padding:5px 10px;">




     </table>


EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');

// ---------------------------------------------------------


$bloque12 = <<<EOF



     <table style="font-size:10px; padding:5px 10px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:100px; text-align:center"><b>ADD | DP</b></td>    

          <td style="border: 1px solid #666; background-color:white; width:320px; text-align:left">
          <b>ADD:</b> $add | <b>DP:</b> $dp
          
          </td>    

          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:100px; text-align:center"><b>DIAGNÓSTICO</b></td>    

          <td style="border: 1px solid #666; background-color:white; width:320px; text-align:left">
          $patologia
          
          </td>    

          </tr>


</table>


EOF;

$pdf->writeHTML($bloque12, false, false, false, false, '');


// ---------------------------------------------------------


$bloque13 = <<<EOF



     <table style="font-size:10px; padding:5px 10px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:grey; width:100px; text-align:center"><b> TONOMETRÍA</b></td>    

          <td style="border: 1px solid #666; background-color:white; width:320px; text-align:left">
          <b>ODmmHg:</b> $ODmmHg | <b>OImmHg:</b> $OImmHg | <b>Tiempo exacto:</b> $tonohora
          
          </td>    

          </tr>


     </table>


EOF;

$pdf->writeHTML($bloque13, false, false, false, false, '');



// ---------------------------------------------------------



$bloque8 = <<<EOF



<br><br>
     <table style="font-size:10px; padding:5px 10px;">

          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:520px; text-align:center"><b>OBSERVACIÓN PROFESIONAL DIGITALIZADA Y CERTIFICADA</b></td>  



          </tr>

          <tr>
          
          <td style="border: 1px solid #666; background-color:white; width:520px; text-align:left">
          
          <b>OBS. GENERAL:</b> $auxobservaciones<br>
     
          
          
          </td>

          </tr>


     </table>


EOF;

$pdf->writeHTML($bloque8, false, false, false, false, '');


// ---------------------------------------------------------

//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
$pdf->Output('historia.pdf');

}

}

$factura = new imprimirhistoria();
$factura -> codigo = $_GET["codigo"];
$factura -> traerImpresionhistoria();

?>