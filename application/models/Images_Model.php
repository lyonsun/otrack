<?php 
defined('BASEPATH') OR exit('No direct script access allowed.');

/**
* 
*/
class Images_model extends CI_Model
{
  private $table_name;  
  function __construct()
  {
    parent::__construct();
    $this->table_name = 'images';
  }

  function count()
  {
    $count = $this->db->count_all_results($this->table_name);

    return $count;
  }

  function get($offset=0, $limit=0)
  {
    $query = $this->db->get($this->table_name, $limit, $offset);

    return $query->result();
  }

  function get_via_id($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get($this->table_name);

    return $query->row();
  }

  function get_via_title($title)
  {
    $this->db->where('title', $title);
    $query = $this->db->get($this->table_name);

    return $query->row();
  }

  function create($image_data)
  {
    $id = $this->db->insert($this->table_name, $image_data);
    return $id > 0 ? $id : FALSE;
  }
}