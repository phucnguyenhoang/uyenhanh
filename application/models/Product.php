<?php
class Product extends CI_Model {

  private $table = 'users';

  public function __construct() {
    parent::__construct();

    $this->load->database();
  }

}