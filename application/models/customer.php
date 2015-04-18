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

  function get()
  {
    $result = $this->db->get($this->table_name)->result();

    return $result ? $result : NULL;
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
}