<?php

// Registra todos los hooks del plugin, para llevar control de sus acciones.
class Try_on_sck_Loader {

	// Array de acciones registradas con WordPress
	protected $actions;

	// Array de filtros registradas con WordPress
	protected $filters;

	// Inicializa las acciones y filtros
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	// Añadir una nueva accion
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	// Añadir un nuevo filtro
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	// Se utiliza para registrar las acciones y hooks dentro de una unica colleción
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	// Registra los filtros y acciones con WordPress
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

}
