<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
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

    $this->load->library(array('pagination', 'table'));
    $this->load->model(array('products_model', 'images_model'));
  }

  function index()
  {
    $getData = $this->input->get();

    $this->data['title'] = $this->lang->line('product_heading');
    $this->data['status'] = $this->session->flashdata('status');
    $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

    $page = intval($this->input->get('page'));
    $page = empty($page) ? 1 : $page;
    $offset = ($page - 1) * PAGE_SIZE;
    
    if (isset($getData['q'])) {
      $count = $this->products_model->count_search($getData['q']);
      $pagelink = $this->pagination($count, 'products', 'q='.$getData['q']);
      $products = $this->products_model->search($getData['q'], $offset, PAGE_SIZE);
    } else {
      $count = $this->products_model->count();
      $pagelink = $this->pagination($count, 'products');
      $products = $this->products_model->get($offset, PAGE_SIZE);
    }

    $this->data['products'] = $products;

    $this->data['criteria'] = isset($getData['q']) ? $getData['q'] : '';

    $this->load->view('otrack/products', $this->data);
  }

  function create()
  {
    $this->data['title'] = $this->lang->line('heading_add_product');

    //validate form input
    $this->form_validation->set_rules('name', $this->lang->line('field_name'), 'required');
    $this->form_validation->set_rules('description', $this->lang->line('field_description'), 'required');
    $this->form_validation->set_rules('stock', $this->lang->line('field_stock'), 'required|numeric');
    // $this->form_validation->set_rules('images', $this->lang->line('field_images'), 'required');

    if ($this->form_validation->run() == true)
    {
      $product_data = array(
        'name'              => $this->input->post('name'),
        'description'       => $this->input->post('description'),
        'stock'             => $this->input->post('stock'),
        'image_id'          => $this->input->post('images'),
        'date_added'        => date('Y-m-d H:i:s', time()),
        'date_updated'      => date('Y-m-d H:i:s', time()),
      );
    }

    if ($this->form_validation->run() == true && $this->products_model->create($product_data))
    {
      $this->session->set_flashdata('status', 'success');
      $this->session->set_flashdata('message', $this->lang->line('message_product_created'));
      redirect(base_url('products'), 'refresh');
    }
    else
    {
      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $images = $this->images_model->get();

      $image_options = array(''=>'');

      foreach ($images as $image) {
        $image_cell = $image && file_exists(FCPATH.'uploads/'.$image->title) ? '<img src="'.base_url().'uploads/'.$image->title.'" class="img-responsive" alt="product_img" width="50px">' : '';
        $image_options[$image->id] = $image_cell.' '.$image->title;
      }

      $this->data['image_options']  = $image_options;

      $this->load->view('otrack/products/create', $this->data);
    }
  }

  function view($id='')
  {
    $this->data['title'] = $this->lang->line('heading_view_product');

    if (empty($id)) {
      $this->session->set_flashdata('message', $this->lang->line('page_not_found'));
      redirect(base_url('products'),'refresh');
    }

    $product = $this->products_model->get_via_id($id);

    if (!$product) {
      $this->session->set_flashdata('message', $this->lang->line('page_not_found'));
      redirect(base_url('products'),'refresh');
    }

    $this->data['product'] = $product;

    $image = $this->images_model->get_via_id($product->image_id);

    $this->data['product_image'] = $image ? base_url('uploads').'/'.$image->title : '';

    $this->load->view('otrack/products/view', $this->data);
  }

  function edit($id='')
  {
    $this->data['title'] = $this->lang->line('heading_edit_product');

    if (empty($id)) {
      $this->session->set_flashdata('message', $this->lang->line('page_not_found'));
      redirect(base_url('products'),'refresh');
    }

    //validate form input
    $this->form_validation->set_rules('name', $this->lang->line('field_name'), 'required');
    $this->form_validation->set_rules('description', $this->lang->line('field_description'), 'required');
    $this->form_validation->set_rules('stock', $this->lang->line('field_stock'), 'required|numeric');
    // $this->form_validation->set_rules('images', $this->lang->line('field_images'), 'required');

    if ($this->form_validation->run() == true)
    {
      $product_data = array(
        'name'              => $this->input->post('name'),
        'description'       => $this->input->post('description'),
        'stock'             => $this->input->post('stock'),
        'image_id'          => $this->input->post('images'),
        'date_updated'      => date('Y-m-d H:i:s', time()),
      );

      if ($this->products_model->update($id, $product_data)) {
        $this->session->set_flashdata('status', 'success');
        $this->session->set_flashdata('message', $this->lang->line('message_product_updated'));
        redirect(base_url('products'), 'refresh');
      } else {
        $this->session->set_flashdata('message', $this->lang->line('message_failed_updating_product'));
        redirect(base_url('products'), 'refresh');
      }      
    } else {
      $product = $this->products_model->get_via_id($id);
      $this->data['product'] = $product;

      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $images = $this->images_model->get();

      $image_options = array(''=>'');

      foreach ($images as $image) {
        $image_cell = $image && file_exists(FCPATH.'uploads/'.$image->title) ? '<img src="'.base_url().'uploads/'.$image->title.'" class="img-responsive" alt="product_img" width="50px">' : '';
        $image_options[$image->id] = $image_cell.' '.$image->title;
      }

      $this->data['image_options']  = $image_options;

      $this->load->view('otrack/products/edit', $this->data);      
    }
  }

  function delete()
  {
    $this->data['title'] = $this->lang->line('heading_delete_product');

    //validate form input
    $this->form_validation->set_rules('pid', $this->lang->line('field_product_id'), 'required');

    if ($this->form_validation->run() == true)
    {
      header('Content-Type: application/json');

      $pid = $this->input->post('pid');
      $result = $this->products_model->delete($pid);
      echo json_encode($result);
    } else {
      $this->session->set_flashdata('message', $this->lang->line('page_not_found'));
      redirect(base_url(), 'refresh');
    }
  }

  function pagination($total_rows = 100000, $base_url, $params='') {
    $config['base_url'] = base_url($base_url) . "?" . $params;
    $config['total_rows'] = $total_rows;
    $config['per_page'] = PAGE_SIZE;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';

    return $this->pagination->initialize($config);
  }
}
