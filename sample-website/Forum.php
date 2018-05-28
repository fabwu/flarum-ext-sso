<?php
class Forum
{
    const REMEMBER_ME_KEY = 'flarum_remember';
    
    private $config;
    
    public function __construct()
    {
        $this->config = require __DIR__ . '/config.php';
    }
    /**
     * Call this method after your user is successfully authenticated.
     *
     * @param $username
     * @param $email
     */
    public function login($username, $email, $password = '')
    {
    	if($password == ''){
    		$password = $this->createPassword($username);
    	}
    	
    	$token = $this->getToken($username, $password);

    	//If this user name doesn't exist, we do create a new user in Flarum database.
        if (empty($token)) {
        	
            $this->signup($username, $password, $email);
            $token = $this->getToken($username, $password);
        
            $result = ['message'=>'New user "'.$username.'" is created.', "status" => 'success', 'password' => $password ];
            
        //If thise username is found, we do return something.
        }else{
        	
            $result = ['message'=>'User "'. $username .'" is logged in.', "status" => 'success' ];
        
        }

        $this->setRememberMeCookie($token);
        
        return $result;
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
    private function getToken($username, $password)
    {
        $data = [
            'identification' => $username,
            'password' => $password,
            'lifetime' => $this->getLifetimeInSeconds(),
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
	private function sendGetRequest($path)
    {
		echo $this->config['flarum_url'] . $path;
		echo '<br>';
        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(''),
                'Authorization: Token ' . $this->config['flarum_api_key'] . '; userId=1',
            ]
        );

        $result = curl_exec($ch);

        return json_decode($result, true);
    }
    
	private function sendPatchRequest($path, $data)
    {
		echo $this->config['flarum_url'] . $path;
		echo '<br>';
        $data_string = json_encode($data);

        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
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
    
    
    private function setRememberMeCookie($token)
    {
        $this->setCookie(self::REMEMBER_ME_KEY, $token, time() + $this->getLifetimeInSeconds());
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
    private function getLifetimeInSeconds()
    {
        return $this->config['lifetime_in_days'] * 60 * 60 * 24;
    }
    
    function resetPassword($username, $password){
    	
    	$userObj = $this->getUserDetails($username);

    	$data = [
            "data" => [
                "type" => "users",
                "attributes" => [
                    "password" => $password
                ]
            ]
        ];
        $response = $this->sendPatchRequest('/api/users/'. $userObj['data']['id'], $data);

    }
    
    private function getUserDetails($username){
    	$response = $this->sendGetRequest('/api/users/'.$username);
    	return $response;
    }
}
