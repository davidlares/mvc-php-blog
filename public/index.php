<?php
	// nuestro nuevo front Controller
	include_once '../config.php';

	// traemos el autoload de vendor
	require_once '../vendor/autoload.php';

	use Phroute\Phroute\RouteCollector;

	session_start();

	// inicializar el sistema de errores de PHP
	ini_set('display_errors',1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL); // constante PHP


	// constante para llamar el BASE_URL 
	$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME']);
	$baseUrl = 'http://'. $_SERVER['HTTP_HOST']. $baseDir;
	define('BASE_URL', $baseUrl); // esta es la constante

	// asignacion y carga de variables de entorno 
	$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
	$dotenv->load();

	// configuracion de Eloquent

	use Illuminate\Database\Capsule\Manager as Capsule;

	$capsule = new Capsule;

	$capsule->addConnection([
	    'driver'    => 'mysql',
	    'host'      => getenv('DB_HOST'),
	    'database'  => getenv('DB_NAME'),
	    'username'  => getenv('DB_USER'),
	    'password'  => getenv('DB_PASS'),
	    'charset'   => 'utf8',
	    'collation' => 'utf8_unicode_ci',
	    'prefix'    => '',
	]);

	// uso de manera global
	$capsule->setAsGlobal();
	// inicializar el ORM
	$capsule->bootEloquent();


	// maneja a mandar a llamar las paginas
	$route = $_GET['route'] ?? '/';	// operador null, si existe Route o es Base

	// este es nuestro router endogeno, usando switch (no sirve mucho
	// para atrapar POST Requests) y otros datos

	// switch ($route) {
	// 	case '/':
	// 		require '../index.php';
	// 		break;
		
	// 	case '/admin':
	// 		require '../admin/index.php';
	// 		break;

	// 	case '/admin/posts':
	// 		require '../admin/posts.php';
	// 		break;
	// 	default:
	// 		# code...
	// 		break;
	// }

	// esto va a funcionar de la sig manera
	// public/index.php?route=/admin/posts (por ejemplo)


	// function render($fileName, $params = []){
	// 	ob_start(); // metodo para omitir cualquier salida del objeto
	// 	extract($params);
	// 	include $fileName;
	// 	return ob_get_clean(); // regresar el bloque previo, en una cadena
	// }

	// el rendering va a ser con Twig - ver BaseController

	// USANDO PHROUTE
	$router = new RouteCollector();

	// $router->get('/', function() use ($pdo) {
	// 		$query = $pdo->prepare('SELECT * FROM blog_posts ORDER BY id DESC');
	// 		$query->execute();
	// 		$blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);
	// 		//include '../views/index.php';	
	// 		return render('../views/index.php', ['blogPosts' => $blogPosts]);
	// 		// trae todos los registros de la consulta
	// });


	// $router->get('/admin', function(){
	// 	return render('../views/admin/index.php');
	// });

	// $router->get('/admin/posts', function() use ($pdo) {
	// 	$query = $pdo->prepare('SELECT * FROM blog_posts ORDER BY id DESC');
	// 	$query->execute();
	// 	$blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);	
	// 	return render('../views/admin/posts.php',['blogPosts' => $blogPosts]);
	// });


	// $router->get('/admin/posts/create', function() {
	// 	return render('../views/admin/insert-post.php');
	// });

	// $router->post('/admin/posts/create', function() use ($pdo) {

	// 		$sql = "INSERT INTO blog_posts (title, content) VALUES (:title,:content)";
	// 		$query = $pdo->prepare($sql);
	// 		$result = $query->execute([
	// 			'title' => $_POST['title'],
	// 			'content' => $_POST['content']
	// 		]);

	// 	return render('../views/admin/insert-post.php', ['result' => $result]);

	// });

	// AGREGAMOS UN FILTRO (MIDDLEWARE) PARA PROTEGER RUTAS
	$router->filter('auth',function(){
		if(!isset($_SESSION['userID'])){
			header('Location: '. BASE_URL . 'auth/login');
			return false;
		}
	});

	// AHORA USAMOS Controllers

	$router->group(['before' => 'auth'], function($router){
		$router->controller('/admin', App\Controllers\Admin\IndexController::class);
		$router->controller('/admin/posts', App\Controllers\Admin\PostController::class);
		$router->controller('/admin/users', App\Controllers\Admin\UserController::class);
	});

	$router->controller('/', App\Controllers\IndexController::class);
	$router->controller('/auth', App\Controllers\AuthController::class);
	
	$router->get('/post/{id}', [App\Controllers\PostController::class,'getPost']);
	// $router->get('/admin/posts', function() use ($pdo) {
	// 	$query = $pdo->prepare('SELECT * FROM blog_posts ORDER BY id DESC');
	// 	$query->execute();
	// 	$blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);	
	// 	return render('../views/admin/posts.php',['blogPosts' => $blogPosts]);
	// });
	// App\Controllers\IndexController::class - trae la instancia de la clase

	// el dispatcher - objejo que toma la ruta y llama al metodo que necesita
	$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
	$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

	// verbo HTTP + ruta
	echo $response;