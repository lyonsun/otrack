<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
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

		$this->load->library('ion_auth');
		$this->load->model(array('customers_model','orders_model','products_model'));
	}

	function index()
	{
		$this->data['title'] = $this->lang->line('home_heading');
		$this->data['status'] = $this->session->flashdata('status');
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    // show first 10 products
    $this->data['products'] = $this->products_model->get(0, 10);
		
		$this->load->view('otrack/home', $this->data);
	}

  function customers()
  {    
    $result = array(
      'color' => 'success',
      'icon' => 'users',
      'link' => base_url('customers'),
      'number' => $this->customers_model->count(),
      'text' => lang('customer_heading'),
    );

    echo json_encode($result);
  }

  function orders()
  {    
    $result = array(
      'color' => 'primary',
      'icon' => 'file',
      'link' => base_url('orders'),
      'number' => $this->orders_model->count(),
      'text' => lang('order_heading'),
    );

    echo json_encode($result);
  }

  function products()
  {    
    $result = array(
      'color' => 'info',
      'icon' => 'list',
      'link' => base_url('products'),
      'number' => $this->products_model->count(),
      'text' => lang('product_heading'),
    );

    echo json_encode($result);
  }

  function pending_orders()
  {    
    $result = array(
      'color' => 'danger',
      'icon' => 'exclamation-circle',
      'link' => base_url('orders').'/index/1',
      'number' => $this->orders_model->count(1),
      'text' => lang('field_pending'),
    );

    echo json_encode($result);
  }

  function order_trends()
  {
    $order_trends_data = array();

    $time_end = time();
    $time_start = strtotime('-1year');

    $month_end = date('n', $time_end);
    $month_start = $month_end - 12;

    $t_end = $time_end;

    $count = 0;

    while ($t_end >= $time_start && $month_end >= $month_start){
      $count--;
      $t_start = strtotime($count.'months');

      $start_time = date('Y-m-d H:i:s', mktime(0, 0, 0, $month_end, 1, date('y', $t_end)));
      $end_time = date('Y-m-d H:i:s', mktime(0, 0, 0, $month_end+1, 1, date('y', $t_start)));

      $data['order'] = $this->orders_model->count_in_a_period($start_time, $end_time);
      $data['period'] = $month_end>0 ? date("M", mktime(0, 0, 0, $month_end, 10)).' '.date('Y', $t_end) : date("M", mktime(0, 0, 0, ($month_end+12), 10)).' '.date('Y', $t_start);
      
      $t_end = $t_start;

      array_push($order_trends_data, $data);

      $month_end--;
    }

    $order_trends_data = array_reverse($order_trends_data);

    echo json_encode($order_trends_data);
  }
}
