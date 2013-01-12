<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function get_info() {
		$this->db->from('admin');
		$this->db->where('id', 0);
		$query = $this->db->get();
		return $query->num_rows() === 1 ? $query->row() : null;
	}
}

/* End of file admin_model.php */

/* Location: ./application/models/admin_model.php */
?>
