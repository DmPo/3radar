<?php

namespace App;

/**
 * Pixie dependency container
 *
 * @property-read \PHPixie\DB $db Database module
 * @property-read \PHPixie\ORM $orm ORM module
 * @property-read \PHPixie\Auth $auth Auth module
 * @property-read \PHPixie\Email $email Email module
 * @property-read \PHPixie\Haml $haml Haml module
 */
class Pixie extends \PHPixie\Pixie {

	protected $modules = array(
		'db' => '\PHPixie\DB',
		'auth' => '\PHPixie\Auth',
		'email' => '\PHPixie\Email',
		'haml' => '\PHPixie\Haml',
		'orm' => '\PHPixie\ORM'
	);

	protected function after_bootstrap() {
	}
//    public function handle_exception($exception)
//    {
//        $view = $this->view('debug');
//        $view->exception = $exception;
//        if ($exception instanceof \PHPixie\Exception\PageNotFound) {
//            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
//        } else {
//            $http_status = "503 Service Temporarily Unavailable";
//            header($_SERVER["SERVER_PROTOCOL"] . ' ' . $http_status);
//            header("Status: " . $http_status);
//        }
//    }
}
