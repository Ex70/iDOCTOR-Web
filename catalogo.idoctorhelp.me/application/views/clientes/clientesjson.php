<?php
echo "{ \n";
//print_r($result);
foreach ($result as $item) {
    echo '"' . $item['id'] . '" : "' . $item['nombre'] . '",';
}
echo '"" : ""';
echo "\n}";
?>
