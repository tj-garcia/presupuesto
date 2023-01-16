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
if(!isset($_GET['id_catatrals']))
{
	header('Location: ver-boletines.php');
}
else
{
	conectar_db();
	//seleccion de datos del sujeto pasivo
	$select = 'select * from sujetopasivos where id="'.$_SESSION['contribuyente'].'"';
	$query=mysql_query($select);
	$result=mysql_fetch_array($query);
	
	//seleccion de datos la ficha castral
	$select2 = 'select * from catastrals where id="'.$_GET['id_catatrals'].'"';
	$query2=mysql_query($select2);
	$result2=mysql_fetch_array($query2);
	
	//seleccion de datos detalles del terreno
	$select3 = 'select * from catastral_dtts where catastral_id="'.$_GET['id_catatrals'].'"';
	$query3=mysql_query($select3);
	$i=0;
	while($result3=mysql_fetch_array($query3))
	{
		$i += 1;
		$dtt_id[$i] = $result3['id'];
		$alits_id[$i] = $result3['alits_id'];
		$mts_t[$i] = $result3['mts'];
		
		$selec_ali_t = 'select * from catastral_ali_ts where id="'.$alits_id[$i].'"';
		$query_ali_t = mysql_query($selec_ali_t);
		$result_ali_t = mysql_fetch_array($query_ali_t);
		$ali_t_sector_uso[$i] = $result_ali_t['sector_uso'];
	}
	//seleccion de datos detalle de construcciones
	$select4 = 'select * from catastral_dtcs where catastral_id="'.$_GET['id_catatrals'].'"';
	$query4=mysql_query($select4);
	$i2=0;
	while($result4=mysql_fetch_array($query4))
	{
		$i2 += 1;
		$dtcs_id[$i2] = $result4['id'];
		$alics_id[$i2] = $result4['alics_id'];
		$mts_cs[$i2] = $result4['mts'];
		
		$selec_ali_cs = 'select * from catastral_ali_cs where id="'.$alics_id[$i2].'"';
		$query_ali_cs = mysql_query($selec_ali_cs);
		$result_ali_cs = mysql_fetch_array($query_ali_cs);
		$ali_cs_sector_uso[$i2] = $result_ali_cs['tipo'];
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>Registro de contribuyentes (sujeto pasivo)</title>
<link rel="stylesheet" href="../../css/style-table-boletin.css">
<link href="../../css/calendario.css" type="text/css" rel="stylesheet">
<script src="../../js/calendar.js" type="text/javascript"></script>
<script src="../../js/calendar-es.js" type="text/javascript"></script>
<script src="../../js/calendar-setup.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="../../js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery.addfield.js"></script>-->
<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/validCampo-caracter.js"></script>
<style type="text/css">
*{
	margin:0px;
	padding:0px;
}

div#seleccionado{
	float:left;
	margin-left:60px;
	width:300px;
	height:270px;
}
div#boletin{
	/*float:right;*/
	margin-left:500px;
	/*width:900px;
	height:300px;
	background:red;*/
}
#boletin center form p .titulos strong {
	font-size: 14px;
}
#boletin center .titulos strong {
	font-size: 14px;
}
#seleccionado .titulos strong {
	font-size: 14px;
}
#boletin .titulos strong {
	font-size: 14px;
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
<div id="general">
	<div id="seleccionado">
    <p class="titulos" style="color: #ECF0F1;"><strong>CONTRIBUYENTE SELECCIONADO:</strong></p>
    <p class="titulos">&nbsp;</p>
  	<table width="300" border="1">
    	<tr>
  	    <td><strong>Sujeto Pasivo:</strong></td>
  	    <td><?php if($result['tiposuj'] ==1){echo 'NATURAL';}else if($result['tiposuj'] ==2){echo 'JURIDICO';}else{echo 'No espesificado';}
		 ?></td>
   	 </tr>
   	 <tr>
   	   <td><strong>Razon social:</strong></td>
   	   <td><?php echo $result['rs'];?></td>
   	 </tr>
   	 <tr>
   	   <td><strong>Cedula/Rif:</strong></td>
   	   <td><?php echo $result['crif'];?></td>
   	 </tr>
   	<thead>
   			<tr>
   				<td>SELECCION</td>
   	         <td>DATOS</td>
   			</tr>
   	</thead>
  	</table> 
  	<table width="100" border="1">
   	 <tr>
   	   <td>
   	   <form action="add-boletin.php" method="get">
   	   <input type="submit" value="Agregar boletin"></form>
		  </form>
   	   </td>
   	   <td>
   	   <form action="ver-boletines.php" method="get">
   	   <input type="submit" value="Ver boletines"></form>
		  </form>
    	  </td>
     	</tr>
   		 <tr>
  	  <td>
      	<form action="editar-contribuyente.php" method="get">
     	 <input type="submit" value="Editar contribuyente"></form>
		  </form>
    	  </td>
   	   <td>
   	   <form action="buscar-contribuyente.php" method="get">
   	   <input type="submit" value="Seleccionar otro"></form>
		  </form>
    	  </td>
  	  </tr>
 	 </table>
