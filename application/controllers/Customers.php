<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
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
    $this->load->model(array('customers_model'));
  }

	function index()
	{
    $this->load->library('table');

    $this->data['title'] = $this->lang->line('customer_heading');
    $this->data['status'] = $this->session->flashdata('status');
    $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
    
    $page = intval($this->input->get('page'));
    $page = empty($page) ? 1 : $page;
    $offset = ($page - 1) * PAGE_SIZE;

    $getData = $this->input->get();

    if (isset($getData['q'])) {
      $criteria = $getData['q'];
      $customers = $this->customers_model->search($criteria, $offset, PAGE_SIZE);
      $count = $this->customers_model->count_search($criteria);
      $pagelink = $this->pagination($count, 'customers', 'q='.$criteria);
    } else {
      $customers = $this->customers_model->get_all($offset, PAGE_SIZE);
      $count = $this->customers_model->count();
      $pagelink = $this->pagination($count, 'customers');
    }

    $this->data['number_of_customers'] = $count;
    
    $this->data['customers'] = $customers;

    $this->data['criteria'] = isset($criteria) ? $criteria : '';

		$this->load->view('otrack/customers', $this->data);
	}

	function create()
	{
    $this->data['title'] = $this->lang->line('heading_add_customer');

    //validate form input
    $this->form_validation->set_rules('name', $this->lang->line('field_customer_name'), 'required');
    $this->form_validation->set_rules('phone', $this->lang->line('field_phone'), 'required');
    $this->form_validation->set_rules('address_1', $this->lang->line('field_address_1'), 'required');
    $this->form_validation->set_rules('district', $this->lang->line('field_district'), 'required');
    $this->form_validation->set_rules('city', $this->lang->line('field_city'), 'required');
    $this->form_validation->set_rules('province', $this->lang->line('field_province'), 'required');

    if ($this->form_validation->run() == true)
    {
      $customer_data = array(
        'name'        => $this->input->post('name'),
        'phone'       => $this->input->post('phone'),
        'address_1'   => $this->input->post('address_1'),
        'address_2'   => $this->input->post('address_2'),
        'district'    => $this->input->post('district'),
        'city'        => $this->input->post('city'),
        'province'    => $this->input->post('province'),
        'zipcode'     => $this->input->post('zipcode'),
        'created_on'  => time(),
        'updated_on'  => time(),
      );
    }

    if ($this->form_validation->run() == true && $this->customers_model->create($customer_data))
    {
      $this->session->set_flashdata('status', 'success');
      $this->session->set_flashdata('message', $this->lang->line('message_customer_created'));
      redirect(base_url('customers'), 'refresh');
    }
    else
    {
      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		  $this->load->view('otrack/customers/create', $this->data);
    }
	}

  function edit($id='')
  {
    $this->data['title'] = $this->lang->line('heading_edit_customer');

    if (empty($id)) {
      $this->session->set_flashdata('message', $this->lang->line('page_not_found'));
      redirect(base_url('customers'),'refresh');
    }

    //validate form input
    $this->form_validation->set_rules('name', $this->lang->line('field_customer_name'), 'required');
    $this->form_validation->set_rules('phone', $this->lang->line('field_phone'), 'required');
    $this->form_validation->set_rules('address_1', $this->lang->line('field_address_1'), 'required');
    $this->form_validation->set_rules('district', $this->lang->line('field_district'), 'required');
    $this->form_validation->set_rules('city', $this->lang->line('field_city'), 'required');
    $this->form_validation->set_rules('province', $this->lang->line('field_province'), 'required');

    if ($this->form_validation->run() == true)
    {
      $customer_data = array(
        'name'        => $this->input->post('name'),
        'phone'       => $this->input->post('phone'),
        'address_1'   => $this->input->post('address_1'),
        'address_2'   => $this->input->post('address_2'),
        'district'    => $this->input->post('district'),
        'city'        => $this->input->post('city'),
        'province'    => $this->input->post('province'),
        'zipcode'     => $this->input->post('zipcode'),
        'updated_on'  => time(),
      );

      if ($this->customers_model->update($id, $customer_data)) {
        $this->session->set_flashdata('status', 'success');
        $this->session->set_flashdata('message', $this->lang->line('message_customer_updated'));
        redirect(base_url('customers'), 'refresh');
      } else {
        $this->session->set_flashdata('message', $this->lang->line('message_failed_updating_customer'));
        redirect(base_url('customers'), 'refresh');
      }      
    } else {
      $customer = $this->customers_model->get($id);
      $this->data['customer'] = $customer;

      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $provinces = $cities = $districts = array(''=>'');
      // get states
      $china_states = json_decode(file_get_contents(base_url()."/static/json/cn_city.json"), TRUE);

      foreach ($china_states as $province) {
        $provinces[$province['name']] = $province['name'];
        if ($province['name'] == $customer->province) {
          foreach ($province['children'] as $city) {
            $cities[$city['name']] = $city['name'];
            if ($city['name'] == $customer->city) {
              foreach ($city['children'] as $district) {
                $districts[$district['name']] = $district['name'];
              }
            }
          }
        }
      }

      $this->data['provinces'] = $provinces;
      $this->data['cities'] = $cities;
      $this->data['districts'] = $districts;

      $this->load->view('otrack/customers/edit', $this->data);      
    }
  }

  function delete()
  {
    $this->data['title'] = $this->lang->line('heading_delete_customer');

    //validate form input
    $this->form_validation->set_rules('cid', $this->lang->line('field_customer_id'), 'required');

    if ($this->form_validation->run() == true)
    {
      header('Content-Type: application/json');

      $cid = $this->input->post('cid');
      $result = $this->customers_model->delete($cid);
      echo json_encode($result);
    } else {
      $this->session->set_flashdata('message', $this->lang->line('page_not_found'));
      redirect(base_url(), 'refresh');
    }
  }

  function delete_all()
  {
    $this->data['title'] = $this->lang->line('heading_delete_customer');

    //validate form input
    $this->form_validation->set_rules('uid', $this->lang->line('field_user_id'), 'required');

    if ($this->form_validation->run() == true && $this->input->post('uid') == $this->session->userdata('user_id'))
    {
      header('Content-Type: application/json');

      $result = $this->customers_model->truncate();
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
