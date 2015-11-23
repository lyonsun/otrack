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
		$this->load->model(array('customer','order','products_model'));
	}

	function index()
	{
		$this->data['title'] = $this->lang->line('home_heading');
		$this->data['status'] = $this->session->flashdata('status');
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->data['number_of_customers'] = $this->customer->count();
    $this->data['number_of_orders'] = $this->order->count();
    $this->data['number_of_products'] = $this->products_model->count();


    $this->data['number_of_international_orders'] = $this->order->count('', 1);
    $this->data['number_of_domestic_orders'] = $this->order->count('', 2);

    $this->data['number_of_pending_orders'] = $this->order->count(1, '');
    $this->data['number_of_finished_orders'] = $this->order->count(2, '');

    // show first 10 products
    $this->data['products'] = $this->products_model->get(0, 10);
		
		$this->load->view('otrack/home', $this->data);
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

      $data['order'] = $this->order->count_in_a_period(date('Y-m-d H:i:s', $t_start), date('Y-m-d H:i:s', $t_end));
      $data['period'] = $month_end>0 ? date("M", mktime(0, 0, 0, $month_end, 10)).' '.date('Y', $t_end) : date("M", mktime(0, 0, 0, ($month_end+12), 10)).' '.date('Y', $t_start);
      
      $t_end = $t_start;

      array_push($order_trends_data, $data);

      $month_end--;
    }

    $order_trends_data = array_reverse($order_trends_data);

    // $this->order_trends_data['order_trends_order_trends_data'] = 
    echo json_encode($order_trends_data);
  }
}
