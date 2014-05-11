<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('curl_operate')) {
	function curl_operate($url) {
		//exec("curl -m 0 {$url} >/dev/null 2>&1 &");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_exec($ch);
		curl_close($ch);
	}
}

if (!function_exists('login_tc')) {
	function login_tc() {
		$ci = get_instance();
		$username = $ci->config->item('tc_username');
		$password = $ci->config->item('tc_password');
		$cookie_jar = $ci->config->item('cache_path') . 'tc_cookie';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://community.topcoder.com/tc');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "module=Login&username={$username}&password={$password}&rem=on");
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		curl_close($ch);
	}
}

if (!function_exists('fetch_tc_html_source')) {
	function fetch_tc_html_source($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, get_instance()->config->item('cache_path') . 'tc_cookie');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$source = curl_exec($ch);
		curl_close($ch);
		return $source;
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
			$path = get_instance()->config->item('cache_path') . 'coder_list.xml';
			if (is_readable($path)) {
				$data = new SimpleXMLElement($path, null, true);
			} else {
				$data = new SimpleXMLElement('http://community.topcoder.com/tc?module=BasicData&c=dd_coder_list', null, true);
				if (is_writable($path)) {
					$data->asXML($path);
				}
			}
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

if (!function_exists('fetch_algorithm_source_code')) {
	function fetch_algorithm_source_code($match_id, $coder_id, $problem_id) {
		$source_code = false;
		$url = "http://community.topcoder.com/stat?c=problem_solution&rd={$match_id}&cr={$coder_id}&pm={$problem_id}";
		$pattern = '/<td class="problemText" colspan="8" valign="middle" class="alignMiddle" align="left">([\s\S]*?)<\/td>/i';
		for ($i = 0; $i < 2; ++$i) {
			if ($i > 0) {
				login_tc();
			}
			$source = fetch_tc_html_source($url);
			if ($source !== false && preg_match($pattern, $source, $matches)) {
				$source_code = trim($matches[1]);
				$source_code = str_ireplace('&#160;', ' ', $source_code);
				$source_code = str_ireplace('<br>', "\n", $source_code);
				break;
			}
		}
		return $source_code;
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

/* End of file tc_stat_helper.php */
/* Location: ./application/helpers/tc_stat_helper.php */
?>
