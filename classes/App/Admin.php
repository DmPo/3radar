<?php

namespace App;

/**
 * Base admin controller
 *
 * @property-read \App\Pixie $pixie Pixie dependency container
 */
class Admin extends \PHPixie\Controller
{

    protected $view;
    protected $do;

    public function before()
    {
        $url = $this->request->url(true);

        if ($this->pixie->auth->user() && $this->pixie->auth->user()->staff == 1) {
            $this->view = $this->pixie->view('admin');
            $this->view->folder = 'Admin';
            $this->view->title = '';
            $do = $this->do = $this->request->param('operation') ? '/' . $this->request->param('operation') : '/list';
            $dir = $this->request->param('action');
            $this->view->subview = "$dir$do";
        } else
            $this->redirect("/login?href=$url");
    }

    /**
     *
     */
    public function after()
    {
        $this->response->body = $this->view->render();
    }

    /**
     * @param int $length
     * @return string
     */
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param string $action
     * @throws \PHPixie\Exception\PageNotFound
     */
    public function run($action)
    {
        $do = $this->do = $this->request->param('operation') ? "_" . $this->request->param('operation') : '';
        $action = $action . $do;

        if (!method_exists($this, $action))
            throw new \PHPixie\Exception\PageNotFound("Method {$action} doesn't exist in " . get_class($this));

        $this->execute = true;
        $this->before();
        if ($this->execute)
            $this->$action();
        if ($this->execute)
            $this->after();
    }

}