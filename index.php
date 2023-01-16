<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

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

</body>


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

</html>
