<?php
class Product extends CI_Model {

    private $table = 'products';

    public $rule = array(
        'create' => array(
            array(
                'field' => 'name',
                'label' => 'lang:name',
                'rules' => 'trim|required|max_length[150]'
            ),
            array(
                'field' => 'spec',
                'label' => 'lang:spec',
                'rules' => 'trim|max_length[150]'
            ),
            array(
                'field' => 'note',
                'label' => 'lang:note',
                'rules' => 'trim|max_length[250]'
            )
        ),
        'edit' => array(
            array(
                'field' => 'name',
                'label' => 'lang:name',
                'rules' => 'trim|required|max_length[150]'
            ),
            array(
                'field' => 'spec',
                'label' => 'lang:spec',
                'rules' => 'trim|max_length[150]'
            ),
            array(
                'field' => 'note',
                'label' => 'lang:note',
                'rules' => 'trim|max_length[250]'
            )
        )
    );

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

    public function create ($data) {
        $data['alias'] = toEnglish($data['name']);
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function edit($id, $data) {
        $data['alias'] = toEnglish($data['name']);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function delete($id) {
        $data['deleted_by'] = $this->auth->user('id');
        $data['deleted_date'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function all ($delete = false) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($delete) {
            $this->db->where('deleted_by IS NULL', null, true);
        }
        $this->db->order_by('deleted_date, name');
        $query = $this->db->get();

        return $query->result();
    }

    public function get ($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $this->db->where('deleted_by IS NULL', null, true);
        $query = $this->db->get();

        return $query->row();
    }

    public function autoComplate () {
        $this->db->select('id, name');
        $this->db->from($this->table);
        $this->db->where('deleted_by IS NULL', null, true);
        $this->db->order_by('name');
        $query = $this->db->get();

        return $query->result();
    }

    public function exist($id) {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $this->db->where('deleted_by IS NULL', null, true);
        $query = $this->db->get();

        return $query->num_rows();
    }

}