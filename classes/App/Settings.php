<?php

namespace App;


class Settings
{
    protected $settings;

    function __construct()
    {
        $this->settings = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('../settings.yml'));
        $this->fb = $this->get_fb();
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        return $this->settings;
    }


    /**
     * @return mixed
     */
    public function get_fb()
    {
        return $this->settings['fb_credentials'];
    }
    /**
     * @return mixed
     */
    public function get_gl()
    {
        return $this->settings['gl_credentials'];
    }
}