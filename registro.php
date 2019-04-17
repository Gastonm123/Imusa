<?php

$SERVER = "localhost";
$NAME = "gaston";
$PASS = "1234";
$DB = "prueba";

$con = mysqli_connect($SERVER, $NAME, $PASS, $DB);

if(!$con) {
	die( 'Error de Conexion (' . mysqli_connect_errno() . ') ' . mysqli_connect_error() );
} 

$sql = "SELECT * FROM alumnos";

if(!$result = mysqli_query($con, $sql)) die(mysqli_error($con));

echo "<table>";

for($i = 0; $i < $result->num_rows; $i++){
	$result->data_seek($i);

	$actual_data = $result->fetch_array();
	$size_data   = sizeof($actual_data) / 2;
	
	echo "<tr>";
	for($j = 0; $j < $size_data; $j++){

		echo "<td>" . $actual_data[$j] . "</td>";

	}
	echo "</tr>";
}

echo "</table>";
mysqli_close($con);

?>
