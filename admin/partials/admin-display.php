<?php
// Esta es la interfaz del área de administrador
global $wpdb;
if (isset($_POST['bootstrap_enable']))
{
    $bootstrap_enable = $_POST['bootstrap_enable'];
    $tableName = $wpdb->prefix . 'sck_options';
    if ($bootstrap_enable == 'on')
    {
        $checked = "checked";
        $wpdb->update($tableName, array(
            "value" => "yes"
        ) , array(
            'name' => "include_bootstrap"
        ) , array(
            '%s'
        ) , array(
            '%s'
        ));
    }
    else
    {
        $checked = "";
        $wpdb->update($tableName, array(
            "value" => "no"
        ) , array(
            'name' => "include_bootstrap"
        ) , array(
            '%s'
        ) , array(
            '%s'
        ));
    }
}
else
{
    $bootstrap_enable = $wpdb->get_results("
    SELECT value 
    FROM  " . $wpdb->prefix . "sck_options where name='include_bootstrap'");

    if ($bootstrap_enable[0] != null && $bootstrap_enable[0]->value == 'yes')
    {
        $checked = "checked";
    }
    else
    {
        $checked = "";
    }
} ?>


<html>
	<head>
		<style>
        
        /* Contenedor */
        .container {
            border-radius: 5px;
            padding: 20px;
        }	

        /* Titulo */
        h2 {
            font-size: 30px;
            margin-bottom: 20px;
            font-weight: 400;
            color: #312f2b;
            line-height: 1.1em;
            font-family: 'Open Sans', Arial, sans-serif;
        }

        .img {
            background-image: url('/wp/wp-content/plugins/plugin-try-on/admin/css/logo.svg');
            background-repeat: no-repeat;
            width: 640px;
            height: 427px;
            background-color: #fff;
        }

		</style>

        <script>

            function update_text(checkbox){
                if (checkbox.checked)
                {
                    document.getElementById("textbox").value = "on";
                }
                else{
                    document.getElementById("textbox").value = '';
                }
            }
        </script>
	</head>
<body>

<div class="container" style="background-color: #fff;">
    <h2>
    Panel Admin - SCK Probador 
    </h2>

    <div class="img" >

    </div>
        
</div>

</body>
</html>
