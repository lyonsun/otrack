<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Customers_Model extends CI_Model
{
  
  function __construct()
  {
    $this->table_name = 'customers';
  }

  function get_all($offset=0, $limit=0)
  {
    $this->db->order_by('updated_on', 'desc');
    $result = $this->db->get($this->table_name, $limit, $offset)->result();

    return $result;
  }

  function count_search($criteria='')
  {
    $this->db->like('name', $criteria);
    $this->db->or_like('phone', $criteria);
    $this->db->or_like('address_1', $criteria);
    $this->db->or_like('address_2', $criteria);
    $this->db->or_like('district', $criteria);
    $this->db->or_like('city', $criteria);
    $this->db->or_like('province', $criteria);

    $result = $this->db->count_all_results($this->table_name);

    return $result;
  }

  function search($criteria='', $offset=0, $limit=0)
  {
    $this->db->like('name', $criteria);
    $this->db->or_like('phone', $criteria);
    $this->db->or_like('address_1', $criteria);
    $this->db->or_like('address_2', $criteria);
    $this->db->or_like('district', $criteria);
    $this->db->or_like('city', $criteria);
    $this->db->or_like('province', $criteria);
    
    $this->db->order_by('updated_on', 'desc');

    $result = $this->db->get($this->table_name, $limit, $offset)->result();

    return $result;
  }

  function get_distinct($col_name='id')
  {
    $this->db->select($col_name);
    $this->db->group_by($col_name);

    $result = array();

    foreach ($this->db->get($this->table_name)->result() as $row) {
      $result[$row->$col_name] = $row->$col_name;
    }

    return $result;
  }

  function get($id)
  {
    $this->db->where('id', $id);
    $result = $this->db->get($this->table_name)->row();

    return $result;
  }

  function count()
  {
    return $this->db->count_all($this->table_name);
  }

  function create($customer_data)
  {
    $id = $this->db->insert($this->table_name, $customer_data);
    return $id > 0 ? $id : FALSE;
  }

  function update($id, $customer_data)
  {
    $this->db->where('id', $id);
    $this->db->update($this->table_name, $customer_data);

    return $this->db->affected_rows() > 0 ? TRUE : FALSE;
  }

  function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table_name);

    return $this->db->affected_rows() > 0 ? TRUE : FALSE;
  }

  function truncate()
  {
    $this->db->truncate($this->table_name);
    return TRUE;
  }
}
