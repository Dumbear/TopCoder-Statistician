<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Algorithm extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('algorithm_model');
	}

	public function index($type = 'all', $offset = 0) {
		//TODO: check type
		$data = array();
		$data['type'] = $type;

		$this->load->library('pagination');
		$config = array(
			'base_url' => site_url("algorithm/{$type}"),
			'uri_segment' => 3,
			'total_rows' => $this->algorithm_model->count_useful_matches($type),
			'per_page' => 100,
			'num_links' => 4
		);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['matches'] = $this->algorithm_model->get_useful_matches($type, $config['per_page'], (int)$offset);

		$this->template->display_algorithm('algorithm', $data);
	}
}

/* End of file algorithm.php */
/* Location: ./application/controllers/algorithm.php */
