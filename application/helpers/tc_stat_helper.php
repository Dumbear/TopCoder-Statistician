<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('curl_operate')) {
	function curl_operate($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_exec($ch);
		curl_close($ch);
	}
}

if (!function_exists('fetch_algorithm_match_list')) {
	function fetch_algorithm_match_list() {
		try {
			$data = new SimpleXMLElement('http://www.topcoder.com/tc?module=BasicData&c=dd_round_list', null, true);
			return $data;
		} catch (Exception $e) {
		}
		return false;
	}
}

if (!function_exists('fetch_algorithm_match_results')) {
	function fetch_algorithm_match_results($id) {
		try {
			$data = new SimpleXMLElement("http://www.topcoder.com/tc?module=BasicData&c=dd_round_results&rd={$id}", null, true);
			return $data;
		} catch (Exception $e) {
		}
		return false;
	}
}

/* End of file tc_stat_helper.php */
/* Location: ./application/helpers/tc_stat_helper.php */
?>
