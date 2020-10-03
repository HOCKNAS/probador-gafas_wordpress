<?php

//Carga y define los archivos de internacionalización para la traducción.
class Try_on_sck_i18n {

	// Carga el texto para su traducción
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'Try_on_sck',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
