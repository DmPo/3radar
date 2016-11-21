<?php

namespace App\Controller;

class Pages extends \App\Page
{

    public function action_index()
    {
        $this->view = $this->pixie->view('hello');
        $this->view->message = 'Have fun coding';
    }

    public function action_auth()
    {
        if ($this->pixie->auth->user())
            return $this->redirect('/me');
        if ($this->request->method == 'POST') {
            $email = strtolower($this->request->post('email'));
            $password = $this->request->post('password');
            $logged = $this->pixie->auth
                ->provider('password')
                ->login($email, $password, true);
            if ($logged) {
                $user = $this->pixie->auth->user();
                $user->sign_in_count++;
                $user->last_sign_in = $this->pixie->db->expr('now()');
                $user->save();
                return $this->redirect('/me');
            }
            else $this->view->error = 'Не вірний email чи пароль!';
        }
    }

    public function action_reg()
    {

        $recaptcha = new \ReCaptcha\ReCaptcha('6Le_TAwUAAAAAFPKmOdFzsauc7VGFiZ8oarXRZ_E');
        $resp = $recaptcha->verify($this->request->post('g-recaptcha-response'));
        if ($resp->isSuccess()) {
            $user = $this->pixie->orm->get('user');
            $user->first_name = $this->request->post('first_name');
            $user->last_name = $this->request->post('last_name');
            $user->phone = $this->request->post('phone');
            $user->email = $this->request->post('email');
            $user->password = $this->pixie->auth->provider('password')->hash_password($this->request->post('password'));
            $user->save();
            $this->pixie->auth
                ->provider('password')
                ->login($this->request->post('email'), $this->request->post('password'), true);
            $this->redirect('/me');
        } else {
            $errors = $resp->getErrorCodes();
            $this->redirect('/auth');
        }

    }


    public function action_me()
    {

    }

    public function action_logout()
    {
        $this->pixie->auth->logout();
        $this->redirect('/');
    }

    public function action_new_campaign()
    {
    }

    public function action_campaigns()
    {
        if (!$this->request->param('id')) {
            $this->view->single_company = false;
            $this->view->campaigns = $this->pixie->orm->get('campaign')->find_all();
        } else {
            $this->view->campaigns = [$this->pixie->orm->get('campaign', $this->request->param('id'))];
            $this->view->news = '';
            $this->view->single_company = true;

        }
    }
}