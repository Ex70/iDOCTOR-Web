
<div style="padding:40px">
<div class="row" style='text-align:center'>
	<h4>Vas a realizar un pago a la orden <?php echo $equipo['num_orden']; ?></h4>
	<p>Por favor especifica el tipo de pago</p>
</div>
<div class="row" style="text-align:center">
    <div class="six columns"><a href="/index.php/movimientos/agregarpagoaequipo2/<?php echo $equipo['id']; ?>/ANTICIPO" class="button" style='height:100px;background-color:#ff0'>Pago de anticipo</a></div>
<?php if (($equipo['estatus']=="Entregado") || ($equipo['estatus']=="No reparable"))   { ?> 
    <div class="six columns"><a href="/index.php/movimientos/agregarpagoaequipo2/<?php echo $equipo['id']; ?>/ENTREGA" class="button" style='height:100px;background-color:#0f0'>Pago de entrega</a></div>    
<?php } 
    else {
      ?>  
    <div class="six columns"><a href="#" onclick="alert('El equipo no ha sido entregado, tienes que hacer la entrega en la bitácora.');" class="button" style='height:100px;background-color:#0f0'>Pago de entrega</a></div>    
<?php } ?>        
</div>
</div>
