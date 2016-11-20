<?php

namespace App;

/**
 * API controller
 *
 * @property-read \App\Pixie $pixie Pixie dependency container
 */
class API extends \PHPixie\Controller
{
    protected $data;
    protected $user;
    protected $json_request;

    public function before()
    {
        $this->json_request = json_decode(file_get_contents("php://input"));
        $this->data = new \stdClass();
        $this->response->add_header('Content-Type: application/json; charset=utf-8');
        $this->response->body = json_encode($this->data);
    }

    public function after()
    {
        $this->response->add_header('Content-Type: application/json; charset=utf-8');
        $this->response->body = json_encode($this->data);
    }


    public function run($action)
    {
        $pre_action = $this->request->method;
        $full_action = $pre_action . '_' . $action;
        $public_actions = ['reg', 'auth', 'check_email', 'campaigns_markers'];
        $this->data = new \stdClass();

        $this->user = $this->pixie->auth->user();
        if (!$this->user && !in_array($action, $public_actions)) {
            header($_SERVER["SERVER_PROTOCOL"] . "  401 Unauthorized", true, 404);
            $this->response->add_header('Content-Type: application/json; charset=utf-8');
            $this->data->error = 'Unauthorized!';
            $this->response->body = json_encode($this->data);
            return;
        }
        if (!method_exists($this, $full_action)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            $this->response->add_header('Content-Type: application/json; charset=utf-8');
            $this->data->error = $action . ' not found!';
            $this->response->body = json_encode($this->data);
            return;
        }
        $this->execute = true;
        $this->before();
        if ($this->execute)
            $this->$full_action();
        if ($this->execute)
            $this->after();
    }

}