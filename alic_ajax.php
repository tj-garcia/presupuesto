<?php
//include('../../security/config.php');
/*
  conectar_db();
  //seleccion de datos del sujeto pasivo
  $select = 'select * from sujetopasivos where id="'.$_SESSION['contribuyente'].'"';
  $query=mysql_query($select);
  $result=mysql_fetch_array($query);

*/

    /*Datos de acceso  -  conectar base de datos mysqli*/
    $mysql_nombre = "root";
    $mysql_pass = "";
    $mysql_host = "localhost";
    $mysql_DB = "saap";

    $enlace = mysqli_connect($mysql_host, $mysql_nombre, $mysql_pass, $mysql_DB);
    if (!$enlace) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "Id del error: " . mysqli_connect_errno() . PHP_EOL;
        echo "Descripción: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

$impuestos = filter_input(INPUT_GET, 'p_valor'); //obtenemos el parametro que viene de ajax
$maximo_valor = $impuestos + 999;
if($impuestos != ''){ //verificamos nuevamente que sea una opcion valida
  $sql = "SELECT * FROM tabla where col1 >= ".$impuestos." and col1 <= ".$maximo_valor." ORDER BY col4 ASC";  
  $query = mysqli_query($enlace, $sql);
  $filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
}

$num=0;
$data = '<select id="tipoII">';
foreach($filas as $op): //creamos las opciones a partir de los datos obtenidos 
$num=$num+1;
$data = $data . '<option value="'.utf8_encode($op["COL1"]).'">'.$op["COL4"]." - ".$op["COL2"].'</option>';	
endforeach; 
$data = $data.'</select>';
echo $data;
?>
