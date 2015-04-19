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

    $this->load->model(array('customer'));
  }

	public function index()
	{
    $this->load->library('table');

    $this->data['title'] = 'Customers';
    $this->data['status'] = $this->session->flashdata('status');
    $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

    $this->data['number_of_customers'] = $this->customer->count();
    $this->data['customers'] = $this->customer->get_all();

		$this->load->view('otrack/customers', $this->data);
	}

	function create()
	{
    $this->data['title'] = "Create Customer";

    //validate form input
    $this->form_validation->set_rules('name', 'Customer Name', 'required');
    $this->form_validation->set_rules('phone', 'Phone Number', 'required');
    $this->form_validation->set_rules('address_1', 'Address 1', 'required');
    $this->form_validation->set_rules('district', 'District', 'required');
    $this->form_validation->set_rules('city', 'City', 'required');
    $this->form_validation->set_rules('province', 'Province', 'required');

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
      );
    }

    if ($this->form_validation->run() == true && $this->customer->create($customer_data))
    {
      $this->session->set_flashdata('status', 'success');
      $this->session->set_flashdata('message', 'Customer created successfully.');
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
    $this->data['title'] = "Edit Customer";

    if (empty($id)) {
      $this->session->set_flashdata('message', 'Page not found.');
      redirect(base_url('customers'),'refresh');
    }

    //validate form input
    $this->form_validation->set_rules('name', 'Customer Name', 'required');
    $this->form_validation->set_rules('phone', 'Phone Number', 'required');
    $this->form_validation->set_rules('address_1', 'Address 1', 'required');
    $this->form_validation->set_rules('district', 'District', 'required');
    $this->form_validation->set_rules('city', 'City', 'required');
    $this->form_validation->set_rules('province', 'Province', 'required');

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

      if ($this->customer->update($id, $customer_data)) {
        $this->session->set_flashdata('status', 'success');
        $this->session->set_flashdata('message', 'Customer updated successfully.');
        redirect(base_url('customers'), 'refresh');
      } else {
        $this->session->set_flashdata('message', 'Failed to update customer, try again.');
        redirect(base_url('customers'), 'refresh');
      }      
    } else {
      $customer = $this->customer->get($id);
      $this->data['customer'] = $customer;

      $this->data['status'] = $this->session->flashdata('status');
      $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

      $this->load->view('otrack/customers/edit', $this->data);      
    }
  }

  function delete()
  {
    $this->data['title'] = "Delete Customer";

    //validate form input
    $this->form_validation->set_rules('cid', 'Customer ID', 'required');

    if ($this->form_validation->run() == true)
    {
      header('Content-Type: application/json');

      $cid = $this->input->post('cid');
      $result = $this->customer->delete($cid);
      echo json_encode($result);
    } else {
      $this->session->set_flashdata('message', 'Page not found.');
      redirect(base_url(), 'refresh');
    }
  }
}
