<?php
echo "{ \n";
//print_r($result);
foreach ($result as $item) {
    echo '"' . $item['id'] . '" : "' . $item['descripcion'] . ' (' . ($item['cant_nuevas']!="" ? $item['cant_nuevas'] : "0") . ')",';
}
echo '"" : ""';
echo "\n}";
?>
