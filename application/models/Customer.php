<?php
class Customer extends CI_Model {

    private $table = 'customers';

    public $rule = array(
        'create' => array(
            array(
                'field' => 'name',
                'label' => 'lang:name',
                'rules' => 'trim|required|max_length[150]'
            ),
            array(
                'field' => 'phone',
                'label' => 'lang:phone',
                'rules' => 'trim|required|max_length[20]|is_unique[customers.phone]'
            ),            
            array(
                'field' => 'email',
                'label' => 'lang:email',
                'rules' => 'trim|max_length[150]|is_unique[customers.email]'
            ),
            array(
                'field' => 'address',
                'label' => 'lang:address',
                'rules' => 'trim|max_length[200]'
            ),
            array(
                'field' => 'note',
                'label' => 'lang:note',
                'rules' => 'trim|max_length[200]'
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

    public function all ($available = false) {
        $this->db->select('*');
        $this->db->from($this->table);
        if ($available) {
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

    public function isExist($id) {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $this->db->where('deleted_by IS NULL', null, true);
        $query = $this->db->get();

        return $query->num_rows();
    }

}