<script language="javascript">
top.location.reload();
        $(document).ready(
                function(){
                        $('#botoncito').innerfade({
                                speed: 'slow',
                                timeout: 100,
                                type: 'sequence',
                                containerheight: '220px'
                        });
                }
        );

</script>


<div align="center">
<div style="height:100px;"></div>
<div class="botoncito" id="botoncito" style="display:none;"></div>
<div class="messagebox demo"><a href="#" onClick="top.location.reload();">Cerrar esta ventana</a></div>
</div>




