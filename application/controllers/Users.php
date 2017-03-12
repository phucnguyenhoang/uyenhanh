<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->auth->check(array('allowed' => array('login')));
		$this->load->model('user');
	}

	public function login() {
		if ($this->auth->isLoggedIn()) {
			redirect('/');
		}

		if ($this->input->method() == 'post') {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if (empty($username) || empty($password)) {
				$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('login_failed')));
			}

			$auth = $this->user->login($username, $password);
			if (empty($auth)) {
				$this->session->set_flashdata('message', array('type' => 'danger', 'msg' => lang('login_failed')));
			} else {
				$this->auth->setUser($auth);
				redirect('/');
			}
		}

		$data = array(
			'flash' => $this->session->flashdata('message')
		);
		$this->load->view('users/login', $data);
	}

	public function logout() {
		$this->session->unset_userdata('auth');
		redirect('users/login');
	}
}
