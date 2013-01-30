<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Algorithm extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('algorithm_model');
	}

	public function index($type = 'all', $offset = 0) {
		if (!in_array($type, array('all', 'srm', 'tour'))) {
			$type = 'all';
		}

		$this->load->library('pagination');
		$config = array(
			'base_url' => site_url("algorithm/{$type}"),
			'uri_segment' => 3,
			'total_rows' => $this->algorithm_model->count_useful_matches($type),
			'per_page' => 100,
			'num_links' => 4
		);
		$this->pagination->initialize($config);

		$data = array();
		$data['status'] = $this->algorithm_model->get_status();
		$data['type'] = $type;
		$data['matches'] = $this->algorithm_model->get_useful_matches($type, $config['per_page'], (int)$offset);
		$data['pagination'] = $this->pagination->create_links();

		$this->template->display_algorithm('algorithm', $data);
	}

	public function match($match_id) {
		$data = array();
		$data['match'] = $this->algorithm_model->get_match((int)$match_id);
		if ($data['match'] === null) {
			show_404();
		}
		$data['results'] = $this->algorithm_model->get_match_results((int)$match_id);
		$this->template->display_algorithm('algorithm_match', $data);
	}
}

/* End of file algorithm.php */
/* Location: ./application/controllers/algorithm.php */
