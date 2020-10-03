<?php

// Se define la funcionalidad del area de administración
class Try_on_sck_Admin
{

    // Identificador del plugin
    private $plugin_name;

    // Versión del plugin
    private $version;

    // Se inicializa la clase con sus valores
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    // Se registra la hoja de estilos para el area de administración
    public function enqueue_styles()
    {

        wp_enqueue_style('thickbox');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/admin.css', array() , $this->version, 'all');

    }

    // Se registra el JavaScript necesario para el área de administración
    public function enqueue_scripts()
    {

        wp_enqueue_script('jquery');
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/admin.js', array(
            'jquery'
        ) , $this->version, false);
        wp_enqueue_script("load_core_function", plugin_dir_url(__FILE__) . 'js/load_functions.js', $this->version, false);
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');

    }

    // Añade el menu a la barra y le pone nombre y logo
    public function add_menu()
    {
        add_menu_page("SCK Probador", "SCK Probador", "manage_options", "tryonmenu", 'show_admin_menu_sck', $icon_url = plugin_dir_url(__FILE__) . 'css/logo.svg', $position = null);
        add_action('add_meta_boxes', array(
            $this,
            'add_meta_boxes_transparent_image'
        ));
        add_action('save_post', array(
            $this,
            'save_transparent_image'
        ));
    }

    // Guarda la imagen
    public function save_transparent_image($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['case_study_bg_nonce']) && wp_verify_nonce($_POST['case_study_bg_nonce'], 'case_study_bg_submit')) ? 'true' : 'false';

        // Dependiendo del estado de guardado sale del script
        if ($is_autosave || $is_revision || !$is_valid_nonce)
        {
            return;
        }

        // Comprueba la entrada y la desinfecta si es necesario
        if (isset($_POST['tryon-glasses']))
        {
            update_post_meta($post_id, 'try_on_image_rvgud', $_POST['tryon-glasses']);
        }
    }

    //Caja con opciones para el plugin, dentro de woocomerce. En la seccion de productos.
    public function add_meta_boxes_transparent_image($post_types)
    {
        $post_types = array(
            'product'
        );
        global $post;
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            $product = wc_get_product($post->ID);
            if ($post->post_type == 'product')
            {
                add_meta_box('wf_child_letters', __('Probador SCK', 'woocommerce') , array(
                    $this,
                    'render_meta_box_content'
                ) , $post_types, 'advanced', 'high');
            }
        }

    }

    // Opciones disponibles en la caja del plugin, dentro del producto.
    public function render_meta_box_content()
    {
        global $post;
        $url = get_post_meta($post->ID, 'try_on_image_rvgud', true); ?>
        <input hidden="hidden" id="tryon-glasses" name="tryon-glasses" type="text" value="<?php echo $url;?>"  style="width:400px;" />

        <?php if ($url == null || $url == '')
        { ?>
            <img src="<?php echo $url; ?>" style="width:200px;display:none;" id="picsrc" />
            <a style="cursor: pointer;" onclick="sck_upload_image();" id="my_upl_button">Poner imagen</a>
            <?php
        }
        else
        { ?>
            <img src="<?php echo $url; ?>" style="width:200px;" id="picsrc" />
            <a style="cursor: pointer;" onclick="sck_upload_image();" id="my_upl_button">Cambiar</a>
            <a style="cursor: pointer;" onclick="sck_remove_image();">Quitar</a>
            <?php
        }

        ?>
        <input type="text" id="tryon-glasses-src" name="tryon-glasses-src" type="text" value="<?php echo '/wp-content' .end(explode('/wp-content', $url));?>"  style="width:400px;" />
        <?php
    }
}

// Contenido del panel de administrador
function show_admin_menu_sck()
{
    include_once plugin_dir_path(__FILE__) . 'partials/admin-display.php';
}
?>
