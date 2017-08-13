<?php

namespace App\Controllers;

use Twig_Loader_Filesystem;

class BaseController {

	// protegida para que sea usada por las clases hijas
	protected $templateEngine;

	public function __construct(){
		// generamos el loader de Twig indicandole las rutas de busqueda
		// la ruta debe ser relativa al index.php del frontcontroller
		$loader = new Twig_Loader_Filesystem('../views');
		$this->templateEngine = new \Twig_Environment($loader,[
			'debug' => true, // traer los errores
			'cache' => false // deshabilita la cache
		]);

		// helper para extender funcionalidad en las URLS
		$this->templateEngine->addFilter(new \Twig_SimpleFilter('url', function($path){
			// nombre del filtero - $path -> ruta del elemento
			return BASE_URL . $path; 
			// constante del FrontController
		}));	


	}

	public function render($file,$data = []){
		return $this->templateEngine->render($file,$data);	
	}



}