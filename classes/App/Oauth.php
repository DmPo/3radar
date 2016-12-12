<?php


namespace App;
putenv('GOOGLE_APPLICATION_CREDENTIALS=/client_secret.json');
use Facebook\Facebook;

class Oauth
{
    protected $settings;
    public $facebook;

    function __construct()
    {
        $this->settings = new Settings();
        $this->fb = $this->settings->get_fb();
        $this->gl = $this->settings->get_gl();
    }

    /**
     * @return Facebook
     */
    public function Facebook()
    {
        return new Facebook([
            'app_id' => $this->fb['app_id'],
            'app_secret' => $this->fb['app_secret'],
            'default_graph_version' => $this->fb['default_graph_version'],
        ]);
    }

    /**
     * @return \Google_Client
     */
    public function Google()
    {
        $client =  new \Google_Client();
        $client->setAuthConfig('../client_secret.json');
        $client->addScope(\Google_Service_Oauth2::USERINFO_EMAIL);
        $client->addScope(\Google_Service_Oauth2::USERINFO_PROFILE);
        $client->setRedirectUri('http://civicos.net/gl_oauth');
        return $client;
    }
}
