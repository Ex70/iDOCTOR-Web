<table width="100%">
	<?php
	  $j = 1;
	  for ($i=0;$i<sizeof($datos);$i++) {
	  	if ($j==5) {
	  		echo "</tr>";
			$j = 1;
	  	}
	  	if ($j==1) echo "<tr>";
	  	echo "<td><div align='center'><img height='100' width='100' src='" . $datos[$i] . "'></td>";
		$j++;
	  }
	?>
</table>
