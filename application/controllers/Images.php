<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Images extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    //redirect them to the login page
    if (!$this->ion_auth->logged_in())
    {
      redirect(base_url('login'), 'refresh');
    }
    
    //redirect them to the home page because they must be an administrator to view this
    if (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
    {
      return show_error('You must be an administrator to view this page.');
    }

    $this->load->library(array('pagination'));
    $this->load->model(array('images_model'));
  }

  function index()
  {
  }

  function create()
  {
    $config['upload_path']          = FCPATH.'uploads/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 1024*4;
    $config['max_width']            = 0;
    $config['max_height']           = 0;
    $config['overwrite']            = TRUE;

    $this->load->library('upload', $config);

    if ($this->images_model->get_via_title($_FILES['file']['name']) && file_exists(FCPATH.'uploads/'.$_FILES['file']['name'])) {
      $result = array(
        'code' => 403,
        'msg' => $this->lang->line('images_file_exists'),
      );
      // $this->output->set_status_header(403, 'File already uploaded.');
    } else if (!$this->upload->do_upload('file')) {
      $result = array(
        'code' => 403,
        'msg' => $this->upload->display_errors(),
      );
      // $this->output->set_status_header(403, $this->upload->display_errors());
    } else {
      $data = $this->upload->data();

      $image = array(
        'title' => $data['file_name'],
        'date_added' => date('Y-m-d H:i:s', time()),
        'date_updated' => date('Y-m-d H:i:s', time()),
      );
      $this->images_model->create($image);
      $result = array(
        'code' => 501,
        'msg' => $data,
      );
      // $this->output->set_status_header(501, $data);
    }
    echo json_encode($result);
  }
}
