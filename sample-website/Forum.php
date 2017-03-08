<?php

class Forum
{
    const REMEMBER_ME_KEY = 'flarum_remember';

    private $config;

    public function __construct()
    {
        $this->config = require_once __DIR__ . '/config.php';
    }

    /**
     * Call this method after your user is successfully authenticated.
     *
     * @param $username
     * @param $email
     */
    public function login($username, $email, $lifetime = 1209600 /* 60*60*24*14 */)
    {
        $password = $this->createPassword($username);
        $token = $this->getToken($username, $password, $lifetime);

        if (empty($token)) {
            $this->signup($username, $password, $email);
            $token = $this->getToken($username, $password, $lifetime);
        }

        $this->setRememberMeCookie($token, $lifetime);
    }

    /**
     * Call this method after you logged out your user.
     */
    public function logout()
    {
        $this->removeRememberMeCookie();
    }

    /**
     * Redirects a user back to the forum.
     */
    public function redirectToForum()
    {
        header('Location: ' . $this->config['flarum_url']);
        die();
    }

    private function createPassword($username)
    {
        return hash('sha256', $username . $this->config['password_token']);
    }

    private function getToken($username, $password, $lifetime)
    {
        $data = [
            'identification' => $username,
            'password' => $password,
            'lifetime' => $lifetime
        ];

        $response = $this->sendPostRequest('/api/token', $data);

        return isset($response['token']) ? $response['token'] : '';
    }

    private function signup($username, $password, $email)
    {
        $data = [
            "data" => [
                "type" => "users",
                "attributes" => [
                    "username" => $username,
                    "password" => $password,
                    "email" => $email,
                ]
            ]
        ];

        $response = $this->sendPostRequest('/api/users', $data);

        return isset($response['data']['id']);
    }

    private function sendPostRequest($path, $data)
    {
        $data_string = json_encode($data);

        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Authorization: Token ' . $this->config['flarum_api_key'] . '; userId=1',
            ]
        );
        $result = curl_exec($ch);

        return json_decode($result, true);
    }

    private function setRememberMeCookie($token, $lifetime)
    {
        $this->setCookie(self::REMEMBER_ME_KEY, $token, time() + $lifetime);
    }

    private function removeRememberMeCookie()
    {
        unset($_COOKIE[self::REMEMBER_ME_KEY]);
        $this->setCookie(self::REMEMBER_ME_KEY, '', time() - 10);
    }

    private function setCookie($key, $token, $time)
    {
        setcookie($key, $token, $time, '/', $this->config['root_domain']);
    }
}
