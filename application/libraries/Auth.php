<?php
class Auth {

	protected $CI;

	public function __construct() {
		$this->CI =& get_instance();
	}

	public function setUser($data) {
		$this->CI->session->set_userdata('auth', $data);
	}

	public function user($key = null) {
		if (is_null($key)) return $this->CI->session->userdata('auth');

		if ($key == 'avatar') {
			if (!empty($user) && !empty($user->avatar)) {
				return base_url('resources/images/avatar/'.$user->avatar);
			} else {
				return base_url('resources/images/avatar/default.png');
			}
		}

		$user = $this->CI->session->userdata('auth');
		if (!empty($user)) return $user->$key;

		return '';
	}

	public function isLoggedIn() {
		return $this->CI->session->has_userdata('auth');
	}

	public function isAdmin() {
		if (!empty($this->user('id')) && $this->user('id') == 1) return true;

		return false;
	}
}