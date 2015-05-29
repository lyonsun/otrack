<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    if (!$this->ion_auth->logged_in()) {
      redirect(base_url('login'),'refresh');
    }
    elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
    {
      //redirect them to the home page because they must be an administrator to view this
      return show_error('You must be an administrator to view this page.');
    }
    $this->load->library(array('ion_auth','pagination','table'));
    $this->load->model(array('customer','order'));
  }

	function index($status='')
	{
    $this->data['title'] = 'Orders';

    $this->data['status'] = $this->session->flashdata('status');
    $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

    $this->data['all_order_count'] = $this->order->count();

    $this->data['pending_order_count'] = $this->order->count('1');
    $this->data['finished_order_count'] = $this->order->count('2');

    $page = intval($this->input->get('page'));
    $page = empty($page) ? 1 : $page;
    $offset = ($page - 1) * PAGE_SIZE;

    $tmpl = array (
      'table_open'  => '<div class="table-responsive"><table class="table table-striped">',
      'heading_cell_start'  => '<th class="bg-primary">',
      'table_close'         => '</table></div>',
    );

    $this->table->set_template($tmpl);

    $heading = array(
      'ID',
      'Buyer',
      'Products',
      'Delivery Time',
      'Created On',
      'Action',
    );

    $this->table->set_heading($heading);

    if (!$status) {
      // get all orders
      $pagelink = $this->pagination($this->data['all_order_count'], 'orders');
      $orders = $this->order->get_all('', $offset, PAGE_SIZE);
    } else {
      switch ($status) {
        case '1':
          $pagelink = $this->pagination($this->data['pending_order_count'], 'orders/index/1');
          $orders = $this->order->get_all($status, $offset, PAGE_SIZE);
          break;
        case '2':
          $pagelink = $this->pagination($this->data['finished_order_count'], 'orders/index/2');
          $orders = $this->order->get_all($status, $offset, PAGE_SIZE);
          break;
        
        default:
          $this->session->set_flashdata('message', 'Page not found');
          redirect(base_url('orders'), 'refresh');
          break;
      }
    }

    foreach ($orders as $order) {
      $order_products = $this->order->get_order_products($order->id);

      $products = array();

      foreach ($order_products as $product) {
        $products[] = $product->product_amount.' '.$product->product_title;
      }

      switch ($order->status) {
        case '1':
          $action = anchor(base_url('orders/edit').'/'.$order->id,'<i class="fa fa-fw fa-arrow-right"></i><span class="hidden-xs">Deliver</span>',array('class'=>'btn btn-xs btn-danger btn-modal-deliver'));
          break;
        case '2':
          $action = anchor(base_url('orders/view').'/'.$order->id, '<i class="fa fa-fw fa-search"></i> Delivered', array('class'=>'btn btn-xs btn-success'));
          break;
        
        default:
          $action = 'Invalid order.';
          break;
      }

      $row = array(
        $order->id,
        $order->buyer_name,
        implode(', ', $products),
        $order->delivery_time,
        $order->created_on,
        $action, 
      );

      $this->table->add_row($row);
    }

    $this->data['order_table'] = $this->table->generate();

		$this->load->view('otrack/orders', $this->data);
	}

	function create()
	{
    //validate form input
    $this->form_validation->set_rules('buyer', 'Buyer', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('delivery_time', 'Delivery Time', 'required');

    if ($this->form_validation->run() == true)
    {
      $buyer_id = $this->form_validation->set_value('buyer');
      $buyer = $this->customer->get($buyer_id);

      $order_data = array(
        'buyer_id' => $this->form_validation->set_value('buyer'),
        'buyer_name' => $buyer->name,
        'status' => $this->form_validation->set_value('status'),
        'delivery_time' => date('Y-m-d H:i:s', strtotime($this->input->post('delivery_time'))),
        'created_on'  => date('Y-m-d H:i:s'),
      );

      $products = $this->input->post('product');
    }

    if ($this->form_validation->run() == true && $this->order->create($order_data, $products))
    {
      $this->session->set_flashdata('status', 'success');
      $this->session->set_flashdata('message', 'Order created successfully.');
      redirect(base_url('orders'), 'refresh');
    }
    else
    {
      $this->data['title'] = 'Add Order';
      $this->data['customers'] = $this->customer->get_all();

      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $this->load->view('otrack/orders/create', $this->data);
    }

  function pagination($total_rows = 100000, $base_url) {
    $config['base_url'] = base_url($base_url) . "?";
    $config['total_rows'] = $total_rows;
    $config['per_page'] = PAGE_SIZE;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['query_string_segment'] = 'page';

    return $this->pagination->initialize($config);
  }
}
