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

	public function match($id) {
		$data = array();
		$data['match'] = $this->algorithm_model->get_match((int)$id);
		if ($data['match'] === null) {
			show_404();
		}
		$data['results'] = $this->algorithm_model->get_match_results((int)$id);
		$this->template->display_algorithm('algorithm_match', $data);
	}

	public function coder($id) {
		$data = array();
		$data['coder'] = $this->algorithm_model->get_coder((int)$id);
		if ($data['coder'] === null) {
			show_404();
		}
		$data['results'] = $this->algorithm_model->get_match_results_of_coder((int)$id);
		$this->template->display_algorithm('algorithm_coder', $data);
	}

	public function all_coders() {
		$data = array();
		$data['coders'] = $this->algorithm_model->get_all_coders();
		$this->template->display_algorithm('algorithm_all_coders', $data);
	}

	public function top_problem_ranks() {
		$data = array();
		$data['limit'] = 16;
		$data['results'] = array(
			array(
				$this->algorithm_model->get_top_problem_results(1, 1, $data['limit']),
				$this->algorithm_model->get_top_problem_results(1, 2, $data['limit'])
			),
			array(
				$this->algorithm_model->get_top_problem_results(2, 1, $data['limit']),
				$this->algorithm_model->get_top_problem_results(2, 2, $data['limit'])
			),
			array(
				$this->algorithm_model->get_top_problem_results(3, 1, $data['limit']),
				$this->algorithm_model->get_top_problem_results(3, 2, $data['limit'])
			)
		);
		$this->template->display_algorithm('algorithm_top_problem_ranks', $data);
	}
}

/* End of file algorithm.php */
/* Location: ./application/controllers/algorithm.php */
