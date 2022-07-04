<?php

namespace App\MyLibs;

class SendGrid{

    private $apiuser;
    private $apikey;


    /**
     * Register the application services.
     *
     * @return void
     */
    public function __construct()
    {

        $this->apiuser = config('mail.username');
        $this->apikey = config('mail.password');
    }


    public function get($action){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $action,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$this->apikey
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        return json_decode($response);

    }

    public function checkEmailBlocked($email){
        return $this->get("https://api.sendgrid.com/v3/suppression/blocks/".$email);
    }

    public function checkEmailInvalid($email){
       return $this->get("https://api.sendgrid.com/v3/suppression/invalid_emails/".$email);
    }

    public function checkEmailBounce($email){
        return $this->get("https://api.sendgrid.com/v3/suppression/bounces/".$email);
    }



}