<?php

namespace App\Controller;

use App\Mail;

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

        $fb = $this->oauth->Facebook();
        $gl = $this->oauth->Google();
        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // optional
        $this->view->fb_login = $helper->getLoginUrl('http://civicos.net/fb_oauth', $permissions);
        $this->view->gl_login = $gl->createAuthUrl();
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
            } else $this->view->error = 'Wrong email or password.';
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


    public function action_fb_oauth()
    {
        $code = $this->request->get('code');
        $fb = $this->oauth->Facebook();
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            // Logged in!

            $fb_user = $fb->get('/me?fields=id,name,email', $accessToken)->getDecodedBody();
            $user = $this->pixie->orm->get('user')->where('email', $fb_user['email'])->find();
            if (!$user->loaded()) {
                $full_name = explode(" ", $fb_user['name']);
                $user = $this->pixie->orm->get('user');
                $user->first_name = $full_name[0];
                $user->last_name = $full_name[1];
                $user->email = $fb_user['email'];
                $user->oauth_uid = $fb_user['id'];
                $user->password = 'password no set';
                $user->oauth_token = $accessToken;
                $user->oauth_provider = 'facebook';
                $user->save();
            }
            $this->pixie->auth
                ->provider('password')
                ->set_user($user);
            return $this->redirect('/me');
        }
    }

    public function action_gl_oauth()
    {
        $gl = $this->oauth->Google();
        $gl->authenticate($_GET['code']);
        $access_token = $gl->getAccessToken();
        $gl->setAccessToken($access_token);
        $gl_user = new \Google_Service_Oauth2($gl);
        $gl_user =  $gl_user->userinfo->get();
        $user = $this->pixie->orm->get('user')->where('email', $gl_user['email'])->find();
        if (!$user->loaded()) {
            $user = $this->pixie->orm->get('user');
            $user->first_name = $gl_user['givenName'];
            $user->last_name = $gl_user['familyName'];
            $user->email = $gl_user['email'];
            $user->oauth_uid = $gl_user['id'];
            $user->social_link = $gl_user['link'];
            $user->password = 'password no set';
            $user->oauth_provider = 'google';
            $user->save();
        }
        $this->pixie->auth
            ->provider('password')
            ->set_user($user);
        return $this->redirect('/me');
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


    public function action_recovery()
    {
        $this->view->title = '- Password recovery';
        if ($this->pixie->auth->user())
            $this->redirect('/');
        if ($this->request->param('id') == 'error_token')
            $this->view->message = 'Wrong token';
        if ($this->request->method == 'POST') {
            $email = $this->request->post('email');
            $user = $this->pixie->orm->get('user')->where('email', $email)->find();
            if ($user->loaded()) {
                $token = $this->pixie->random_string(55);
                $user->reset_token = $token;
                $user->token_created_at = $this->pixie->db->expr('now()');
                $user->save();
                $html = "<h2>Password reset</h2>" .
                    "<p>follow <a href='http://civicos.net/newpass/{$token}'>the link</a> </p>" .
                    "<p>click at : <a href='http://civicos.net/newpass/{$token}'>link</a> </p>" .
                    "<p>http://civicos.net/newpass/{$token}</p>";
                Mail::sendMessage($user->email, 'Password reset', $html);
                $this->view->message = 'Emailed';
            } else {
                $this->view->error = 'No such user found.';
            }
        }
    }

    public function action_newpass()
    {
        if ($this->pixie->auth->user())
            $this->redirect('/');
        $token = $this->request->param('id');
        $user = $token ?  $this->pixie->orm->get('user')->where('reset_token', $token)->find() : false;

        if (!($token && $user->loaded())) {
            return $this->redirect('/recovery/error_token');
        }

        if ($this->request->method == 'POST') {
            $user->password = $this->pixie->auth->provider('password')->hash_password($this->request->post('password'));
            $user->reset_token = $this->pixie->db->expr('null');
            $user->save();
            $this->pixie->auth
                ->provider('password')
                ->set_user($user);
            return $this->redirect("/me");
        }
    }
}