</div>
    <div id="boletin">
    
 <p class="titulos" style="color: #ECF0F1;"><strong>EDICION DE BOLETIN CASTRAL</strong></p>
 <br>
 <form name="form1" method="get" action="operacion-editarboletin.php">
 <input name="catastral_id" type="hidden" value="<?php echo $_GET['id_catatrals'];?>">
  <input name="mapac" type="hidden" value="<?php echo $result2['mapac'];?>">
 <table width="716" border="1">
   <thead>
   <tr>
     <td width="154">BOLETIN</td>
     <td width="154">CEDULA CASTRAL</td>
     <td width="188">DOCUMENTOS PRESENTADOS</td>
   </tr>
   </thead>
   <tr>
     <td align="center"><p>
       <label for="mapac"></label>
       <input value="<?php echo $result2['mapac'];?>" type="text" name="mapac" id="mapac" placeholder="ingrese N° boletin" onKeyUp="this.value=this.value.toUpperCase();" disabled required>
     </p>
       <p>
         <label for="actualizacion"><strong>Ultima Actualizacion</strong></label>
         <input type="date" name="actualizacion" id="actualizacion" required>
         <img src="../../images/calendario.png" width="16" height="16" border="0" title="Ultima Actualizacion" id="lanzador1">
       </p></td>
        <script type="text/javascript"> 
  			 Calendar.setup({ 
    		 inputField     :    "actualizacion",
    	 	 ifFormat     :     "%Y-%m-%d",
   		  	 button     :    "lanzador1"   
		}); 
		</script>
     <td><label for="catatral"></label>
      <input value="<?php echo $result2['catatral'];?>" type="text" name="catatral" id="catatral" placeholder="ingrese cedula castral" onKeyUp="this.value=this.value.toUpperCase();" required></td>
     <td align="center">
       <label for="docsup"></label>
       <select name="docsup" id="docsup">
        <option><?php echo $result2['docsup'];?></option>
        <option>NOTARIADO</option>
		<option>REGISTRADO</option>
		<option>RECONOCIDO</option>
		<option>TITULO</option>
		<option>INAVI</option>
       </select>
       <br>
         <label for="inspeccion"><strong>Ultima Insp.</strong></label><br>
         <input value="<?php echo $result2['inspeccion'];?>" type="date" name="inspeccion" id="inspeccion" required>
         <img src="../../images/calendario.png" width="16" height="16" border="0" title="Ultima Inspeccion" id="lanzador2">
       </td>
       <script type="text/javascript"> 
  			 Calendar.setup({ 
    		 inputField     :    "inspeccion",  
    	 	 ifFormat     :     "%Y-%m-%d",   
   		  	 button     :    "lanzador2"  
		}); 
		</script>
   </tr>
 </table>
 <p>&nbsp;</p>
 <p><span class="titulos" style="color: #ECF0F1;"><strong>CALCULO DE VALOR DE TERRENO Y CONSTRUCCION</strong></span></p>
 <!-- Adaptacion 2023  -->
      <table width="540" border="1">
         <thead>
         <tr>
           <td colspan="2">
             ORDENANZA 2020
           </td>
         </tr>
         <tr>
           <td>USO</td>
           <td>UBICACI&Oacute;n</td>
         </tr>
         </thead>
         <tr>
           <td>
               <div id="Lista_I">
               <select id="tipoI" onchange="showHint(this.value)">
                    <option value="1101000" selected="selected">Residencial</option>
                    <option value="1201000" >Comercial</option>
                    <option value="1301000" >Industria Privada</option>
                    <option value="1401000" >Industria P&uacute;blica</option>
                    <option value="1501000" >Sector Hotelero</option>
               </select>
               </div>       
           </td>
           <td>
               <div id="Lista_II">
               <select id="tipoII">
                       <option value="showAll" selected="selected">Show All Products</option>
               </select>
               </div>      
           </td>
         </tr>   
      </table>
 <!-- fin Adaptacion 2023  -->

 <table width="540" border="1">
   <thead>
   <tr>
     <td>TIPO</td>
     <td>AREA MT2</td>
     <td>TIPO/USO</td>
     <td>TIPO DE TERRENO</td>
   </tr>
   </thead>
   <tr>
     <td>1) Terreno</td>
     <td> <input value="<?php echo $mts_t[1];?>" type="number" step="00.01" name="att_1" id="att_1" min="0" placeholder="ingrese el area mt2" required></td>
     <td>
     <input name="id_dtt_1" type="hidden" value="<?php echo $dtt_id[1];?>">
     <select name="alits_id_1" id="alits_id_1">
     <option value="<?php echo $alits_id[1];?>"><?php echo $ali_t_sector_uso[1];?></option>
      <?php
	  $select_t ='select * from catastral_ali_ts';
	  $query_t = mysql_query($select_t);
	  while($result_t = mysql_fetch_array($query_t)){echo '<option value="'.$result_t['id'].'">'.$result_t['sector_uso'].'</option>';}
	  ?>
       </select></td>
       <td>
       <select name="condterreno" id="condterreno">
       <?php 
	   		if($result2['condterreno'] == '0'){$terreno_test=true;$condterreno = 'Propio';}
			if($result2['condterreno'] == '1'){$terreno_test=true;$condterreno = 'Ocupado';}
			if($result2['condterreno'] == '2'){$terreno_test=true;$condterreno = 'Municipal';}
			if($terreno_test != true){$terreno_test=false;$condterreno = $result2['condterreno'];}
		?>
       <option value="<?php echo $result2['condterreno'];?>"><?php echo $condterreno;?></option>
       <option value="0">Propio</option>
       <option value="1">Ocupado</option>
       <option value="2">Municipal</option>
       </select>
       </td>
   </tr>
   <tr>
   <td>2) Terreno</td>
     <td><input value="<?php if($mts_t[2]>0){echo $mts_t[2];}else{echo 0;}?>" type="number" name="att_2" id="att_2" min="0" step="00.01"></td>
     <td>
     <input name="id_dtt_2" type="hidden" value="<?php echo $dtt_id[2];?>">
     <select name="alits_id_2" id="alits_id_2">
      <?php
	  if($alits_id[2]>0)
	  {
	  ?> 
      <option value="<?php echo $alits_id[2];?>"><?php echo $ali_t_sector_uso[2];?></option>
	  <?php }?>
	  <?php
	  $select_t ='select * from catastral_ali_ts';
	  $query_t = mysql_query($select_t);
	  while($result_t = mysql_fetch_array($query_t)){echo '<option value="'.$result_t['id'].'">'.$result_t['sector_uso'].'</option>';}
	  ?>
       </select></td>
       <td>
       <select name="condterreno2" id="condterreno2">
       <?php 
	   		if($result2['condterreno2'] == '0'){$terreno_test2=true;$condterreno2 = 'Propio';}
			if($result2['condterreno2'] == '1'){$terreno_test2=true;$condterreno2 = 'Ocupado';}
			if($result2['condterreno2'] == '2'){$terreno_test2=true;$condterreno2 = 'Municipal';}
			if($terreno_test2 != true){$terreno_test2=false;$condterreno2 = $result2['condterreno2'];}
		?>
       <option value="<?php echo $result2['condterreno2'];?>"><?php echo $condterreno2;?></option>
       <option value="0">Propio</option>
       <option value="1">Ocupado</option>
       <option value="2">Municipal</option>
       </select>
       </td>
   </tr>
   <tr>
     <td>1) Construccion</td>
     <td><input type="number" name="atc_1" id="atc_1" min="0" value="<?php if($mts_cs[1]>0){echo $mts_cs[1];}else{echo 0;}?>" step="00.01"></td>

     <td colspan="2">
     <input name="id_dtcs_1" type="hidden" value="<?php echo $dtcs_id[1];?>">
     <select name="alics_id_1">
     <?php
	  if($alics_id[1]>0)
	  {
	  ?>
      
      <option value="<?php echo $alics_id[1];?>"><?php echo $ali_cs_sector_uso[1];?></option>
	  <?php }?>
    <?php
	  $select_c ='select * from catastral_ali_cs';
	  $query_c = mysql_query($select_c);
	  while($result_c = mysql_fetch_array($query_c)){echo '<option value="'.$result_c['id'].'">'.$result_c['tipo'].'</option>';}
	  ?>
     </select></td>
   </tr>
   <tr>
     <td>2) Construccion</td>
     <td><input type="number" name="atc_2" id="atc_2" min="0" value="<?php if($mts_cs[2]>0){echo $mts_cs[2];}else{echo 0;}?>" step="00.01"></td>
     <td colspan="2">
     <input name="id_dtcs_2" type="hidden" value="<?php echo $dtcs_id[2];?>">
     <select name="alics_id_2">
     <?php
	  if($alics_id[2]>0)
	  {
	  ?>
      <option value="<?php echo $alics_id[2];?>"><?php echo $ali_cs_sector_uso[2];?></option>
	  <?php }?>
	<?php
	  $select_c ='select * from catastral_ali_cs';
	  $query_c = mysql_query($select_c);
	  while($result_c = mysql_fetch_array($query_c)){echo '<option value="'.$result_c['id'].'">'.$result_c['tipo'].'</option>';}
	  ?>
     </select></td>
   </tr>
   <tr>
     <td>3) Construccion</td>
     <td><input type="number" name="atc_3" id="atc_3" min="0" value="<?php if($mts_cs[3]>0){echo $mts_cs[3];}else{echo 0;}?>" step="00.01"></td>
     <td colspan="2">
     <input name="id_dtcs_3" type="hidden" value="<?php echo $dtcs_id[3];?>">
     <select name="alics_id_3">
      <?php
	  if($alics_id[3]>0)
	  {
	  ?>
      <option value="<?php echo $alics_id[3];?>"><?php echo $ali_cs_sector_uso[3];?></option>
	  <?php }?>
	<?php
	  $select_c ='select * from catastral_ali_cs';
	  $query_c = mysql_query($select_c);
	  while($result_c = mysql_fetch_array($query_c)){echo '<option value="'.$result_c['id'].'">'.$result_c['tipo'].'</option>';}
	  ?>
     </select></td>
   </tr>
   <tr>
     <td>4) Construccion</td>
     <td><input type="number" name="atc_4" id="atc_4" min="0" value="<?php if($mts_cs[4]>0){echo $mts_cs[4];}else{echo 0;}?>" step="00.01"></td>
     <td colspan="2">
     <input name="id_dtcs_4" type="hidden" value="<?php echo $dtcs_id[4];?>">
     <select name="alics_id_4">
      <?php
	  if($alics_id[4]>0)
	  {
	  ?>
      <option value="<?php echo $alics_id[4];?>"><?php echo $ali_cs_sector_uso[4];?></option>
	  <?php }?>
	<?php
	  $select_c ='select * from catastral_ali_cs';
	  $query_c = mysql_query($select_c);
	  while($result_c = mysql_fetch_array($query_c)){echo '<option value="'.$result_c['id'].'">'.$result_c['tipo'].'</option>';}
	  ?>
     </select></td>
   </tr>
   <tr>
     <td>5) Construccion</td>
     <td><input type="number" name="atc_5" id="atc_5" min="0" value="<?php if($mts_cs[5]>0){echo $mts_cs[5];}else{echo 0;}?>" step="00.01"></td>
     <td colspan="2">
     <input name="id_dtcs_5" type="hidden" value="<?php echo $dtcs_id[5];?>">
     <select name="alics_id_5">
      <?php
	  if($alics_id[5]>0)
	  {
	  ?> 
      <option value="<?php echo $alics_id[5];?>"><?php echo $ali_cs_sector_uso[5];?></option>
	  <?php }?>
	<?php
	  $select_c ='select * from catastral_ali_cs';
	  $query_c = mysql_query($select_c);
	  while($result_c = mysql_fetch_array($query_c)){echo '<option value="'.$result_c['id'].'">'.$result_c['tipo'].'</option>';}
	  ?>
     </select></td>
   </tr>
   <tr>
     <td>6) Construccion</td>
     <td><input type="number" name="atc_6" id="atc_6" min="0" value="<?php if($mts_cs[6]>0){echo $mts_cs[6];}else{echo 0;}?>" step="00.01"></td>
     <td colspan="2">
     <input name="id_dtcs_6" type="hidden" value="<?php echo $dtcs_id[6];?>">
     <select name="alics_id_6">
      <?php
	  if($alics_id[6]>0)
	  {
	  ?>
      <option value="<?php echo $alics_id[6];?>"><?php echo $ali_cs_sector_uso[6];?></option>
	  <?php }?>
	<?php
	  $select_c ='select * from catastral_ali_cs';
	  $query_c = mysql_query($select_c);
	  while($result_c = mysql_fetch_array($query_c)){echo '<option value="'.$result_c['id'].'">'.$result_c['tipo'].'</option>';}
	  ?>
     </select></td>
   </tr>
   <tr>
     <td>7) Construccion</td>
     <td><input type="number" name="atc_7" id="atc_7" min="0" value="<?php if($mts_cs[7]>0){echo $mts_cs[7];}else{echo 0;}?>" step="00.01"></td>
     <td colspan="2">
     <input name="id_dtcs_7" type="hidden" value="<?php echo $dtcs_id[7];?>">
     <select name="alics_id_7">
      <?php
	  if($alics_id[7]>0)
	  {
	  ?>
      <option value="<?php echo $alics_id[7];?>"><?php echo $ali_cs_sector_uso[7];?></option>
	  <?php }?>
	<?php
	  $select_c ='select * from catastral_ali_cs';
	  $query_c = mysql_query($select_c);
	  while($result_c = mysql_fetch_array($query_c)){echo '<option value="'.$result_c['id'].'">'.$result_c['tipo'].'</option>';}
	  ?>
     </select></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <p><span class="titulos" style="color: #ECF0F1;"><strong>LINDEROS</strong></span></p>
 <table width="400" border="1">
   <thead>
   <tr>
     <td>NORTE</td>
     <td>SUR</td>
   </tr>
   </thead>
   <tr>
     <td><textarea name="linnorte" id="linnorte" cols="25" rows="" placeholder="ingrese lindero (norte)" onKeyUp="this.value=this.value.toUpperCase();" required><?php echo $result2['linnorte'];?></textarea></td>
     <td><textarea name="linsur" id="linsur" cols="25" rows="" placeholder="ingrese lindero (sur)" onKeyUp="this.value=this.value.toUpperCase();" required><?php echo $result2['linsur'];?></textarea></td>
   </tr>
   <thead>
   <tr>
     <td>ESTE</td>
     <td>OESTE</td>
   </tr>
   </thead>
   <tr>
     <td><textarea name="lineste" id="lineste" cols="25" rows="" placeholder="ingrese lindero (este)" onKeyUp="this.value=this.value.toUpperCase();" required><?php echo $result2['lineste'];?></textarea></td>
     <td><textarea name="linoeste" id="linoeste" cols="25" rows="" placeholder="ingrese lindero (oeste)" onKeyUp="this.value=this.value.toUpperCase();" required><?php echo $result2['linoeste'];?></textarea></td>
   </tr>
 </table>
 <table width="400" border="1">
 	<thead>
   <tr>
     <td>DIRECCION</td>
     <td>OBSERVACION</td>
   </tr>
   </thead>
   <tr>
     <td><textarea name="direccion" id="direccion" cols="25" rows="" placeholder="ingrese direccion" onKeyUp="this.value=this.value.toUpperCase();" required><?php echo $result2['direccion'];?></textarea></td>
     <td><textarea name="obs" id="obs" cols="25" rows="" placeholder="(Opcional)" onKeyUp="this.value=this.value.toUpperCase();"><?php echo $result2['obs'];?></textarea></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <p><span class="titulos" style="color: #ECF0F1;"><strong>DATOS DEL REGISTRO</strong></span></p>
 <table width="100" border="1">
 <thead>
   <tr>
     <td>DOCUMENTO PRESENTADO</td>
     <td>FISCAL</td>
   </tr>
 </thead>
   <tr>
     <td><textarea name="docpres" id="docpres" cols="25" rows="" placeholder="ingrese documento registrado" onKeyUp="this.value=this.value.toUpperCase();"><?php echo $result2['docpres'];?></textarea></td>
     <td><label for="fiscal"></label>
       <select name="fiscal" id="fiscal">
       <option><?php echo $result2['fiscal'];?></option>
       <?php
       //seleccion de fiscal
		$select_fiscal='select fiscal from configuracions';
		$query_fiscal=mysql_query($select_fiscal);
		while($result_fiscal=mysql_fetch_array($query_fiscal))
		{
	   if($result_fiscal['fiscal'] !=''){?><option><?php echo utf8_encode($result_fiscal['fiscal']);}?></option>
       <?php }?>
       </select>
     </td>
 </table>
 <p>&nbsp;</p>
 <table width="120" border="1">
   <tr>
     <td width="110" align="center"><input type="submit" value="GUARDAR BOLETIN"></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 </form>

</div>

<!-- Adaptación 2023 -->
<script>
  function showHint(p_param) {
      p_valor = p_param;
      if (p_valor.length == 0) {
        document.getElementById("Lista_II").innerHTML = "";
        return;
      } else {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function() {
          document.getElementById("Lista_II").innerHTML = this.responseText;
      }
      xmlhttp.open("GET", "alic_ajax.php?p_valor=" + p_valor);
      xmlhttp.send();
      }

  }

</script>
<!-- Fin Adaptación 2023 -->



</body>
</html>
<?php
}
?>