<?php

namespace Hemend\Library\Laravel;

class Sms {
    static protected $instance;
    protected $api_key;
    protected $version;
    protected $is_test;

    /**
     * Gets config parameters for sending request.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_key = config('library.sms.api_key');
        $this->version = config('library.sms.version');
        $this->is_test = config('library.sms.is_test');
    }

    /**
     * Gets Api Url.
     *
     * @return string Indicates the Url
     */
    static public function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Gets Api Url.
     *
     * @return string Indicates the Url
     */
    protected function getAPIMessageSendUrl() {
        return 'https://sms.hemend.com/api/'.($this->is_test ? 'test' : 'main').'/'.$this->version;
    }

    /**
     * Send sms.
     *
     * @param mobile_number $mobile_number mobile number
     * @param string      $message      message
     * @param string      $send_date_time  Send Date Time

     *
     * @return string Indicates the sent sms result
     */
    static public function sendMessage(string $mobile_number, string $message, string $send_date_time=null)
    {
        $sms = self::getInstance();

        $token = $sms->_getToken();

        if ($token) {
            $postData = array(
                'message' => $message,
                'mobile_number' => $mobile_number,
                'send_date_time' => $send_date_time,
            );

            $url = $sms->getAPIMessageSendUrl() . '/message.send';
            $response = $sms->_execute($postData, $url, $token);
            $result = is_object($response) ? $response : false;
        } else {
            $result = false;
        }

        return $result;
    }

    private function _getCacheTokenKey()
    {
        return 'token_' . $this->is_test;
    }

    /**
     * Gets token key for all web service requests.
     *
     * @return string Indicates the token key

     */
    private function _getToken()
    {
        $cache_token_key = $this->_getCacheTokenKey();
//        cache()->forget($cache_token_key); // Delete cache

        $token = cache()->has($cache_token_key) ? cache($cache_token_key) : false;

        if(!$token) {
            $postData = array(
                'api_key' => $this->api_key,
            );

            $url = $this->getAPIMessageSendUrl() . '/auth.generateToken';
            $token_res = $this->_execute($postData, $url);

            if (is_object($token_res) && $token_res->status_code === 'OK') {
                $token = $token_res->access->token;
                $expire_time = strtotime($token_res->access->expires_in) - time() - 60;
                cache([$cache_token_key => $token], $expire_time);
            }
        }

        return $token;
    }

    /**
     * Executes the main method.
     *
     * @param postData[] $postData array of json data
     * @param string     $url      url
     * @param string     $token    token string
     *
     * @return string Indicates the curl execute result
     */
    private function _execute($postData, $url, $token=null)
    {
        $postString = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_filter([
            'Content-Type: application/json',
            $token ? 'Authorization: Bearer '.$token : null
        ]));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);

        if($result === false) {
            return false;
        }

        curl_close($ch);

        return json_decode($result);
    }
}
