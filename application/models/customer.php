<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Customer extends CI_Model
{
  
  function __construct()
  {
    $this->table_name = 'customers';
  }

  function get_all($offset=0, $limit=10)
  {
    $result = $this->db->get($this->table_name, $limit, $offset)->result();

    return $result;
  }

  function search($criteria=array())
  {
    foreach ($criteria as $key => $conditions) {
      if (!empty($conditions)) {
        $this->db->where_in($key, $conditions);
      }
    }

    $result = $this->db->get($this->table_name)->result();

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