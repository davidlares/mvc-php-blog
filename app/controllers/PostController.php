<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\BlogPost;

class PostController extends BaseController {

	public function getPost($id){
		
		$blogPost = BlogPost::find($id);
		return $this->render('post.twig', ['blogPost' => $blogPost]);
	}

}