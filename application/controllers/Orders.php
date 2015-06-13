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
    $this->load->library(array('ion_auth','pagination','table','express'));
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
      'Receiver',
      'Products',
      'Express',
      'Tracking #',
      'Delivery Date',
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

    if (!$orders) {
      $row = array(
        'data' => '<div class="text-center">No records</div>',
        'colspan' => 9,
      );
      $this->table->add_row($row);
    } else {
      foreach ($orders as $order) {
        $order_products = $this->order->get_order_products($order->id);

        $products = array();

        foreach ($order_products as $product) {
          $products[] = $product->product_title.' <b class="text-danger">'.$product->product_amount.'</b>';
        }

        switch ($order->status) {
          case '1':
            $action = 
              anchor(base_url('orders/send').'/'.$order->id,'<i class="fa fa-fw fa-arrow-right"></i><span class="hidden-xs">Deliver</span>',array('class'=>'btn btn-xs btn-info'))." ".
              anchor(base_url('orders/edit').'/'.$order->id,'<i class="fa fa-fw fa-edit"></i><span class="hidden-xs">Edit</span>',array('class'=>'btn btn-xs btn-primary'))." ".
              anchor('#modal-delete','<i class="fa fa-fw fa-trash"></i><span class="hidden-xs">Delete</span>',array('class'=>'btn btn-xs btn-danger btn-modal-delete','data-toggle'=>'modal','data-oid'=>$order->id));
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
          implode('<br>', $products),
          $order->express_name,
          $order->tracking_number,
          $order->status == '1' ? $order->est_delivery_time : $order->final_delivery_time,
          array(
            'data'=>$action,
            'width'=>'20%',
          ),
        );

        $this->table->add_row($row);
      }
    }

    $this->data['order_table'] = $this->table->generate();

		$this->load->view('otrack/orders', $this->data);
	}

  function create()
  {
    //validate form input
    $this->form_validation->set_rules('buyer', 'Receiver', 'required');
    $this->form_validation->set_rules('type', 'Type', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('express_name', 'Express name', 'required');
    $this->form_validation->set_rules('delivery_time', 'Delivery Time', 'required');

    if ($this->form_validation->run() == true)
    {
      $buyer_id = $this->form_validation->set_value('buyer');
      $buyer = $this->customer->get($buyer_id);

      $order_data = array(
        'buyer_id' => $this->form_validation->set_value('buyer'),
        'buyer_name' => $buyer->name,
        'comments' => $this->input->post('comments'),
        'status' => $this->form_validation->set_value('status'),
        'type' => $this->form_validation->set_value('type'),
        'est_delivery_time' => date('Y-m-d H:i:s', strtotime($this->input->post('delivery_time'))),
        'express_name' => $this->form_validation->set_value('express_name'),
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
  }

  function send($oid='')
  {
    if (!$oid) {
      $this->session->set_flashdata('message', 'Page not found.');
      redirect(base_url('orders'), 'refresh');
    }

    $order = $this->order->get($oid);

    if (!$order) {
      $this->session->set_flashdata('message', 'Order not found.');
      redirect(base_url('orders'), 'refresh');
    }

    $this->form_validation->set_rules('express_name', 'Express Name', 'required');
    $this->form_validation->set_rules('tracking_number', 'Tracking #', 'required');

    if ($this->form_validation->run() == TRUE) {
      $order_data = array(
        'express_name' => $this->form_validation->set_value('express_name'),
        'tracking_number' => $this->form_validation->set_value('tracking_number'),
        'final_delivery_time' => date('Y-m-d H:i:s'),
        'status' => '2',
      );
    }

    if ($this->form_validation->run() == TRUE && $this->order->update($order->id, $order_data)) {
      $this->session->set_flashdata('message', 'Tracking # added.');
      redirect(base_url('orders'), 'refresh');
    } else {
      $buyer = $this->customer->get($order->buyer_id);

      $buyer_info = implode(', ', array(
        $buyer->province, 
        $buyer->city, 
        $buyer->district, 
        $buyer->address_1, 
        $buyer->phone)
      );

      $order_products = $this->order->get_order_products($order->id);
      
      $this->data['title'] = 'Send Order';
      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $this->data['order'] = $order;
      $this->data['buyer_info'] = $buyer_info;
      $this->data['order_products'] = $order_products;

      $this->load->view('otrack/orders/send', $this->data);
    }
  }

	function edit($oid='')
	{
    //validate form input
    $this->form_validation->set_rules('buyer', 'Receiver', 'required');
    $this->form_validation->set_rules('type', 'Type', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('express_name', 'Express name', 'required');
    $this->form_validation->set_rules('delivery_time', 'Delivery Time', 'required');

    if ($this->form_validation->run() == true)
    {
      $buyer_id = $this->form_validation->set_value('buyer');
      $buyer = $this->customer->get($buyer_id);

      $order_data = array(
        'buyer_id' => $this->form_validation->set_value('buyer'),
        'buyer_name' => $buyer->name,
        'comments' => $this->input->post('comments'),
        'status' => $this->form_validation->set_value('status'),
        'type' => $this->form_validation->set_value('type'),
        'est_delivery_time' => date('Y-m-d H:i:s', strtotime($this->input->post('delivery_time'))),
        'express_name' => $this->form_validation->set_value('express_name'),
        'created_on'  => date('Y-m-d H:i:s'),
      );

      $products = $this->input->post('product');
    }

    if ($this->form_validation->run() == true && $this->order->update_order_products($oid, $order_data, $products))
    {
      $this->session->set_flashdata('status', 'success');
      $this->session->set_flashdata('message', 'Order updated successfully.');
      redirect(base_url('orders'), 'refresh');
    }
    else
    {
      $this->data['title'] = 'Edit Order';

      if (!$oid) {
        $this->session->set_flashdata('message', 'Page not found.');
        redirect(base_url('orders'), 'refresh');
      }

      $order = $this->order->get($oid);
      $this->data['order'] = $order;

      $this->data['customers'] = $this->customer->get_all();

      $order_products = $this->order->get_order_products($order->id);
      $this->data['order_products'] = $order_products;

      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $this->load->view('otrack/orders/edit', $this->data);
    }
  }

  function delete()
  {
    $this->data['title'] = "Delete Order";

    //validate form input
    $this->form_validation->set_rules('oid', 'Order ID', 'required');

    if ($this->form_validation->run() == true)
    {
      header('Content-Type: application/json');

      $oid = $this->input->post('oid');
      $result = $this->order->delete($oid);
      echo json_encode($result);
    } else {
      $this->session->set_flashdata('message', 'Page not found.');
      redirect(base_url(), 'refresh');
    }
  }

  function view($oid='')
  {
    if (!$oid) {
      $this->session->set_flashdata('message', 'Page not found.');
      redirect(base_url('orders'), 'refresh');
    }

    $order = $this->order->get($oid);

    if (!$order) {
      $this->session->set_flashdata('message', 'Order not found.');
      redirect(base_url('orders'), 'refresh');
    }

    $buyer = $this->customer->get($order->buyer_id);

    $buyer_info = implode(', ', array(
      $buyer->province, 
      $buyer->city, 
      $buyer->district, 
      $buyer->address_1, 
      $buyer->phone)
    );

    $order_products = $this->order->get_order_products($order->id);
    
    $this->data['title'] = 'View Order';
    $this->data['status'] = $this->session->flashdata('status');
    $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

    $this->data['order'] = $order;
    $this->data['buyer_info'] = $buyer_info;
    $this->data['order_products'] = $order_products;
    // $this->data['tracking_info'] = $tracking_info;

    $this->load->view('otrack/orders/view', $this->data);
  }

  function get_tracking_info()
  {
    $getData = $this->input->get();

    if (!$getData || !isset($getData['tracking_number'])) {
      $ajaxData['success'] = FALSE;
      $ajaxData['message'] = 'Illegal request.';
      echo json_encode($ajaxData);
      return;
    }

    $tracking_number = $getData['tracking_number'];

    $tracking_info  = $this->express->getorder($tracking_number);

    $tracking_info = $tracking_info ? $tracking_info : array('status'=>'404','message'=>'Something went wrong. Can\'t get tracking information.');

    $ajaxData['success'] = TRUE;
    $ajaxData['message'] = $tracking_info;

    echo json_encode($ajaxData);
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
