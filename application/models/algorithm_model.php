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
			'pending' => -1
		);
		$this->map_coder_status = array(
			'ok' => 0,
			'pending' => -1
		);
	}

	public function get_all_match_ids() {
		$this->db->select('id');
		$this->db->from('algorithm_matches');
		$ids = $this->db->get()->result();
		$ids_array = array();
		foreach ($ids as $id) {
			$ids_array[(string)$id->id] = null;
		}
		return $ids_array;
	}

	public function get_all_coder_ids() {
		$this->db->select('id');
		$this->db->from('coders');
		$ids = $this->db->get()->result();
		$ids_array = array();
		foreach ($ids as $id) {
			$ids_array[(string)$id->id] = null;
		}
		return $ids_array;
	}

	public function count_useful_matches($type) {
		//TODO: make it useful
		$this->db->from('algorithm_matches');
		//$this->db->join('algorithm_match_results', 'algorithm_matches.id = algorithm_match_results.match_id', 'inner');
		if ($type !== 'all') {
			$this->db->where('type', ($type === 'srm' ? $this->map_match_type['srm'] : $this->map_match_type['tour']));
		}
		return $this->db->count_all_results();
	}

	public function get_useful_matches($type, $limit, $offset) {
		//TODO: make it useful
		$this->db->from('algorithm_matches');
		if ($type !== 'all') {
			$this->db->where('type', ($type === 'srm' ? $this->map_match_type['srm'] : $this->map_match_type['tour']));
		}
		$this->db->order_by('time DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_coders() {
		$this->db->select('coders.*');
		$this->db->select_max('new_rating', 'max_rating');
		$this->db->select_min('new_rating', 'min_rating');
		$this->db->from('coders');
		$this->db->join('algorithm_match_results', 'coders.id = algorithm_match_results.coder_id', 'inner');
		$this->db->group_by('coders.id');
		$this->db->order_by('algorithm_rating DESC, coders.id');
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

	public function get_match($id) {
		$this->db->from('algorithm_matches');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->num_rows() === 1 ? $query->row() : null;
	}

	public function get_coder($id) {
		$this->db->from('coders');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->num_rows() === 1 ? $query->row() : null;
	}

	public function get_match_results($match_id) {
		$results = array(array(), array());
		$this->db->select('algorithm_match_results.*, coders.handle');
		$this->db->from('algorithm_match_results');
		$this->db->join('coders', 'algorithm_match_results.coder_id = coders.id', 'inner');
		$this->db->where('match_id', $match_id);
		$this->db->order_by('division, division_rank, old_rating DESC, coder_id');
		$query = $this->db->get();
		foreach ($query->result() as $result) {
			if ((int)$result->division === 1) {
				array_push($results[0], $result);
			}
			if ((int)$result->division === 2) {
				array_push($results[1], $result);
			}
		}
		return $results;
	}

	public function get_match_results_of_coder($coder_id) {
		$this->db->from('algorithm_match_results');
		$this->db->join('algorithm_matches', 'algorithm_match_results.match_id = algorithm_matches.id', 'inner');
		$this->db->where('coder_id', $coder_id);
		$this->db->order_by('time DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_top_division_results($division, $limit) {
		$this->db->select('algorithm_match_results.*, algorithm_matches.*, coders.handle');
		$this->db->from('algorithm_match_results');
		$this->db->join('algorithm_matches', 'algorithm_match_results.match_id = algorithm_matches.id', 'inner');
		$this->db->join('coders', 'algorithm_match_results.coder_id = coders.id', 'inner');
		$this->db->where('division', $division);
		$this->db->order_by("division_rank, algorithm_matches.time, coders.handle");
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_top_problem_results($problem, $division, $limit) {
		$this->db->select('algorithm_match_results.*, algorithm_matches.*, coders.handle');
		$this->db->from('algorithm_match_results');
		$this->db->join('algorithm_matches', 'algorithm_match_results.match_id = algorithm_matches.id', 'inner');
		$this->db->join('coders', 'algorithm_match_results.coder_id = coders.id', 'inner');
		$this->db->where("problem{$problem}_status", 'Passed System Test');
		$this->db->where('division', $division);
		$this->db->order_by("problem{$problem}_rank, algorithm_matches.time, coders.handle");
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_status() {
		$this->db->from('updating_status');
		$this->db->where('type', 'algorithm');
		$query = $this->db->get();
		return $query->num_rows() === 1 ? $query->row() : null;
	}

	public function lock() {
		$this->db->trans_start();
		$query = $this->db->query("SELECT `locked` FROM `updating_status` WHERE `type` = 'algorithm' FOR UPDATE");
		if (!($query->num_rows > 0) || $query->row()->locked === '1') {
			$this->db->trans_complete();
			return false;
		}
		$this->db->set('locked', 1);
		$this->db->where('type', 'algorithm');
		$this->db->update('updating_status');
		$this->db->trans_complete();
		return $this->db->trans_status() !== false;
	}

	public function unlock() {
		$this->db->set('locked', 0);
		$this->db->where('type', 'algorithm');
		$this->db->update('updating_status');
	}

	public function update_timestamp() {
		$this->db->set('timestamp', 'NOW()', false);
		$this->db->where('type', 'algorithm');
		$this->db->update('updating_status');
	}

	public function update_status($status) {
		$this->db->set('status', $status);
		$this->db->where('type', 'algorithm');
		$this->db->update('updating_status');
	}

	public function update_log($log, $append = true) {
		$log = htmlspecialchars($log);
		if ($append) {
			$log = $this->db->escape($log . '<br />');
			$this->db->set('log', "CONCAT({$log}, `log`)", false);
		} else {
			$this->db->set('log', $log);
		}
		$this->db->where('type', 'algorithm');
		$this->db->update('updating_status');
	}

	protected function do_fetch_new_matches() {
		$new_matches = array();
		$this->update_status('Fetching new matches...');
		$data = fetch_algorithm_match_list();
		if ($data === false) {
			$new_matches = false;
		} else {
			$ids_array = $this->get_all_match_ids();
			foreach ($data->row as $row) {
				if (array_key_exists((string)$row->round_id, $ids_array)) {
					continue;
				}
				array_push($new_matches, array(
					'id'		 => (int)$row->round_id,
					'full_name'	 => (string)$row->full_name,
					'short_name' => (string)$row->short_name,
					'type'		 => ($this->map_match_type[(string)$row->round_type_desc === 'Single Round Match' ? 'srm' : 'tour']),
					'time'		 => (string)$row->date,
					'status'	 => $this->map_match_status['pending']
				));
			}
		}
		$this->update_status(null);
		$this->update_log('Fetching new matches: ' . ($new_matches === false ? 'failed' : 'done') . '.');
		return $new_matches;
	}

	protected function do_fetch_coders($coders) {
		$new_coders = array();
		$this->update_status('Fetching coders...');
		$data = fetch_coder_list();
		if ($data === false) {
			$new_coders = false;
		} else {
			foreach ($data->row as $row) {
				$found = false;
				foreach ($coders as $coder) {
					if ($coder['handle'] === (string)$row->handle) {
						$found = $coder;
						break;
					}
				}
				if ($found === false) {
					continue;
				}
				array_push($new_coders, array(
					'id'				   => (int)$row->coder_id,
					'handle'			   => (string)$row->handle,
					'real_name'			   => (string)$found['real_name'],
					'algorithm_rating'	   => (int)$row->alg_rating,
					'algorithm_volatility' => (int)$row->alg_vol,
					'n_algorithm_matches'  => (int)$row->alg_num_ratings,
					'status'			   => $this->map_coder_status['pending']
				));
			}
		}
		$this->update_status(null);
		$this->update_log('Fetching coders: ' . ($new_coders === false ? 'failed' : 'done') . '.');
		return $new_coders;
	}

	protected function do_fetch_results($match) {
		$results = array();
		$this->update_status("Fetching match {$match->short_name} results...");
		$data = fetch_algorithm_match_results((int)$match->id);
		if ($data === false) {
			$results = false;
		} else {
			$ids_array = $this->get_all_coder_ids();
			$problem_time_array = array('1' => array(array(), array(), array()), '2' => array(array(), array(), array()));
			foreach ($data->row as $row) {
				if ((string)$row->level_one_status === 'Passed System Test') {
					array_push($problem_time_array[(string)$row->division][0], (int)$row->level_one_time_elapsed);
				}
				if ((string)$row->level_two_status === 'Passed System Test') {
					array_push($problem_time_array[(string)$row->division][1], (int)$row->level_two_time_elapsed);
				}
				if ((string)$row->level_three_status === 'Passed System Test') {
					array_push($problem_time_array[(string)$row->division][2], (int)$row->level_three_time_elapsed);
				}
				if (!array_key_exists((string)$row->coder_id, $ids_array)) {
					continue;
				}
				array_push($results, array(
					'match_id'					 => (int)$match->id,
					'coder_id'					 => (int)$row->coder_id,
					'room_id'					 => (int)$row->room_id,
					'earnings'					 => ((string)$row->paid === '*hidden*' ? null : (double)$row->paid),
					'old_rating'				 => (int)$row->old_rating,
					'new_rating'				 => (int)$row->new_rating,
					'new_volatility'			 => (int)$row->new_vol,
					'room_rank'					 => (int)$row->room_placed,
					'division_rank'				 => (int)$row->division_placed,
					'advanced'					 => ((string)$row->advanced === 'Y' ? 1 : 0),
					'submission_points'			 => (double)$row->submission_points,
					'challenge_points'			 => (double)$row->challenge_points,
					'defense_points'			 => (double)$row->defense_points,
					'system_test_points'		 => (double)$row->system_test_points,
					'final_points'				 => (double)$row->final_points,
					'division'					 => (int)$row->division,
					'n_successful_challenges'	 => (int)$row->challenges_made_successful,
					'n_failed_challenges'		 => (int)$row->challenges_made_failed,
					'n_successful_defenses'		 => (int)$row->challenges_received_failed,
					'n_failed_defenses'			 => (int)$row->challenges_received_successful,
					'rated'						 => ((int)$row->rated_flag === 1 ? 1 : 0),
					'problem1_id'				 => (int)$row->level_one_problem_id,
					'problem1_submission_points' => (double)$row->level_one_submission_points,
					'problem1_final_points'		 => (double)$row->level_one_final_points,
					'problem1_status'			 => (string)$row->level_one_status,
					'problem1_time'				 => (int)$row->level_one_time_elapsed,
					'problem1_rank'				 => null,
					'problem1_language'			 => (string)$row->level_one_language,
					'problem2_id'				 => (int)$row->level_two_problem_id,
					'problem2_submission_points' => (double)$row->level_two_submission_points,
					'problem2_final_points'		 => (double)$row->level_two_final_points,
					'problem2_status'			 => (string)$row->level_two_status,
					'problem2_time'				 => (int)$row->level_two_time_elapsed,
					'problem2_rank'				 => null,
					'problem2_language'			 => (string)$row->level_two_language,
					'problem3_id'				 => (int)$row->level_three_problem_id,
					'problem3_submission_points' => (double)$row->level_three_submission_points,
					'problem3_final_points'		 => (double)$row->level_three_final_points,
					'problem3_status'			 => (string)$row->level_three_status,
					'problem3_time'				 => (int)$row->level_three_time_elapsed,
					'problem3_rank'				 => null,
					'problem3_language'			 => (string)$row->level_three_language
				));
			}
			sort($problem_time_array['1'][0]);
			sort($problem_time_array['1'][1]);
			sort($problem_time_array['1'][2]);
			sort($problem_time_array['2'][0]);
			sort($problem_time_array['2'][1]);
			sort($problem_time_array['2'][2]);
			for ($i = 0; $i < count($results); ++$i) {
				$div = (string)$results[$i]['division'];
				if ($results[$i]['problem1_status'] === 'Passed System Test') {
					$results[$i]['problem1_rank'] = array_search((int)$results[$i]['problem1_time'], $problem_time_array[$div][0]) + 1;
				}
				if ($results[$i]['problem2_status'] === 'Passed System Test') {
					$results[$i]['problem2_rank'] = array_search((int)$results[$i]['problem2_time'], $problem_time_array[$div][1]) + 1;
				}
				if ($results[$i]['problem3_status'] === 'Passed System Test') {
					$results[$i]['problem3_rank'] = array_search((int)$results[$i]['problem3_time'], $problem_time_array[$div][2]) + 1;
				}
			}
		}
		$this->update_status(null);
		$this->update_log("Fetching match {$match->short_name} results: " . ($results === false ? 'failed' : 'done') . '.');
		return $results;
	}

	protected function do_update_match($match) {
		if ($this->db->count_all('coders') === 0) {
			$this->db->set('status', $this->map_match_status['ok']);
			$this->db->where('id', (int)$match->id);
			$this->db->update('algorithm_matches');
			return true;
		}

		$ok = true;
		$this->update_status("Updating match {$match->short_name}...");

		$this->db->set('status', $this->map_match_status['pending']);
		$this->db->where('id', (int)$match->id);
		$this->db->update('algorithm_matches');

		$results = $this->do_fetch_results($match);
		if ($results !== false) {
			$this->db->where('match_id', (int)$match->id);
			$this->db->delete('algorithm_match_results');
			if (count($results) > 0) {
				if ($this->db->insert_batch('algorithm_match_results', $results) !== true) {
					$ok = false;
				}
			}
		} else {
			$ok = false;
		}

		if ($ok) {
			$this->db->set('status', $this->map_match_status['ok']);
			$this->db->where('id', (int)$match->id);
			$this->db->update('algorithm_matches');
		}

		$this->update_status(null);
		$this->update_log("Updating match {$match->short_name}: " . ($ok === false ? 'failed' : 'done') . '.');
		return $ok;
	}

	protected function do_update_coders() {
		$ok = true;
		$this->update_status('Updating coders...');
		$matches = array();
		$pending_coders = $this->get_pending_coders();
		foreach ($pending_coders as $coder) {
			$history = fetch_algorithm_history($coder->id);
			if ($history !== false) {
				foreach ($history->row as $row) {
					$matches[(string)$row->round_id] = null;
				}
				$this->db->set('status', $this->map_coder_status['ok']);
				$this->db->where('id', (int)$coder->id);
				$this->db->update('coders');
			}
		}
		if (count($matches) > 0) {
			$this->db->set('status', $this->map_match_status['pending']);
			$this->db->where_in('id', array_keys($matches));
			$this->db->update('algorithm_matches');
		}
		foreach (array_keys($matches) as $id) {
			if (($match = $this->get_match((int)$id)) !== null) {
				$this->do_update_match($match);
			}
		}
		$this->update_status(null);
		$this->update_log('Updating coders: ' . ($ok === false ? 'failed' : 'done') . '.');
		return $ok;
	}

	protected function do_refresh_match_archive() {
		$ok = true;
		$this->update_status('Refreshing match archive...');
		$new_matches = $this->do_fetch_new_matches();
		if ($new_matches !== false && count($new_matches) > 0) {
			$this->db->insert_batch('algorithm_matches', $new_matches);
		}
		$this->update_status(null);
		$this->update_log('Refreshing match archive: ' . ($ok === false ? 'failed' : 'done') . '.');
		return $ok;
	}

	protected function do_update_match_archive() {
		$ok = true;
		$this->update_status('Updating match archive...');
		$pending_matches = $this->get_pending_matches();
		foreach ($pending_matches as $match) {
			$this->do_update_match($match);
		}
		$this->update_status(null);
		$this->update_log('Updating match archive: ' . ($ok === false ? 'failed' : 'done') . '.');
		return $ok;
	}

	protected function do_add_coders($coders) {
		$ok = true;
		$this->update_status('Adding coders...');
		$coders = $this->do_fetch_coders($coders);
		if ($coders !== false && count($coders) > 0) {
			$this->db->insert_batch('coders', $coders);
		}
		$this->update_status(null);
		$this->update_log('Adding coders: ' . ($ok === false ? 'failed' : 'done') . '.');
		return $ok;
	}

	protected function do_resolve_all_coders() {
		$this->db->set('algorithm_rating', '(SELECT `new_rating` FROM `algorithm_match_results` INNER JOIN `algorithm_matches` ON `algorithm_match_results`.`match_id` = `algorithm_matches`.`id` WHERE `algorithm_match_results`.`coder_id` = `coders`.`id` ORDER BY `algorithm_matches`.`time` DESC LIMIT 1)', false);
		$this->db->set('algorithm_volatility', '(SELECT `new_volatility` FROM `algorithm_match_results` INNER JOIN `algorithm_matches` ON `algorithm_match_results`.`match_id` = `algorithm_matches`.`id` WHERE `algorithm_match_results`.`coder_id` = `coders`.`id` ORDER BY `algorithm_matches`.`time` DESC LIMIT 1)', false);
		$this->db->set('n_algorithm_matches', '(SELECT COUNT(*) FROM `algorithm_match_results` WHERE `algorithm_match_results`.`coder_id` = `coders`.`id`)', false);
		$this->db->update('coders');
	}

	public function refresh_and_update_match_archive() {
		if ($this->lock() === false) {
			return false;
		}

		$ok = true;

		$this->update_log('Will refresh and update match archive.', false);

		$this->db->set('status', $this->map_match_status['pending']);
		$this->db->order_by('time DESC');
		$this->db->limit(3);
		$this->db->update('algorithm_matches');
		$this->update_log('Will also re-update the last 3 matches.');

		if ($ok && $this->do_refresh_match_archive() === false) {
			$ok = false;
		}

		if ($ok && $this->do_update_match_archive() === false) {
			$ok = false;
		}

		if ($ok) {
			$this->do_resolve_all_coders();
		}

		if ($ok) {
			$this->update_timestamp();
		}

		$this->unlock();
		return $ok;
	}

	public function add_coders($coders) {
		if ($this->lock() === false) {
			return false;
		}

		$ok = true;

		$this->update_log('Will add coders: ', false);

		if ($ok && $this->do_add_coders($coders) === false) {
			$ok = false;
		}

		if ($ok && $this->do_update_coders() === false) {
			$ok = false;
		}

		if ($ok) {
			$this->do_resolve_all_coders();
		}

		if ($ok) {
			$this->update_timestamp();
		}

		$this->unlock();
		return $ok;
	}
}

/* End of file algorithm_model.php */
/* Location: ./application/models/algorithm_model.php */
?>
