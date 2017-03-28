<?php
class Quotation extends CI_Model {

    private $table = 'quotations';

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

    public function create ($data) {
        $data['created_date'] = date('Y-m-d');
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
        $data = array(
            'deleted_by' => $this->auth->user('id'),
            'deleted_date' => date('Y-m-d H:i:s')
        );

        // delete quotations
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function all () {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('deleted_date, created_date');
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

    public function update($id, $name, $note) {
        $data = array('name' => $name, 'note' => $note);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function exist($id) {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $this->db->where('deleted_by IS NULL', null, true);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function addProducts($data) {
        $this->db->insert('quotations_has_products', $data);

        return $this->db->insert_id();
    }

    public function getProducts($id) {
        $this->db->select('q.id, p.name, q.price, q.note');
        $this->db->from('quotations_has_products q');
        $this->db->join('products p', 'q.products_id = p.id');
        $this->db->where('q.quotations_id', $id);
        $this->db->order_by('p.name');
        $query = $this->db->get();

        return $query->result();
    }

    public function getProduct($id) {
        $this->db->select('*');
        $this->db->from('quotations_has_products');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function deleteProduct($id) {
        $this->db->where('id', $id);
        $this->db->delete('quotations_has_products');

        return true;
    }

    public function editProduct($id, $data) {
        // update orders_has_products
        $this->db->where('id', $id);
        $this->db->update('quotations_has_products', $data);

        return $this->db->affected_rows();
    }

    public function test() {
        $data = array(
            'orders_id' => 4,
            'products_id' => 3,
            'quantity' => 20,
            'price' => 20000,
            'ship' => 15000
        );

        for ($i = 0; $i <= 20; $i++) {
            $data['note'] = 'test '.$i;
            $this->db->insert('orders_has_products', $data);    
        }
    }
}