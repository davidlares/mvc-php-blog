<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPost;
use Sirius\Validation\Validator;

class PostController extends BaseController {

	public function getIndex(){

		// global $pdo;
		// // admin/posts or admin/posts/index
		// $query = $pdo->prepare('SELECT * FROM blog_posts ORDER BY id DESC');
		// $query->execute();
		// $blogPosts = $query->fetchAll(\PDO::FETCH_ASSOC);	
		$blogPosts = BlogPost::all();
		return $this->render('admin/posts.twig',['blogPosts' => $blogPosts]);
		//return render('../views/admin/index.php');
	}

	public function getCreate(){
		global $pdo;
		// admin/posts/create
		return $this->render('admin/insert-post.twig');
	}

	public function postCreate(){
		// global $pdo;
		// //admin/posts/create - modo POST
		// $sql = "INSERT INTO blog_posts (title, content) VALUES (:title,:content)";
		// $query = $pdo->prepare($sql);
		// $result = $query->execute([
		// 	'title' => $_POST['title'],
		// 	'content' => $_POST['content']
		// ]);

		// validando usando siriusPHP
		$errors = [];
		$result = false;

		$validator = new Validator();
		$validator->add('title','required');
		$validator->add('content','required');

		if($validator->validate($_POST)){

			$blogPost = new BlogPost([
			'title' => $_POST['title'],
		 	'content' => $_POST['content']
		 	]);

			if($_POST['img']){
				$blogPost->img_url = $_POST['img'];
			}
			
			$blogPost->save();
			$result = true;
		
		} else {
			$errors = $validator->getMessages();
		}

		
		return $this->render('admin/insert-post.twig', ['result' => $result, 'errors' => $errors]);
	}

	public function getEdit($id){

		$blogPost = BlogPost::find($id);
		return $this->render('admin/update-post.twig',['blogPost' => $blogPost]);
	}

	public function postEdit() {

		$id = $_POST['id'];
		$blogPost = BlogPost::find($id);

		if(isset($blogPost)) {

			$errors = [];
			$result = false;

			$validator = new Validator();
			$validator->add('title','required');
			$validator->add('content','required');

			if($validator->validate($_POST)){

				$blogPost->title = $_POST['title'];
			 	$blogPost->content = $_POST['content'];

				if($_POST['img']){
					$blogPost->img_url = $_POST['img'];
				}
				
				$blogPost->save();
				$result = true;
			
			} else {
				$errors = $validator->getMessages();
			}
				header("Location: " .BASE_URL.'/admin/posts');
				//return $this->render('admin/update-post.twig', ['result' => $result, 'errors' => $errors]);

		} else {
			header("Location: " .BASE_URL.'/admin/posts');
		}

	}

	public function getDelete($id){
		
		$blogPost = BlogPost::find($id);
		if(isset($id)){
			BlogPost::destroy($id);
			//return 'success';
			header("Location: " .BASE_URL.'admin/posts');
		}
	}
}