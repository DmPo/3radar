<?php

namespace App;

/**
 * Base controller
 *
 * @property-read \App\Pixie $pixie Pixie dependency container
 */
class Page extends \PHPixie\Controller
{

    protected $view;
    protected $user;

    public function before()
    {
        $this->view->user = $this->user;
    }

    public function after()
    {
        $this->response->body = $this->view->render();
    }

    public function run($action)
    {
        $full_action = 'action_' . $action;
        $public_actions = ['reg', 'auth', 'index'];
        $this->user = $this->pixie->auth->user();
        if (!method_exists($this, $full_action))
            throw new \PHPixie\Exception\PageNotFound("Method {$full_action} doesn't exist in " . get_class($this));
        // user ability
        if (!$this->user && !in_array($action, $public_actions))
           return $this->redirect('/auth');
        // auto include subview
        $this->view = $this->pixie->view('main');
        $this->view->subview = $action;

        $this->execute = true;
        $this->before();
        if ($this->execute)
            $this->$full_action();
        if ($this->execute)
            $this->after();
    }

}
