<?php
/**
 * Created by PhpStorm.
 * User: dmat
 * Date: 17.11.16
 * Time: 15:01
 */

namespace App\Controller;


use Mailgun\Mailgun;

class Api extends \App\API
{

    public function GET_users()
    {
        $id = $this->request->param('id');
        $user = $this->pixie->db->query('select')
            ->fields('id', 'first_name', 'last_name', 'phone', 'staff')
            ->table('users');
        if ($id > 0)
            $user->where('id', $id);

        $this->data->user = $user->execute()->as_array();
    }

    public function GET_regions()
    {
        $regions = $this->pixie->orm
            ->get('region')
            ->order_by('name')
            ->find_all()
            ->as_array(true);
        $this->data->regions = $regions;
    }

    public function GET_districts()
    {
        // ::/api/districts/?region_id=2
        $allowed = ['region_id', 'id'];
        $model = $this->pixie->db->query('select')->table('districts');
        foreach ($this->request->get() as $param => $key)
            if (in_array($param, $allowed) and intval($key))
                $model->where($param, $key);
        $model->order_by('name');
        $this->data->districts = $model->execute()->as_array(true);

    }

    public function GET_councils()
    {
        $model = $this->pixie->db->query('select')->table('councils');
        $allowed = ['district_id', 'id'];
        foreach ($this->request->get() as $param => $key)
            if (in_array($param, $allowed) and intval($key))
                $model->where($param, $key);
        $model->order_by('name');
        $this->data->councils = $model->execute()->as_array(true);

    }

    public function POST_user()
    {
        $user = $this->pixie->orm->get('user');
    }

    public function POST_new_campaign()
    {
        $user_campaign = $this->pixie->orm->get('campaign')->where('author_id', $this->user->id)->where('council_id', $this->json_request->council_id)->find();

        if (!$user_campaign->loaded()) {
            $campaign = $this->pixie->orm->get('campaign');
            $campaign->council_id = $this->json_request->council_id;
            $campaign->reason = $this->json_request->reason;
            if (isset($this->json_request->description))
                $campaign->description = $this->json_request->description;
            if (isset($this->json_request->literature))
                $campaign->literature = $this->json_request->literature;
            if (isset($this->json_request->training))
                $campaign->training = $this->json_request->training;
            if (isset($this->json_request->subscribing))
                $campaign->subscribing = $this->json_request->subscribing;
            $campaign->author_id = $this->user->id;
            $campaign->save();
            $this->data = $campaign->as_array(true);
        } else {
            $this->data = $user_campaign->as_array(true);
        }


    }

    public function POST_auth()
    {
        if ($this->pixie->auth->user())
            return $this->data = $this->GET_me();
        if (isset($this->json_request->email) && isset($this->json_request->password)) {
            $logged = $this->pixie->auth
                ->provider('password')
                ->login(strtolower($this->json_request->email), $this->json_request->password, true);
            if ($logged) return $this->data = $this->GET_me();

        }
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
        $this->data->error = 'Невірний email або пароль';
    }

    public function GET_me()
    {
        return $this->data = $this->pixie->auth->user() ? $this->pixie->auth->user()->query()
            ->fields('id', 'email', 'first_name', 'last_name', 'phone')
            ->execute()
            ->as_array(true)[0] : null;
    }

    public function GET_logout()
    {
        $this->pixie->auth->logout();
        $this->data->user = null;
    }

    public function GET_check_email()
    {
        $this->data->free = !$this->pixie->orm->get('user')
            ->where('email', 'like', $this->request->get('email'))
            ->find()->loaded();
    }

    public function GET_update_districts()
    {
        $districts = $this->pixie->orm->get('district')
            ->where('lat', 'IS', $this->pixie->db->expr('NULL'))
            ->find_all();
        foreach ($districts as $district) {
            // url encode the address
            $address = urlencode($district->region->name);
            $url = "https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD_tlRoO7iXvivmdJ2QKHD_xHvqFRoTbko";
            echo $url;
            $resp_json = file_get_contents($url);
            $resp = json_decode($resp_json, true);
            $this->data->google = [];
            if ($resp['status'] == 'OK') {
                $_district = $this->pixie->orm->get('district', $district->id);
                $_district->lat = $resp['results'][0]['geometry']['location']['lat'];
                $_district->lng = $resp['results'][0]['geometry']['location']['lng'];
                $_district->save();
            }
//            $this->data->districts = $this->pixie->orm->get('district')->find_all()->as_array(true);
        }
    }

    public function GET_campaigns_markers()
    {
        $campaigns = $this->pixie->orm->get('campaign')
            ->query()
            ->join('councils', ['councils.id', 'campaigns.council_id'])
            ->join('districts', ['districts.id', 'councils.district_id'])
            ->fields('councils.major_name', 'districts.lng', 'districts.lat', 'campaigns.id', 'campaigns.reason', 'districts.name')
            ->execute()->as_array(true);
        $this->data = $campaigns;
    }

    public function POST_connect_to_campaign()
    {
        $user_campaign = $this->pixie->orm->get('campaign_member')
            ->where('user_id', $this->user->id)
            ->where('campaign_id', $this->json_request->campaign_id)
            ->find();
        if (!$user_campaign->loaded()) {
            $campaign_member = $this->pixie->orm->get('campaign_member');
            $campaign_member->user_id = $this->user->id;
            $campaign_member->campaign_id = $this->json_request->campaign_id;
            if (isset($this->json_request->description))
                $campaign_member->description = $this->json_request->description;
            if (isset($this->json_request->subscribing))
                $campaign_member->subscribing = $this->json_request->subscribing;
            else
                $campaign_member->subscribing = 0;
            $campaign_member->save();
            $this->data = $campaign_member->as_array(true);
        } else {
            $this->data = $user_campaign->as_array(true);
        }

    }

    public function GET_sent_test_mail()
    {
        $mailgun_conf = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('../mailgun.yml'));
        $mg = new Mailgun($mailgun_conf['api_key']);
        $domain = $mailgun_conf['domain'];

# Now, compose and send your message.
        $mg->sendMessage($domain, array('from' => 'info@3radar.org',
            'to' => 'mr.amidyshka@gmail.com',
            'subject' => 'Дякуємо за реєстрацію на 3radar.org',
            'text' => 'It is so simple to send a message.'));
    }

}