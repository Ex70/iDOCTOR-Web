<?php
echo "{ \n";
//print_r($result);
foreach ($result as $item) {
    echo '"' . $item['capacidad'] . '" : "' . $item['capacidad'] . '",';
}
echo '"" : ""';
echo "\n}";
?>
