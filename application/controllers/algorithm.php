<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Algorithm extends CI_Controller {
	public function index($type = 'all') {
		$data = array();
		$data['type'] = $type;
		$this->template->display('algorithm', $data);
	}

	public function srm() {
		$data = array();
	}
}

/* End of file algorithm.php */
/* Location: ./application/controllers/algorithm.php */
