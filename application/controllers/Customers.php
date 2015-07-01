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
    $this->load->model(array('customer'));
  }

	function index()
	{
    $this->load->library('table');

    $this->data['title'] = $this->lang->line('customer_heading');
    $this->data['status'] = $this->session->flashdata('status');
    $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

    $this->data['number_of_customers'] = $this->customer->count();

    $postData = $this->input->post();
    $names = $phones = $provinces = $cities = $districts = array();

    if ($postData) {
      $names = isset($postData['names']) ? $postData['names'] : array();
      $phones = isset($postData['phones']) ? $postData['phones'] : array();
      $provinces = isset($postData['provinces']) ? $postData['provinces'] : array();
      $cities = isset($postData['cities']) ? $postData['cities'] : array();
      $districts = isset($postData['districts']) ? $postData['districts'] : array();

      $criteria = array(
        'name'=>$names,
        'phone' => $phones,
        'province' => $provinces,
        'city' => $cities,
        'district' => $districts
      );

      $customers = $this->customer->search($criteria);
    } else {
      $page = intval($this->input->get('page'));
      $page = empty($page) ? 1 : $page;
      $offset = ($page - 1) * PAGE_SIZE;
      $pagelink = $this->pagination($this->data['number_of_customers'], 'customers');

      $customers = $this->customer->get_all($offset, PAGE_SIZE);
    }

    $tmpl = array (
      'table_open'  => '<div class="table-responsive"><table class="table table-striped">',
      'heading_cell_start'  => '<th class="bg-primary">',
      'table_close'         => '</table></div>',
    );

    $this->table->set_template($tmpl);

    $heading = array(
      $this->lang->line('field_name'),
      $this->lang->line('field_phone'),
      $this->lang->line('field_address'),
      $this->lang->line('field_last_modified'),
      $this->lang->line('field_action'),
    );

    $this->table->set_heading($heading);

    if ($customers) {
      foreach ($customers as $customer) {
        $address = array($customer->province,$customer->city,$customer->district,$customer->address_1);
        if (!empty($customer->address_2)) {
          $address[] = $customer->address_2;
        }
        if (!empty($customer->zipcode)) {
          $address[] = $customer->zipcode;
        }
        $row = array(
          $customer->name,
          $customer->phone,
          implode(', ', $address),
          date('Y-m-d H:i:s', $customer->updated_on),
          array(
            'data'=>
            anchor(base_url('customers/edit').'/'.$customer->id,'<i class="fa fa-fw fa-edit"></i><span class="hidden-xs">'.$this->lang->line('action_edit').'</span>',array('class'=>'btn btn-xs btn-success'))." ".
            anchor('#modal-delete','<i class="fa fa-fw fa-trash"></i><span class="hidden-xs">'.$this->lang->line('action_delete').'</span>',array('class'=>'btn btn-xs btn-danger btn-modal-delete','data-toggle'=>'modal','data-cid'=>$customer->id,'data-name'=>$customer->name)),
            'width'=>'20%',
          ),
        );

        $this->table->add_row($row);
      }
    } else {
      $this->table->add_row(array('data'=>$this->lang->line('no_customers_found'),'colspan'=>'11','class'=>'text-center'));
    }

    $this->data['customer_table'] = $this->table->generate();

    $this->data['selected_names'] = $names;
    $this->data['selected_phones'] = $phones;
    $this->data['selected_provinces'] = $provinces;
    $this->data['selected_cities'] = $cities;
    $this->data['selected_districts'] = $districts;

    $this->data['names'] = (array)$this->customer->get_distinct('name');
    $this->data['phones'] = (array)$this->customer->get_distinct('phone');
    $this->data['provinces'] = (array)$this->customer->get_distinct('province');
    $this->data['cities'] = (array)$this->customer->get_distinct('city');
    $this->data['districts'] = (array)$this->customer->get_distinct('district');

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
      );
    }

    if ($this->form_validation->run() == true && $this->customer->create($customer_data))
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

      if ($this->customer->update($id, $customer_data)) {
        $this->session->set_flashdata('status', 'success');
        $this->session->set_flashdata('message', $this->lang->line('message_customer_updated'));
        redirect(base_url('customers'), 'refresh');
      } else {
        $this->session->set_flashdata('message', $this->lang->line('message_failed_updating_customer'));
        redirect(base_url('customers'), 'refresh');
      }      
    } else {
      $customer = $this->customer->get($id);
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
      $result = $this->customer->delete($cid);
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

      $result = $this->customer->truncate();
      echo json_encode($result);
    } else {
      $this->session->set_flashdata('message', $this->lang->line('page_not_found'));
      redirect(base_url(), 'refresh');
    }
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
