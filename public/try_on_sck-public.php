<?php

// Interfaz publica del plugin
class Try_on_sck_Public {

	// identificador del plugin
	private $plugin_name;

	// Versión
	private $version;

	// Se inicializa la clase con los valores 
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

    }

	public function start(){
			add_action( 'woocommerce_single_product_summary', 'show_button', 32 ,0 );
			add_action( 'woocommerce_after_shop_loop_item', 'show_loop_button', 10);
			add_action( 'woocommerce_after_shop_loop', 'show_try_on_popup', 10);
	}

    // Se registra la hoja de estilos
	public function enqueue_styles() {
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'swiper', plugin_dir_url( __FILE__ ) . 'css/swiper.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'jquery', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );
		global $wpdb;
		$bootstrap_enable=$wpdb->get_results ( "
		SELECT value 
		FROM  ".$wpdb->prefix."sck_options where name='include_bootstrap'" );
		if(count($bootstrap_enable) != 0 && $bootstrap_enable[0]->value == 'yes'){
			wp_enqueue_style( $this->plugin_name.'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap/css/bootstrap.css', array(), $this->version, 'all' );
		 }		
	}

    // Se registra el JavaScript necesario
	public function enqueue_scripts() {

		wp_dequeue_script( 'jquery' );
		wp_enqueue_script('jquery_M',get_site_url().'/wp-includes/js/jquery/jquery.js',array(),false,true);
		global $wpdb;
		$bootstrap_enable=$wpdb->get_results ( "
		SELECT value 
		FROM  ".$wpdb->prefix."sck_options where name='include_bootstrap'" );
		if(count($bootstrap_enable) != 0 && $bootstrap_enable[0]->value == 'yes'){
			wp_enqueue_script( $this->plugin_name.'bootstrapjs', plugin_dir_url( __FILE__ ) . 'css/bootstrap/js/bootstrap.js', array( 'jquery' ));
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name.'jqueryuitouchjs', plugin_dir_url( __FILE__ ) . 'js/jquery.ui.touch-punch.min.js',array( 'jquery-ui-mouse','jquery-ui-widget' ));
		wp_enqueue_script("load_core_functions", plugin_dir_url(__FILE__) . 'js/load_functions.js', false ,true);
		
	}

}

// Boton Probar principal
function show_button(){
	
    global $product; 
    global $post;
    $tryOnImgUrl=get_post_meta($post->ID,'try_on_image_rvgud', true); 
    $tryOnSideImgUrl=get_post_meta($post->ID,'try_on_side_image_rvgud', true); 
    $id = $product->get_id();
    $scode="[add_to_cart_url id='".$id."']";
    $scode = do_shortcode("[add_to_cart_url id='".$id."']");
    if($tryOnImgUrl !=null || $tryOnImgUrl !=''){
    	?>
    	<script>
    	function set_properties_glasses(name,tryon_url,try_onside_url,id){
    			document.getElementById('galssimage').value=tryon_url;
    			tryOnImgUrl=tryon_url;
    			tryOnSideImgUrl=try_onside_url;
    			document.getElementById('addtocartlink').href=id;
    			if(tryOnSideImgUrl==''){
    			var side_btn = document.getElementById('side_btn');
				if (side_btn === null){

				}
				else{
					var side_btnjquery = $('#side_btn');
					side_btnjquery.css("display","none");
				}
			}
    			
    	}
    	</script>
    	<button type="button" class="btn btn-primary" onclick="set_properties_glasses('Gafas','<?php echo $tryOnImgUrl;?>','<?php echo $tryOnSideImgUrl;?>','<?php echo $scode;?>');" data-toggle="modal" data-target="#TryOnModal">Probar</button>
    	<?php
    	include_once plugin_dir_path(__FILE__).'partials/public-display.php';
    }
   
}

// Mostrar pop-up
function show_try_on_popup(){
	global $file_path;
    include_once plugin_dir_path(__FILE__).'partials/public-display.php';
    
   
}


// Boton Probar auxiliar
function show_loop_button(){
	global $product; 
    global $post;
    $tryOnImgUrl=get_post_meta($post->ID,'try_on_image_rvgud', true); 
    $tryOnSideImgUrl=get_post_meta($post->ID,'try_on_side_image_rvgud', true); 
    $id = $product->get_id();
    $scode="[add_to_cart_url id='".$id."']";
    $scode = do_shortcode("[add_to_cart_url id='".$id."']");
    if($tryOnImgUrl !=null || $tryOnImgUrl !=''){
    	?>
    	<script>
    	function set_properties_glasses(name,tryon_url,try_onside_url,id){
    			document.getElementById('galssimage').value=tryon_url;
    			tryOnImgUrl=tryon_url;
    			tryOnSideImgUrl=try_onside_url;
    			productid=id;
    			document.getElementById('addtocartlink').href=id;
    			if(tryOnSideImgUrl==''){
    			var side_btn = document.getElementById('side_btn');
				if (side_btn === null){

				}
				else{
					var side_btnjquery = $('#side_btn');
					side_btnjquery.css("display","none");
				}
			}
    	}
    	</script>
    	<button type="button" class="btn btn-primary" onclick="set_properties_glasses('Gafas','<?php echo $tryOnImgUrl;?>','<?php echo $tryOnSideImgUrl;?>','<?php echo $scode;?>');" data-toggle="modal" data-target="#TryOnModal">Probar</button>
    	<?php
    }
}
