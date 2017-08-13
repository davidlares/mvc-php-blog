<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\BlogPost;

class IndexController extends BaseController {

	public function getIndex(){

		// global $pdo; // esta variable es tomada desde el scope superior

		// $query = $pdo->prepare('SELECT * FROM blog_posts ORDER BY id DESC');
		// $query->execute();
		// $blogPosts = $query->fetchAll(\PDO::FETCH_ASSOC);
		//include '../views/index.php';	
		//return $this->render('../views/index.php', ['blogPosts' => $blogPosts]);
		$blogPosts = BlogPost::query()->orderBy('id','desc')->get();
		return $this->render('index.twig', ['blogPosts' => $blogPosts]);
	}

}