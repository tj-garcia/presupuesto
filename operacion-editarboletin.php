<?php
error_reporting(0);
session_start();
include('../../security/config.php');
require('../../security/security.php');
if(isset($_SESSION['visitante'])){	
	header("Location: ../../is/salir.php");
}
if(!isset($_SESSION['admin'])){
	header("Location: ../../is/salir.php");
}
else
if(!isset($_SESSION['contribuyente']))
{
	header('Location: buscar-contribuyente.php');
}
else
{
	if($_GET['mapac'] =='' || $_GET['actualizacion'] =='' || $_GET['catatral'] =='' || $_GET['condterreno'] =='' || $_GET['docsup'] =='' || $_GET['inspeccion'] =='' || $_GET['att_1'] =='' || $_GET['alits_id_1'] =='' || $_GET['linnorte'] =='' || $_GET['linsur'] =='' || $_GET['lineste'] =='' || $_GET['linoeste'] =='' || $_GET['direccion'] =='' || $_GET['fiscal'] =='')
	{
		header('Location: ver-boletines.php');
	}
	else{
	conectar_db();
	// SELECT DE LA UNIDAD TRIBUTARIA
	$select_ut = 'select * from uts where anno="'.date('Y').'"';
	$query_ut = mysql_query($select_ut);
	$result_ut = mysql_fetch_array($query_ut);
	$ut = $result_ut['valor'];
		
	//DATOS DEL NUEVO BOLETIN CASTRAL
	$id_sujetopasivo = $_SESSION['contribuyente'];
	$mapac = $_GET['mapac'];
	$actualizacion = $_GET['actualizacion'];
	$catatral = $_GET['catatral'];
	$condterreno = $_GET['condterreno'];
	$condterreno2 = $_GET['condterreno2'];
	$docsup = $_GET['docsup'];
	$inspeccion = $_GET['inspeccion'];
	
	//DATOS DE CALCULO DEL VALOR DEL TERRENO Y CONSTRUCCIONES
	//TERRENO
	//t1
	$att_1 = $_GET['att_1'];
	$alits_id_1 = $_GET['alits_id_1'];
	//t2
	$att_2 = $_GET['att_2'];
	$alits_id_2 = $_GET['alits_id_2'];
	
	//AREA TOTAL DE TODOS LOS TERRENOS / CORRIGE EL BUG CON LAS FACTURAS EN INMUEBLE,
	//ES DECIR VISUALIZA EL VALOR DEL TERRENO EN INMUEBLE
	$att_total = ($att_1 + $att_2);
	
	//INICIO DE DATOS PARA EL VALOR DEL TERRENO corroge bug en hacienda
	$select_catastral_ali_ts1=('select * from catastral_ali_ts where id="'.$alits_id_1.'"');
	$query_catastral_ali_ts1=(mysql_query($select_catastral_ali_ts1));
	$result_catastral_ali_ts1=(mysql_fetch_array($query_catastral_ali_ts1));
	
   if($result_catastral_ali_ts1['sector_uso'] != 'R' && $result_catastral_ali_ts1['sector_uso'] != 'PU')
   {
	   if($condterreno==0)
	   {
		   $vtot_1 = $result_catastral_ali_ts1['vimp']*$ut*$att_1;
	   }
	   else
	   {
		  $vtot_1 = $result_catastral_ali_ts1['valits']*$ut*$att_1;
	   }
   }
   else
   {
	   if($condterreno==0)
	   {
		   $vtot_1 = $result_catastral_ali_ts1['vimp']*$att_1;
	   }
	   else
	   {
		  $vtot_1 = $result_catastral_ali_ts1['valits']*$att_1;
	   }
   }
   //si existe un terreno 2 extrae su valor
   if($att_2>0)
   {
	   $select_catastral_ali_ts2=('select * from catastral_ali_ts where id="'.$alits_id_2.'"');
	   $query_catastral_ali_ts2=(mysql_query($select_catastral_ali_ts2));
	   $result_catastral_ali_ts2=(mysql_fetch_array($query_catastral_ali_ts2));
	   if($result_catastral_ali_ts2['sector_uso'] != 'R' && $result_catastral_ali_ts2['sector_uso'] != 'PU')
	   {
		   if($condterreno2==0)
		   {
			   $vtot_2 = $result_catastral_ali_ts2['vimp']*$ut*$att_2;
		   }
		   else
		   {
			  $vtot_2 = $result_catastral_ali_ts2['valits']*$ut*$att_2;
		   }
	   }
	   else
	   {
		   if($condterreno2==0)
		   {
			   $vtot_2 = $result_catastral_ali_ts2['vimp']*$att_2;
		   }
		   else
		   {
			  $vtot_2 = $result_catastral_ali_ts2['valits']*$att_2;
		   }
	   }
   }
    //valor total del terreno (corrige el monto de el sistema de hacienda)
	$vtot = ($vtot_1 + $vtot_2);
   //FIN DE DATOS
	
	
	//CONSTRUCCION
	// c1
	$atc_1 = $_GET['atc_1'];
	$alics_id_1 = $_GET['alics_id_1'];
	// c2
	$atc_2 = $_GET['atc_2'];
	$alics_id_2 = $_GET['alics_id_2'];
	// c3
	$atc_3 = $_GET['atc_3'];
	$alics_id_3 = $_GET['alics_id_3'];
	// c4
	$atc_4 = $_GET['atc_4'];
	$alics_id_4 = $_GET['alics_id_4'];
	// c5
	$atc_5 = $_GET['atc_5'];
	$alics_id_5 = $_GET['alics_id_5'];
	// c6
	$atc_6 = $_GET['atc_6'];
	$alics_id_6 = $_GET['alics_id_6'];
	// c7
	$atc_7 = $_GET['atc_7'];
	$alics_id_7 = $_GET['alics_id_7'];
	
	//SELECCIONANDO VALORES DE LAS CONSTRUCCIONES
	//valor c1
	$select_catastral_ali_cs1=('select * from catastral_ali_cs where id="'.$alics_id_1.'"');
	$query_catastral_ali_cs1=(mysql_query($select_catastral_ali_cs1));
	$result_catastral_ali_cs1=(mysql_fetch_array($query_catastral_ali_cs1));
	$valor_cs1 = ($result_catastral_ali_cs1['valor']*$atc_1);
	
	//valor c2
	$select_catastral_ali_cs2=('select * from catastral_ali_cs where id="'.$alics_id_2.'"');
	$query_catastral_ali_cs2=(mysql_query($select_catastral_ali_cs2));
	$result_catastral_ali_cs2=(mysql_fetch_array($query_catastral_ali_cs2));
	$valor_cs2 = ($result_catastral_ali_cs2['valor']*$atc_2);
	
	//valor c3
	$select_catastral_ali_cs3=('select * from catastral_ali_cs where id="'.$alics_id_3.'"');
	$query_catastral_ali_cs3=(mysql_query($select_catastral_ali_cs3));
	$result_catastral_ali_cs3=(mysql_fetch_array($query_catastral_ali_cs3));
	$valor_cs3 = ($result_catastral_ali_cs3['valor']*$atc_3);
	
	//valor c4
	$select_catastral_ali_cs4=('select * from catastral_ali_cs where id="'.$alics_id_4.'"');
	$query_catastral_ali_cs4=(mysql_query($select_catastral_ali_cs4));
	$result_catastral_ali_cs4=(mysql_fetch_array($query_catastral_ali_cs4));
	$valor_cs4 = ($result_catastral_ali_cs4['valor']*$atc_4);
	
	//valor c5
	$select_catastral_ali_cs5=('select * from catastral_ali_cs where id="'.$alics_id_5.'"');
	$query_catastral_ali_cs5=(mysql_query($select_catastral_ali_cs5));
	$result_catastral_ali_cs5=(mysql_fetch_array($query_catastral_ali_cs5));
	$valor_cs5 = ($result_catastral_ali_cs5['valor']*$atc_5);
	
	//valor c6
	$select_catastral_ali_cs6=('select * from catastral_ali_cs where id="'.$alics_id_6.'"');
	$query_catastral_ali_cs6=(mysql_query($select_catastral_ali_cs6));
	$result_catastral_ali_cs6=(mysql_fetch_array($query_catastral_ali_cs6));
	$valor_cs6 = ($result_catastral_ali_cs6['valor']*$atc_6);
	
	//valor c7
	$select_catastral_ali_cs7=('select * from catastral_ali_cs where id="'.$alics_id_7.'"');
	$query_catastral_ali_cs7=(mysql_query($select_catastral_ali_cs7));
	$result_catastral_ali_cs7=(mysql_fetch_array($query_catastral_ali_cs7));
	$valor_cs7 = ($result_catastral_ali_cs7['valor']*$atc_7);
	
	//valor total de las construcciones
	$vtoc = ($valor_cs1 + $valor_cs2 + $valor_cs3 + $valor_cs4 + $valor_cs5 + $valor_cs6 + $valor_cs7);
	
	//valor total de los terrenos y construcciones
	$vtc = ($vtot + $vtoc);
	
	//AREA TOTAL DE TODAS LAS CONSTRUCCIONES / CORRIGE EL BUG CON LAS FACTURAS EN INMUEBLE,
	//ES DECIR VISUALIZA EL VALOR DEL LAS CONSTRUCCIONES EN INMUEBLE
	$atc_total = ($atc_1 + $atc_2 + $atc_3 + $atc_4 + $atc_5 + $atc_6 + $atc_7);
	
	//LINDEROS
	$linnorte = $_GET['linnorte'];
	$linsur = $_GET['linsur'];
	$lineste = $_GET['lineste'];
	$linoeste = $_GET['linoeste'];
	$direccion = $_GET['direccion'];
	$obs = $_GET['obs'];
	
	//DATOS DEL REGISTRO Y FISCAL
	$docpres = $_GET['docpres'];
	$fiscal = $_GET['fiscal'];
	
	//CONSTANTE PARA LA TABLA PERFILS
	//$modulo_id = 2; // 2 correcponde al area catastral
	$users = $_SESSION['admin'];
	$catastral_id = $_GET['catastral_id'];
	
	//ID del/los terrenos existentes
	$id_dtt_1 = $_GET['id_dtt_1'];
	$id_dtt_2 = $_GET['id_dtt_2'];
	
	//ID de/las construcciones existentes
	$id_dtcs_1 = $_GET['id_dtcs_1'];
	$id_dtcs_2 = $_GET['id_dtcs_2'];
	$id_dtcs_3 = $_GET['id_dtcs_3'];
	$id_dtcs_4 = $_GET['id_dtcs_4'];
	$id_dtcs_5 = $_GET['id_dtcs_5'];
	$id_dtcs_6 = $_GET['id_dtcs_6'];
	$id_dtcs_7 = $_GET['id_dtcs_7'];	
	
	//OPERACION ADD BOLETIN   (Linea 243 modificada en 2023 para tipo de tributo delterreno y construccion gaceta 2020)
	$update = 'update catastrals set 
								mapac="'.$mapac.'",
								att="'.$att_total.'",
								atc="'.$atc_total.'",
								vtot="'.$vtot.'",
								vtoc="'.$vtoc.'",
								vtc="'.$vtc.'",
								actualizacion="'.$actualizacion.'",
								catatral="'.$catatral.'",
								condterreno="'.$condterreno.'",
								docsup="'.$docsup.'",
								inspeccion="'.$inspeccion.'",
								obs="'.$obs.'",
								direccion="'.$direccion.'",
								linnorte="'.$linnorte.'",
								linsur="'.$linsur.'",
								lineste="'.$lineste.'",
								linoeste="'.$linoeste.'",
								users="'.$users.'",
								docpres="'.$docpres.'",
								fiscal="'.$fiscal.'",
								campoxxx="'.$fiscal.'",  
								modified=now() 
								where id="'.$catastral_id.'"';
	mysql_query($update);
	
		//INGRESANDO MT2 DEL TERRENO 1
		$update2 = 'update catastral_dtts set 
											alits_id="'.$alits_id_1.'",
											mts="'.$att_1.'",
											valor="'.$vtot_1.'" 
											where id="'.$id_dtt_1.'"';
		mysql_query($update2);
		//SI EXISTE TERRENO 2, LO INGRESA...
		if($att_2>0){
				//si existe y esta creado lo actualiza
			if($id_dtt_2>0)
			{
				$update3 = 'update catastral_dtts set 
													alits_id="'.$alits_id_2.'",
													mts="'.$att_2.'",
													valor="'.$vtot_2.'" 
													where id="'.$id_dtt_2.'"';
				mysql_query($update3);
				//ACTUALIZANDO CONDICION DEL TERRENO 2 SI EXISTE
				//0-PROPIO /1-OCUPADO 2-MUNICIPAL
				$update_terreno2 = 'update catastrals set 
													condterreno2="'.$condterreno2.'" 
													where id="'.$catastral_id.'"';
				mysql_query($update_terreno2);
			}
				//si existe pero no esta creado lo ingresa
			else
			{
				$insert1 = 'insert into catastral_dtts (catastral_id,alits_id,mts,valor) 
				value("'.$catastral_id.'","'.$alits_id_2.'","'.$att_2.'","'.$vtot_2.'")';
				mysql_query($insert1);
				//ACTUALIZANDO CONDICION DEL TERRENO 2 SI EXISTE
				//0-PROPIO /1-OCUPADO 2-MUNICIPAL
				$update_terreno2 = 'update catastrals set 
													condterreno2="'.$condterreno2.'" 
													where id="'.$catastral_id.'"';
				mysql_query($update_terreno2);
			}
		}
		else
		{
			$delete1 = 'delete from catastral_dtts where id="'.$id_dtt_2.'"';
			mysql_query($delete1);
		}
		//INSERT CONSTRUCCION 1 SI EXISTE
		if($atc_1>0){
			if($id_dtcs_1>0)
			{
				$update4 = 'update catastral_dtcs set 
													alics_id="'.$alics_id_1.'",
													mts="'.$atc_1.'",
													valor="'.$valor_cs1.'"  
													where id="'.$id_dtcs_1.'"';
				mysql_query($update4);
			}
			else
			{
				$insert2 = 'insert into catastral_dtcs (catastral_id,alics_id,mts,valor) 
				value("'.$catastral_id.'","'.$alics_id_1.'","'.$atc_1.'","'.$valor_cs1.'")';
				mysql_query($insert2);
			}
		}
		else
		{
			$delete2 = 'delete from catastral_dtcs where id="'.$id_dtcs_1.'"';
			mysql_query($delete2);
		}
		//INSERT CONSTRUCCION 2 SI EXISTE
		if($atc_2>0){
			
			if($id_dtcs_2>0)
			{
				$update5 = 'update catastral_dtcs set 
													alics_id="'.$alics_id_2.'",
													mts="'.$atc_2.'",
													valor="'.$valor_cs2.'" 
													where id="'.$id_dtcs_2.'"';
				mysql_query($update5);
			}
			else
			{
				$insert3 = 'insert into catastral_dtcs (catastral_id,alics_id,mts,valor) 
				value("'.$catastral_id.'","'.$alics_id_2.'","'.$atc_2.'","'.$valor_cs2.'")';
				mysql_query($insert3);
			}
		}
		else
		{
			$delete3 = 'delete from catastral_dtcs where id="'.$id_dtcs_2.'"';
			mysql_query($delete3);
		}
		//INSERT CONSTRUCCION 3 SI EXISTE
		if($atc_3>0){
			if($id_dtcs_3>0)
			{
				$update6 = 'update catastral_dtcs set 
													alics_id="'.$alics_id_3.'",
													mts="'.$atc_3.'",
													valor="'.$valor_cs3.'" 
													where id="'.$id_dtcs_3.'"';
				mysql_query($update6);
			}
			else
			{
				$insert4 = 'insert into catastral_dtcs (catastral_id,alics_id,mts,valor) 
				value("'.$catastral_id.'","'.$alics_id_3.'","'.$atc_3.'","'.$valor_cs3.'")';
				mysql_query($insert4);
			}
		}
		else
		{
			$delete4 = 'delete from catastral_dtcs where id="'.$id_dtcs_3.'"';
			mysql_query($delete4);
		}
		//INSERT CONSTRUCCION 4 SI EXISTE
		if($atc_4>0){
			if($id_dtcs_4>0)
			{
				$update7 = 'update catastral_dtcs set 
													alics_id="'.$alics_id_4.'",
													mts="'.$atc_4.'",
													valor="'.$valor_cs4.'" 
													where id="'.$id_dtcs_4.'"';
				mysql_query($update7);
			}
			else
			{
				$insert5 = 'insert into catastral_dtcs (catastral_id,alics_id,mts,valor) 
				value("'.$catastral_id.'","'.$alics_id_4.'","'.$atc_4.'","'.$valor_cs4.'")';
				mysql_query($insert5);
			}
		}
		else
		{
			$delete5 = 'delete from catastral_dtcs where id="'.$id_dtcs_4.'"';
			mysql_query($delete5);
		}
		//INSERT CONSTRUCCION 5 SI EXISTE
		if($atc_5>0){
			if($id_dtcs_5>0)
			{
				$update8 = 'update catastral_dtcs set 
													alics_id="'.$alics_id_5.'",
													mts="'.$atc_5.'",
													valor="'.$valor_cs5.'" 
													where id="'.$id_dtcs_5.'"';
				mysql_query($update8);
			}
			else
			{
				$insert6 = 'insert into catastral_dtcs (catastral_id,alics_id,mts,valor) 
				value("'.$catastral_id.'","'.$alics_id_5.'","'.$atc_5.'","'.$valor_cs5.'")';
				mysql_query($insert6);
			}
		}
		else
		{
			$delete6 = 'delete from catastral_dtcs where id="'.$id_dtcs_5.'"';
			mysql_query($delete6);
		}
		//INSERT CONSTRUCCION 6 SI EXISTE
		if($atc_6>0){
			if($id_dtcs_6>0)
			{
				$update9 = 'update catastral_dtcs set 
													alics_id="'.$alics_id_6.'",
													mts="'.$atc_6.'",
													valor="'.$valor_cs6.'" 
													where id="'.$id_dtcs_6.'"';
				mysql_query($update9);
			}
			else
			{
				$insert7 = 'insert into catastral_dtcs (catastral_id,alics_id,mts,valor) 
				value("'.$catastral_id.'","'.$alics_id_6.'","'.$atc_6.'","'.$valor_cs6.'")';
				mysql_query($insert7);
			}
		}
		else
		{
			$delete7 = 'delete from catastral_dtcs where id="'.$id_dtcs_6.'"';
			mysql_query($delete7);
		}
		//INSERT CONSTRUCCION 7 SI EXISTE
		if($atc_7>0){
			if($id_dtcs_7>0)
			{
				$update10 = 'update catastral_dtcs set 
													alics_id="'.$alics_id_7.'",
													mts="'.$atc_7.'",
													valor="'.$valor_cs7.'" 
													where id="'.$id_dtcs_7.'"';
				mysql_query($update10);
			}
			else
			{
				$insert8 = 'insert into catastral_dtcs (catastral_id,alics_id,mts,valor) 
				value("'.$catastral_id.'","'.$alics_id_7.'","'.$atc_7.'","'.$valor_cs7.'")';
				mysql_query($insert8);
			}
		}
		else
		{
			$delete8 = 'delete from catastral_dtcs where id="'.$id_dtcs_7.'"';
			mysql_query($delete8);
		}
		
		//caja negra
		error_reporting(0);
		$ip=$_SERVER['REMOTE_ADDR'];
		$insert9 = 'insert into cajanegra_editboletin (id_catastrals,mapac,catatral,user_id,fecha,ip) 
		value("'.$catastral_id.'","'.$mapac.'","'.$catatral.'","'.$users.'",now(),"'.$ip.'")';
		mysql_query($insert9);
		?>
        <html>
			<head>
			<meta charset="utf-8">
			<link rel="stylesheet" href="../../css/style-table.css">
			<style type="text/css">
			.messenger {
				font-family: Verdana, 'Lucida Grande';
				font-size: 14px;
				font-weight: bold;
			}
		</style>
		</head>
        <body>
        <br>
		<br>
		<br>
		<br>
		<?php require('../../extras/menu_2.php');?>
        <br>
        <br>
        <section>
        <link rel="stylesheet" href="../../css/style-table.css">
		<table border="1px" width="100%">
			<thead>
       		 <tr>
				<td>Boletin actualizado con exito.</td>
			</tr>
			</thead>
		</table>
		</section>
        </body>
        </html>
        <?php
	}
}
?>