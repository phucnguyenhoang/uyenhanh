<?php
class Order extends CI_Model {

    private $table = 'orders';

    public $rule = array(
        'create' => array(
            array(
                'field' => 'order_date',
                'label' => 'lang:order_date',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'customer_id',
                'label' => 'lang:customer',
                //'rules' => array('trim', 'required', array($this->users_model, 'valid_username'))
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
        $this->db->trans_begin();
        $data = array(
            'deleted_by' => $this->auth->user('id'),
            'deleted_date' => date('Y-m-d H:i:s')
        );

        // update orders_id
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            return false;
        }

        // update orders_has_products
        $this->db->where('orders_id', $id);
        $this->db->update('orders_has_products', $data);

        $this->db->trans_commit();
        return true;
    }

    public function all ($date = null) {
        $this->db->select('o.id, o.type, o.order_date, o.status, o.note, o.deleted_by, c.name');
        $this->db->from($this->table.' o');
        $this->db->join('customers c', 'o.customers_id = c.id');
        if (!is_null($date)) {
            $this->db->where('o.order_date', $date);
        }
        $this->db->order_by('o.deleted_date, o.customers_id');
        $query = $this->db->get();

        return $query->result();
    }

    public function get ($id) {
        $this->db->select('o.id, o.type, o.order_date, o.status, o.note, o.deleted_by, c.name, c.email');
        $this->db->from($this->table.' o');
        $this->db->join('customers c', 'o.customers_id = c.id');
        $this->db->where('o.id', $id);
        $this->db->where('o.deleted_by IS NULL', null, true);
        $query = $this->db->get();

        return $query->row();
    }

    public function isExist($date, $customerId, $type) {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('order_date', $date);
        $this->db->where('customers_id', $customerId);
        $this->db->where('type', $type);
        $this->db->where('deleted_by IS NULL', null, true);
        $query = $this->db->get();

        return $query->row();
    }

    public function updateNote($id, $note, $type = 1) {
        $data = array('note' => $note, 'type' => $type);
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
        $this->db->insert('orders_has_products', $data);

        return $this->db->insert_id();
    }

    public function getProducts($id) {
        $this->db->select('o.id, p.name, o.price, o.quantity, o.ship, o.note');
        $this->db->from('orders_has_products o');
        $this->db->join('products p', 'o.products_id = p.id');
        $this->db->where('o.orders_id', $id);
        $this->db->where('o.deleted_by IS NULL', null, true);
        $this->db->order_by('o.quantity, o.price', 'desc');
        $query = $this->db->get();

        return $query->result();
    }

    public function getProduct($id) {
        $this->db->select('*');
        $this->db->from('orders_has_products');
        $this->db->where('id', $id);
        $this->db->where('deleted_by IS NULL', null, true);
        $query = $this->db->get();

        return $query->row();
    }

    public function deleteProduct($id) {
        $data = array(
            'deleted_by' => $this->auth->user('id'),
            'deleted_date' => date('Y-m-d H:i:s')
        );

        // update orders_has_products
        $this->db->where('id', $id);
        $this->db->update('orders_has_products', $data);

        return $this->db->affected_rows();
    }

    public function editProduct($id, $data) {
        // update orders_has_products
        $this->db->where('id', $id);
        $this->db->update('orders_has_products', $data);

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