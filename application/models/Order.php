<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Order extends CI_Model
{
  
  function __construct()
  {
    $this->table_name = 'orders';
    $this->order_products_table_name = 'order_products';
  }

  function count($status='', $type='')
  {
    if ($status) {
      $this->db->where('status', $status);      
    }

    if ($type) {
      $this->db->where('type', $type);      
    }

    return $this->db->count_all_results($this->table_name);
  }

  function get_all($status='', $offset=0, $limit=0)
  {
    if ($status) {
      $this->db->where('status', $status);
    }
    $this->db->order_by('created_on', 'desc');

    return $this->db->get($this->table_name, $limit, $offset)->result();
  }

  function get($id)
  {
    $this->db->where('id', $id);

    return $this->db->get($this->table_name)->row();
  }

  function count_in_a_period($time_start, $time_end)
  {
    $this->db->where('final_delivery_time >', $time_start);
    $this->db->where('final_delivery_time <=', $time_end);

    $result =  $this->db->count_all_results($this->table_name);

    return $result;
  }

  function create($order_data, $products)
  {
    $this->db->insert($this->table_name, $order_data);
    if (($oid = $this->db->insert_id()) > 0) {
      $this->_add_order_products($oid, $products);
      return TRUE;
    }
    return FALSE;
  }

  function update($id, $order_data)
  {
    $this->db->where('id', $id);
    $this->db->update($this->table_name, $order_data);

    if ($this->db->affected_rows() > 0) return TRUE;
    return FALSE;
  }

  function update_order_products($id, $order_data, $products)
  {
    $this->db->where('id', $id);
    $this->db->update($this->table_name, $order_data);

    $this->db->where('order_id', $id);
    $old_products = $this->db->get($this->order_products_table_name)->result();

    foreach ($old_products as $old_product) {
      $this->db->where('id', $old_product->product_id);
      $this->db->set('stock', 'stock + ' . (int)$old_product->product_amount, FALSE);
      $this->db->update('products');
    }

    $this->db->where('order_id', $id);
    $this->db->delete($this->order_products_table_name);

    $this->_add_order_products($id, $products);

    if ($this->db->affected_rows() > 0) return TRUE;
    return FALSE;
  }

  function _add_order_products($order_id, $products)
  {
    foreach ($products as $product) {
      $this->db->insert($this->order_products_table_name, 
        array(
          'order_id' => $order_id,
          'product_id' => $product['title'],
          'product_title' => $product['product_title'],
          'product_amount' => $product['amount'],
        )
      );

      $this->db->where('id', $product['title']);
      $this->db->set('stock', 'stock - ' . (int)$product['amount'], FALSE);
      $this->db->update('products');
    }
  }

  function get_order_products($order_id='')
  {
    if ($order_id) {
      $this->db->where('order_id', $order_id);
    }
    return $this->db->get($this->order_products_table_name)->result();
  }

  function delete($id)
  {
    $this->db->where('order_id', $id);
    $this->db->delete($this->order_products_table_name);

    $this->db->where('id', $id);
    $this->db->delete($this->table_name);

    return $this->db->affected_rows() > 0 ? TRUE : FALSE;
  }
}
