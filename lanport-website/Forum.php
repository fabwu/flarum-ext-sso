<?php

class Forum
{
    const URL = 'http://flarum.lanport.intra';
    const TOKEN = 'sdkljfsdlkjfskljfslkjflkj23423j42lkj34';
    const PASSWORD_TOKEN = 'sadfsdkfjslkjfdklj234lkj234lkj234kj234lkj23';
    const ROOT_DOMAIN = 'lanport.intra';

    const REMEMBER_ME_KEY = 'flarum_remember';

    private $username;

    private $password;

    private $email;

    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->password = $this->createPassword($username);
        $this->email = $email;
    }

    private function createPassword($username)
    {
        return md5($username . static::PASSWORD_TOKEN);
    }

    public function login()
    {
        $token = $this->getToken();

        if (empty($token)) {
            $this->signup();
            $token = $this->getToken();
        }

        static::setRememberMeCookie($token);
    }

    public static function logout()
    {
        static::removeRememberMeCookie();
    }

    public static function redirectToForum()
    {
        header('Location: ' . static::URL);
        die();
    }

    private function getToken()
    {
        $data = [
            'identification' => $this->username,
            'password' => $this->password
        ];

        $response = $this->sendPostRequest('/api/token', $data);

        return isset($response['token']) ? $response['token'] : '';
    }

    private function signup()
    {
        $data = [
            "data" => [
                "type" => "users",
                "attributes" => [
                    "username" => $this->username,
                    "password" => $this->password,
                    "email" => $this->email,
                ]
            ]
        ];

        $response = $this->sendPostRequest('/api/users', $data);

        return isset($response['data']['id']);
    }

    private function sendPostRequest($path, $data)
    {
        $data_string = json_encode($data);

        $ch = curl_init(static::URL . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Authorization: Token ' . static::TOKEN . '; userId=1',
            ]
        );
        $result = curl_exec($ch);

        return json_decode($result, true);
    }

    private static function setRememberMeCookie($token)
    {
        static::setCookie(self::REMEMBER_ME_KEY, $token, strtotime('+30 days'));
    }

    private static function removeRememberMeCookie()
    {
        unset($_COOKIE[self::REMEMBER_ME_KEY]);
        self::setCookie(self::REMEMBER_ME_KEY, '', time() - 10);
    }

    private static function setCookie($key, $token, $time)
    {
        setcookie($key, $token, $time, '/', static::ROOT_DOMAIN);
    }
}
