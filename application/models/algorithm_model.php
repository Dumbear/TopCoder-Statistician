<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Algorithm_model extends CI_Model {
	protected $map_match_type;
	protected $map_match_status;
	protected $map_coder_status;

	public function __construct() {
		parent::__construct();
		$this->load->database();

		$this->map_match_type = array(
			'srm' => 0,
			'tour' => 1
		);
		$this->map_match_status = array(
			'ok' => 0,
			'new' => -1,
			'pending' => -2
		);
		$this->map_coder_status = array(
			'ok' => 0,
			'pending' => -2
		);
	}

	public function get_all_match_ids() {
		$this->db->select('id');
		$this->db->from('algorithm_matches');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_coder_ids() {
		$this->db->select('id');
		$this->db->from('coders');
		$query = $this->db->get();
		return $query->result();
	}

	public function count_useful_matches($type) {
		$this->db->from('algorithm_matches');
		//$this->db->join('algorithm_match_results', 'algorithm_matches.id = algorithm_match_results.match_id', 'inner');
		$this->db->where('status', $this->map_match_status['ok']);
		if ($type !== 'all') {
			$this->db->where('type', ($type === 'srm' ? $this->map_match_type['srm'] : $this->map_match_type['tour']));
		}
		//$this->db->group_by('algorithm_matches.id');
		return $this->db->count_all_results();
	}

	public function get_useful_matches($type, $limit, $offset) {
		$this->db->from('algorithm_matches');
		$this->db->where('status', $this->map_match_status['ok']);
		if ($type !== 'all') {
			$this->db->where('type', ($type === 'srm' ? $this->map_match_type['srm'] : $this->map_match_type['tour']));
		}
		$this->db->order_by('time DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_new_matches() {
		$this->db->from('algorithm_matches');
		$this->db->where('status', $this->map_match_status['new']);
		$this->db->order_by('time DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_pending_matches() {
		$this->db->from('algorithm_matches');
		$this->db->where('status', $this->map_match_status['pending']);
		$this->db->order_by('time DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_pending_coders() {
		$this->db->from('coders');
		$this->db->where('status', $this->map_coder_status['pending']);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_status($status, $must_null = false) {
		$this->db->trans_start();

		$old = $this->db->query('SELECT `algorithm_status` FROM `admin` WHERE `id` = 0 FOR UPDATE');
		if (!($old->num_rows() > 0)) {
			$this->db->trans_complete();
			return false;
		}
		$old = $old->row();

		if ($must_null !== false && $old->algorithm_status !== null) {
			$this->db->trans_complete();
			return false;
		}

		$this->db->set('algorithm_status', $status);
		$this->db->where('id', 0);
		$this->db->update('admin');

		$this->db->trans_complete();

		return $this->db->trans_status() !== false;
	}

	//TODO: use transaction
	public function add_new_matches() {
		if ($this->update_status('Fetching match list...', true) === false) {
			return false;
		}

		$data = fetch_algorithm_match_list();
		if ($data === false) {
			$this->update_status(null);
			//TODO: log it
			return false;
		}

		$n_coders = $this->db->count_all('coders');

		$ids = $this->get_all_match_ids();
		$ids_array = array();
		foreach ($ids as $id) {
			$ids_array[(string)$id->id] = null;
		}

		foreach ($data->row as $row) {
			if (array_key_exists((string)$row->round_id, $ids_array)) {
				continue;
			}
			$match = array(
				'id' => (int)$row->round_id,
				'full_name' => (string)$row->full_name,
				'short_name' => (string)$row->short_name,
				'type' => ((string)$row->round_type_desc === 'Single Round Match' ? $this->map_match_type['srm'] : $this->map_match_type['tour']),
				'time' => (string)$row->date,
				'status' => ($n_coders === 0 ? $this->map_match_status['ok'] : $this->map_match_status['new'])
			);
			$this->db->insert('algorithm_matches', $match);
			//TODO: check error and log it
		}

		$this->update_status(null);
		return true;
	}

	//TODO: use transaction
	public function add_matches() {
		if ($this->update_status('Adding matches...', true) === false) {
			return false;
		}

		$this->db->set('status', $this->map_match_status['pending']);
		$this->db->where('status', $this->map_match_status['new']);
		$this->db->update('algorithm_matches');

		$pending_matches = $this->get_pending_matches();
		foreach ($pending_matches as $match) {
			$this->update_status("Updating match {$match->short_name}");
			$this->update_match((int)$match->id);
		}

		$this->update_status(null);
		return true;
	}

	protected function update_match($match_id) {
		$n_coders = $this->db->count_all('coders');
		if ($n_coders === 0) {
			$this->db->set('status', $this->map_match_status['ok']);
			$this->db->where('id', $match_id);
			$this->db->update('algorithm_matches');
			return;
		}

		$this->db->set('status', $this->map_match_status['pending']);
		$this->db->where('id', $match_id);
		$this->db->update('algorithm_matches');

		$ids = $this->get_all_coder_ids();
		$ids_array = array();
		foreach ($ids as $id) {
			$ids_array[(string)$id->id] = null;
		}

		$data = fetch_algorithm_match_results($match_id);
		$this->db->where('match_id', $match_id);
		$this->db->delete('algorithm_match_results');
		foreach ($data->row as $row) {
			if (!array_key_exists((string)$row->coder_id, $ids_array)) {
				continue;
			}
			//TODO: null values
			$result = array(
				'match_id' => (int)$match_id,
				'coder_id' => (int)$row->coder_id,
				'room_id' => (int)$row->room_id,
				'earnings' => ((string)$row->paid === '*hidden*' ? null : (double)$row->paid),
				'old_rating' => (int)$row->old_rating,
				'new_rating' => (int)$row->new_rating,
				'new_volatility' => (int)$row->new_vol,
				'room_rank' => (int)$row->room_placed,
				'division_rank' => (int)$row->division_placed,
				'advanced' => ((string)$row->advanced === 'Y' ? true : false),
				'submission_points' => (double)$row->submission_points,
				'challenge_points' => (double)$row->challenge_points,
				'defense_points' => (double)$row->defense_points,
				'system_test_points' => (double)$row->system_test_points,
				'final_points' => (double)$row->final_points,
				'division' => (int)$row->division,
				'n_successful_challenges' => (int)$row->challenges_made_successful,
				'n_failed_challenges' => (int)$row->challenges_made_failed,
				'n_successful_defenses' => (int)$row->challenges_received_failed,
				'n_failed_defenses' => (int)$row->challenges_received_successful,
				'rated' => ((int)$row->rated_flag === 1 ? true : false),
				'problem1_id' => (int)$row->level_one_problem_id,
				'problem1_submission_points' => (double)$row->level_one_submission_points,
				'problem1_final_points' => (double)$row->level_one_final_points,
				'problem1_status' => (string)$row->level_one_status,
				'problem1_time' => (int)$row->level_one_time_elapsed,
				'problem1_rank' => (int)$row->level_one_placed, //Todo: re-calculate it
				'problem1_language' => (string)$row->level_one_language,
				'problem2_id' => (int)$row->level_two_problem_id,
				'problem2_submission_points' => (double)$row->level_two_submission_points,
				'problem2_final_points' => (double)$row->level_two_final_points,
				'problem2_status' => (string)$row->level_two_status,
				'problem2_time' => (int)$row->level_two_time_elapsed,
				'problem2_rank' => (int)$row->level_two_placed, //Todo: re-calculate it
				'problem2_language' => (string)$row->level_two_language,
				'problem3_id' => (int)$row->level_three_problem_id,
				'problem3_submission_points' => (double)$row->level_three_submission_points,
				'problem3_final_points' => (double)$row->level_three_final_points,
				'problem3_status' => (string)$row->level_three_status,
				'problem3_time' => (int)$row->level_three_time_elapsed,
				'problem3_rank' => (int)$row->level_three_placed, //Todo: re-calculate it
				'problem3_language' => (string)$row->level_three_language
			);
			$this->db->insert('algorithm_match_results', $result);
		}

		$this->db->set('status', $this->map_match_status['ok']);
		$this->db->where('id', $match_id);
		$this->db->update('algorithm_matches');
	}
}

/* End of file algorithm_model.php */
/* Location: ./application/models/algorithm_model.php */
?>
