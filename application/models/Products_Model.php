<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');

/**
* 
*/
class Products_Model extends CI_Model
{
  private $table_name;  
  function __construct()
  {
    parent::__construct();
    $this->table_name = 'products';
  }

  function count()
  {
    $count = $this->db->count_all_results($this->table_name);

    return $count;
  }

  function get($offset=0, $limit=0)
  {
    $this->db->order_by('stock', 'asc');
    $query = $this->db->get($this->table_name, $limit, $offset);

    return $query->result();
  }

  function get_out_of_stock()
  {
    $this->db->where('stock <=','0');
    $query = $this->db->get($this->table_name);

    return $query->result();
  }

  function get_via_id($id)
  {
    $this->db->where('id',$id);
    $query = $this->db->get($this->table_name);

    return $query->row();
  }

  function create($product_data)
  {
    $id = $this->db->insert($this->table_name, $product_data);
    return $id > 0 ? $id : FALSE;
  }

  function update($id, $product_data)
  {
    $this->db->where('id', $id);
    $this->db->update($this->table_name, $product_data);

    return $this->db->affected_rows() > 0 ? TRUE : FALSE;
  }

  function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table_name);

    return $this->db->affected_rows() > 0 ? TRUE : FALSE;
  }
}