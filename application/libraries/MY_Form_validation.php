<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
	public function check_login() {
		$key = trim($this->CI->input->post('key'));
		$admin_info = $this->CI->admin_model->get_info();
		if ($admin_info === null) {
			return false;
		}
		if ($key !== $admin_info->key) {
			return false;
		}
		$this->CI->session->set_userdata('admin', true);
		return true;
	}
}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
?>
