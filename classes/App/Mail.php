<?php


namespace App;


use Mailgun\Mailgun;

class Mail
{
    private $mailgun_conf;
    private $mg;
    private $domain;

    function __construct()
    {
        $this->mailgun_conf = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('../mailgun.yml'));
        $this->domain = $this->mailgun_conf['domain'];
        $this->mg = new Mailgun($this->mailgun_conf['api_key']);
        return $this->mg;

    }

    /**
     * @return Mailgun
     */
    public static function MailGun()
    {
        $mailgun_conf = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('../mailgun.yml'));
        return new Mailgun($mailgun_conf['api_key']);
    }

    /**
     * send message
     * @param $to
     * @param $subject
     * @param $text
     * @param string $from
     */
    public static function sendMessage($to, $subject, $text, $from = 'info@3radar.org')
    {
        $mailgun_conf = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('../mailgun.yml'));
        $domain = $mailgun_conf['domain'];
        $mg = new Mailgun($mailgun_conf['api_key']);
        # Now, compose and send your message.
        $mg->sendMessage($domain, array('from' => $from,
            'to' => $to,
            'subject' => $subject,
            'html' => $text));
    }
}