<?php
echo "{ \n";
//print_r($result);
foreach ($result as $item) {
    echo '"descripcion" : "' . $item['descripcion'] . '",';
	echo '"costo" : "' . $item['costo'] . '",';
	echo '"clase" : "' . $item['clase'] . '"';
}

echo "\n}";
?>
