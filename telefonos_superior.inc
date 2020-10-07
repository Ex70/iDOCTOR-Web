<?php
//this gets the URL after the host name
$uri = $_SERVER['REQUEST_URI'];
$thisfile = substr($uri, strrpos($uri, '/') + 1);

?>

 <!--MENU-->
		<div class="row header-nav" align="justify" >
			 
		<div class="section-container">	
		<div id="map" class="map principal"><span class="t-tip"></span>
		  <img src="../menu/verde.png" width="780" height="136" usemap="#map_area" align="right"/><map name="map_area" id="map_area">
		  
              
			  <area shape="poly" href="https://www.facebook.com/PronaturaVeraruz/?ref=br_rs" target="_blank" coords="674,29,682,15,702,22,698,36,684,41" />
			  <area shape="poly" href="https://twitter.com/pronatura_ver?lang=es" target="_blank" coords="710,25,723,14,738,27,735,38,719,42" />
			  <area shape="poly" href="https://www.youtube.com/user/pronaturaveracruz" target="_blank" coords="744,28,750,16,767,17,768,34,751,41" />
			
			 
		</div>
		</div>
				
			<div class="span8">
			
               <nav id="menu" class="clearfix" width="100%" >
                    <ul>
                        
						<li  ><a href="../index.php" ><span class="name">Inicio</span></a></li>
                        <li><a href="../quienes_somos.php"><span class="name">&iquest;Qui&eacute;nes somos?</span></a>
							<ul>
                                <li><a href="../donde_trabajamos.php">&iquest;D&oacute;nde trabajamos?</a></li>
								<li><a href="../programas_conservacion.php">Programas de conservaci&oacute;n</a></li>
								<li><a href="../siguientes_anos.php">Los siguientes 5 a&ntilde;os</a></li>
								<li><a href="../consejo_directivo.php">Consejo directivo</a></li>
								<li><a href="../sistema_pronatura.php">Sistema Pronatura</a></li>
							</ul>	
                        </li>
						 
						 <li class="current"><a href="#"><span class="name">Programas</span></a>
							<ul>
                                <li><a href="../ecoforestal/index.php"><span class="name">Ecoforestal</span></a>
									<ul>
										<li><a href="../ecoforestal/index.php"><span class="name">Inicio</span></a></li>
										<li><a href="../ecoforestal/ef_restauracion_ecologica.php">Restauraci&oacute;n ecol&oacute;gica </a></li>
										<li><a href="../ecoforestal/ef_manglares.php ">Manglares</a></li>
										<li><a href="../ecoforestal/ef_bosque_niebla.php">Bosque de niebla</a></li>
										<li><a href="../ecoforestal/ef_habitat_aves.php">H&aacute;bitat para Aves</a></li>
										<li><a href="../ecoforestal/ef_cafetales.php">Cafetales</a></li>
										<li><a href="../ecoforestal/ef_mieles_silvestres.php">Mieles silvestres</a></li>
										<li><a href="../ecoforestal/ef_tienda_ecoforestal.php">Tienda ecoforestal</a></li>
										<li><a href="../ecoforestal/viveros.php">Viveros de biodiversidad</a></li>
									</ul>
								</li>
								<li><a href="index.php"><span class="name">Altas monta&ntilde;as / Zonas templadas</span></a>
									<ul>
										<li><a href="index.php"><span class="name">Inicio</span></a></li>
										<li><a href="conservacion.php">Conservaci&oacute;n</a></li>
										<li><a href="restauracion.php">Restauraci&oacute;n </a></li>
										<li><a href="rec_forestales.php">Manejo de recursos forestales no maderables </a></li>
										<li><a href="comunicacion.php">Comunicaci&oacute;n y educaci&oacute;n ambiental </a></li>
										<li><a href="monitoreo.php">Monitoreo </a></li>
										<li><a href="publicaciones.php">Publicaciones</a></li>
										<li><a href="quienes_somos.php">&iquest;Qui&eacute;nes somos?</a></li>
									</ul>
								</li>
								<li><a href="../vrr/vrr_inicio.php"><span class="name">Veracruz r&iacute;o de rapaces</span></a>
									<ul>
										<li><a href="../vrr/vrr_inicio.php"><span class="name">Inicio</span></a></li>
										<li><a href="../vrr/proy_historia.php">El Proyecto </a></li>
										<li><a href="../vrr/vrr_programas.php">Programas</a></li>
										<li><a href="../vrr/vrr_servicios.php">Servicios</a></li>
										<li><a href="../vrr/vrr_voluntarios.php">&iquest;C&oacute;mo participar? </a></li>
										<li><a href="../vrr/vrr_equipo.php">Equipo</a></li>
									</ul>
								</li>
									
							</ul>
                        </li>
						<li><a href="../como_participar.php"><span class="name">&iquest;C&oacute;mo participar?</span></a></li>
						<li><a href="../contribuye.php"><span class="name">Contribuye</span></a></li>
						<li ><a href="../blog.html"><span class="name">Blog</span></a></li>
						<li ><a href="#"><span class="name">Socios</span></a>
							<ul>
								<li><a href="../socios.php">Socios</a></li>
								<li><a href="../informes_anuales.php">Informes anuales </a></li>
							</ul>
						</li>
						<li><a href="../contacto.php"><span class="name">Contacto</span></a></li>
                    </ul>
                </nav>
              
            </div>
        </div>
		<!--FIN MENU-->