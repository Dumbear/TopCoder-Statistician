<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin_model');
	}

	public function index() {
		if ($this->session->userdata('admin') === false) {
			redirect('/');
		}

		$this->load->model('algorithm_model');
		$data = array();
		$data['admin_info'] = $this->admin_model->get_info();
		$data['pending_algorithm_matches'] = $this->algorithm_model->get_pending_matches();
		$data['pending_algorithm_coders'] = $this->algorithm_model->get_pending_coders();
		$data['new_algorithm_matches'] = $this->algorithm_model->get_new_matches();
		$this->template->display_admin('admin', $data);
	}

	public function algorithm($operation, $param = '') {
		$op_list = array(
			'refresh',
			'add_matches',
			'add_coders'
		);
		if (in_array($operation, $op_list)) {
			curl_operate(site_url("admin/algorithm/do_{$operation}/{$param}"));
			redirect('/admin');
		}

		if ($operation === 'do_refresh') {
			$this->load->model('algorithm_model');
			$this->algorithm_model->add_new_matches();
			return;
		}

		if ($operation === 'do_add_matches') {
			$this->load->model('algorithm_model');
			$this->algorithm_model->add_matches();
			return;
		}

		if ($operation === 'do_add_coders') {
		}

		redirect('/admin');
	}

	public function login() {
		if ($this->session->userdata('admin') !== false) {
			redirect('/admin');
		}

		$this->load->library('form_validation');
		if ($this->form_validation->run('login') === false) {
			//TODO: redirect to referrer
			redirect('/');
		} else {
			redirect('/admin');
		}
	}

	public function logout() {
		if ($this->session->userdata('admin') === false) {
			redirect('/');
		}

		$this->session->unset_userdata('admin');
		//TODO: redirect to referrer
		redirect('/');
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
