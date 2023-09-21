<?php

class Auth_Ulogin extends Kohana_Auth_ORM{
    public function force_login($user,$remember = TRUE) {         

		$data = array(
			'user_id'    => $user->pk(),
			'expires'    => time() + $this->_config['lifetime'],
			'user_agent' => sha1(Request::$user_agent),
		);

                	// Create a new autologin token
		$token = ORM::factory('User_Token')
			->values($data)
			->create();

				// Set the autologin cookie
		Cookie::set('authautologin', $token->token, $this->_config['lifetime']);

                $this->complete_login($user);
                return TRUE;
    }
    
    
}
?>
