<div align="center">
<script language="javascript">

top.seleccionarcliente(<?php echo $id; ?>,'<?php echo $nombre; ?>');
window.parent.tb_remove();


function actualizarycerrar(id,nombre) {
	top.seleccionarcliente(id,nombre);
	window.parent.tb_remove();
}


</script>
<div class="messagebox"><a href="#" onClick="actualizarycerrar(<?php echo $id; ?>,'<?php echo $nombre; ?>');">Cerrar esta ventana</a></div>
</div>

