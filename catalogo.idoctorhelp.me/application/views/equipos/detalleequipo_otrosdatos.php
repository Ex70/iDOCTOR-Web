
<tr>
<td style="height:60px;" colspan="4"><div class="titulo3">Datos del equipo</div></td>
</tr>
<tr>
<td colspan="2">Equipo en garant&iacute;a</td>
<td colspan="2"><img src="/images/<?php if ($equipo_en_garantia=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
</tr> 
<tr>
<td colspan="2">Alguien m&aacute;s intent&oacute; reparar el equipo</td>
<td colspan="2"><img src="/images/<?php if ($intentaron_repararlo=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
</tr>
<tr>
<td colspan="2">Estuvo en contacto con agua o vapores</td>
<td colspan="2"><img src="/images/<?php if ($en_contacto_con_agua_vap=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
</tr>
<tr>
<td colspan="2">iPhone fue comprado en el pa&iacute;s</td>
<td colspan="2"><img src="/images/<?php if ($iphone_comprado_en_pais=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
</tr>
<tr>
<td colspan="2">Tiene Jailbreak</td>
<td colspan="2"><img src="/images/<?php if ($tiene_jailbreak_o_cydia=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
</tr>
<tr>
<td colspan="2" style="height:30px;">Tiene desbloqueo</td>
<td colspan="2"><?php echo $equipo_tiene_desbloqueo; ?></div></td> 
</tr>

<tr>
<td colspan="2">Contrase&ntilde;a del equipo</td>
<td colspan="2"><?php echo $contrasenia; ?></td>	
</tr>


