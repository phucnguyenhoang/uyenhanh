<?php
class User extends CI_Model {

  private $table = 'users';

  public function __construct() {
    parent::__construct();

    $this->load->database();
    $this->load->helper('security');
  }

  public function login($username, $password) {
    $this->db->select('*');
    $this->db->from($this->table);
    $this->db->where('username', $username);
    $this->db->where('password', do_hash($password));
    $query = $this->db->get();

    return $query->row();
  }

}