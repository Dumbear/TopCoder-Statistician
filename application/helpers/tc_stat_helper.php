<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('curl_operate')) {
	function curl_operate($url) {
		exec("curl {$url} >/dev/null 2>&1 &");
	}
}

if (!function_exists('fetch_algorithm_match_list')) {
	function fetch_algorithm_match_list() {
		try {
			$data = new SimpleXMLElement('http://community.topcoder.com/tc?module=BasicData&c=dd_round_list', null, true);
			return $data;
		} catch (Exception $e) {
		}
		return false;
	}
}

if (!function_exists('fetch_coder_list')) {
	function fetch_coder_list() {
		try {
			$data = new SimpleXMLElement('http://community.topcoder.com/tc?module=BasicData&c=dd_coder_list', null, true);
			return $data;
		} catch (Exception $e) {
		}
		return false;
	}
}

if (!function_exists('fetch_algorithm_history')) {
	function fetch_algorithm_history($coder_id) {
		try {
			$data = new SimpleXMLElement("http://community.topcoder.com/tc?module=BasicData&c=dd_rating_history&cr={$coder_id}", null, true);
			return $data;
		} catch (Exception $e) {
		}
		return false;
	}
}

if (!function_exists('fetch_algorithm_match_results')) {
	function fetch_algorithm_match_results($id) {
		try {
			$data = new SimpleXMLElement("http://community.topcoder.com/tc?module=BasicData&c=dd_round_results&rd={$id}", null, true);
			return $data;
		} catch (Exception $e) {
		}
		return false;
	}
}

if (!function_exists('algorithm_coder_url')) {
	function algorithm_coder_url($coder_id) {
		return "http://community.topcoder.com/tc?module=MemberProfile&cr={$coder_id}&tab=alg";
	}
}

if (!function_exists('algorithm_match_url')) {
	function algorithm_match_url($match_id) {
		return "http://community.topcoder.com/stat?c=round_stats&rd={$match_id}";
	}
}

if (!function_exists('algorithm_room_url')) {
	function algorithm_room_url($match_id, $coder_id) {
		return "http://community.topcoder.com/stat?c=coder_room_stats&rd={$match_id}&cr={$coder_id}";
	}
}

if (!function_exists('get_rating_css')) {
	function get_rating_css($rating) {
		$rating = (int)$rating;
		if ($rating >= 3000) {
			return 'l0';
		}
		if ($rating >= 2200) {
			return 'l1';
		}
		if ($rating >= 1500) {
			return 'l2';
		}
		if ($rating >= 1200) {
			return 'l3';
		}
		if ($rating >= 900) {
			return 'l4';
		}
		if ($rating >= 0) {
			return 'l5';
		}
		return 'default';
	}
}

if (!function_exists('get_problem_status_css')) {
	function get_problem_status_css($status) {
		if ($status === 'Failed System Test') {
			return 'failed';
		}
		if ($status === 'Challenge Succeeded') {
			return 'hacked';
		}
		return 'default';
	}
}

if (!function_exists('get_language_css')) {
	function get_language_css($language) {
		//TODO: other languages
		if ($language === 'C++') {
			return 'cpp';
		}
		return 'default';
	}
}

if (!function_exists('get_challenge_points_css')) {
	function get_challenge_points_css($points) {
		$points = (double)$points;
		if ($points > 0.0) {
			return 'up';
		}
		if ($points < 0.0) {
			return 'down';
		}
		return 'default';
	}
}


if (!function_exists('get_rating_change_css')) {
	function get_rating_change_css($old_rating, $new_rating) {
		$old_rating = (int)$old_rating;
		$new_rating = (int)$new_rating;
		if ($old_rating < $new_rating) {
			return 'up';
		}
		if ($old_rating > $new_rating) {
			return 'down';
		}
		return 'default';
	}
}

/* End of file tc_stat_helper.php */
/* Location: ./application/helpers/tc_stat_helper.php */
?>
