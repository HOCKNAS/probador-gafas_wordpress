<?php

//Vista publica del plugin
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
?>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__).'libs/font-awesome-4.4.0/css/font-awesome.css' ?>" />

<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__).'libs/swiper/css/swiper.min.css' ?>" />

<div class="container" >
	<div class="modal fade" id="TryOnModal" data-backdrop="false" role="dialog" style="z-index: 10000000;margin-top: 45px;">
		<div class="modal-dialog" id="TryOnModal-dialog" >
			<div class="modal-content try_on_popup">

				<!-- Header del pop-up -->
				<div class="modal-header" style="padding-top: 5px;padding-left: 5px;padding-bottom: 0px;">
					<!-- <input type="text" name="tryon-glasses" id="galssimage" value=""/> -->
				</div>

				<!-- Body del pop-up -->
				<div class="modal-body" id="modal_body">

					<!-- Script de iniciación  -->
					<script type="text/x-template" id="tryon-template">
						
						<div class="trying clearfix">
							<div class="row">
								<div class="trying__view-wrapper"> 

									<!-- Contenedor del canvas -->
									<div id="container">
										<canvas id="image" width="100%"></canvas>
										<video class="trying__hidden" id="video" autoplay="autoplay" muted loop> </video>
										<canvas id="overlay" width="100%" ></canvas>
									</div>

									<!-- Boton para encender la cámara -->
									<button class="webcam-btn"> 3D </button>
									<div class="trying__little-photo-slide_active" style="border: none">
										<a href="javascript:void(0);" ></a>
									</div>

								</div>
							</div>
						</div>
					</script>
					
					<!-- Contenedor en el que se inserta lo renderizado en el script de iniciación -->
					<div id="tryon-container" class="container2"></div>

				</div>
				
				<!-- Footer del pop-up -->
				<div class="modal-footer">
                    <?php echo "<a class='btn btn-info' id='addtocartlink' href=''><span class='glyphicons glyphicons-shoping-cart'></span>Añadir al carrito</a>";?> 
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
				</div>
				
			</div>	
		</div>	
	</div>


	<script src="<?php echo plugin_dir_url(__FILE__).'js/try-on.js'?>"></script>
	<script src="<?php echo plugin_dir_url(__FILE__).'js/script.js'?>"></script>
	<script src="<?php echo plugin_dir_url(__FILE__).'libs/clmtrackr/clmtrackr.js'?>"></script>
	<script src="<?php echo plugin_dir_url(__FILE__).'libs/clmtrackr/models/model_pca_20_svm.js'?>"></script>
	<script src="<?php echo plugin_dir_url(__FILE__).'js/face-tracker.js'?>"></script>
	<script src="<?php echo plugin_dir_url(__FILE__).'js/template.js'?>"></script>
	
	<script src="<?php echo plugin_dir_url(__FILE__).'libs/swiper/js/swiper.min.js'?>"></script>
	<script src="<?php echo plugin_dir_url(__FILE__).'js/polyfills.js'?>"></script> 
	<script src="<?php echo plugin_dir_url(__FILE__).'js/lodash.js'?>"></script>	

</div>


