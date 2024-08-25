<?php
require_once 'vendor/autoload.php';

class AppView {
	static $instance = null;
	static $twig = null;

	public $templatesPath = "templates"; 
	public $cachePath = "cache"; 

	/**
	 * Helper function to load+render twig files
	 */
	public static function render($name, $params = array()) {
		if (static::$instance == null) {
			static::$instance = new self();
		}

		if(static::$twig == null){
			$loader = new \Twig\Loader\FilesystemLoader(static::$instance->templatesPath);
			static::$twig = new \Twig\Environment($loader, [
				'cache' => static::$instance->cachePath,
			]);
			static::$twig->addGlobal('session', $_SESSION);
		}

		if ($name) {
			$template = static::$twig->load($name);
			echo $template->render($params);
		}
	}
}
