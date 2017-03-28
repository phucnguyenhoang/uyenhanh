<?php
class Report extends CI_Model {

    public function __construct() {
      parent::__construct();

      $this->load->database();
    }

    public function getReport($fromDate, $toDate, $customerId) {
        $this->db->select('o.order_date, o.type, o.note as order_note, ohp.quantity, ohp.price, ohp.ship, ohp.note as ohp_note, p.name');
        $this->db->from('orders o');
        $this->db->join('orders_has_products ohp', 'o.id = ohp.orders_id AND ohp.deleted_by IS NULL');
        $this->db->join('products p', 'ohp.products_id = p.id');
        $this->db->where('o.customers_id', $customerId);
        $this->db->where('o.order_date >=', date('Y-m-d', strtotime($fromDate)));
        $this->db->where('o.order_date <=', date('Y-m-d', strtotime($toDate)));
        $this->db->where('o.deleted_by IS NULL', null, true);
        $this->db->order_by('o.order_date', 'desc');
        $query = $this->db->get();

        return $query->result();
    }
}