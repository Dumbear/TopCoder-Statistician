<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Algorithm_html {
	public function match_result($result, $item) {
		$html = '';
		switch ($item) {
			case 'match':
				$match = $result->short_name;
				$match_url = "algorithm/match/{$result->match_id}";
				$html = "<a href=\"{$match_url}\" class=\"match\">{$match}</a>";
				break;
			case 'coder':
				$handle = $result->handle;
				$rating_class = $this->rating_class($result->new_rating);
				$coder_url = "algorithm/coder/{$result->coder_id}";
				$html = "<a href=\"{$coder_url}\" class=\"coder {$rating_class}\">{$handle}</a>";
				break;
			case 'division':
				$division = $result->division;
				$html = "{$division}";
				break;
			case 'rank':
				$rank = $result->division_rank;
				$room_url = algorithm_room_url($result->match_id, $result->coder_id);
				$html = "<a href=\"{$room_url}\">{$rank}</a>";
				break;
			case 'points':
				$points = sprintf('%.2f', (double)$result->final_points);
				$html = "{$points}";
				break;
			case 'advanced':
				$advanced = (int)$result->advanced === 1 ? 'Y' : 'N';
				$html = "{$advanced}";
				break;
			case 'problem1': case 'problem2': case 'problem3':
				$status = eval("return \$result->{$item}_status;");
				$status_class = $this->problem_status_class($status);
				$problem_id = eval("return \$result->{$item}_id;");
				$source_code_url = "algorithm/source_code/{$result->match_id}/{$result->coder_id}/{$problem_id}";
				if ($status === 'Passed System Test') {
					$points = sprintf('%.2f', (double)eval("return \$result->{$item}_final_points;"));
					$status_class = $this->language_class(eval("return \$result->{$item}_language;"));
					$html = "<a class=\"result {$status_class}\" href=\"{$source_code_url}\" target=\"_blank\">{$points}</a>";
				} else if ($status !== '' && $status !== 'Opened') {
					$html = "<a class=\"result {$status_class}\" href=\"{$source_code_url}\" target=\"_blank\">{$status}</a>";
				} else {
					$html = "<span class=\"result {$status_class}\">{$status}</span>";
				}
				break;
			case 'problem1_time': case 'problem2_time': case 'problem3_time':
				$time = eval("return \$result->{$item};");
				$time = sprintf('%d:%02d:%02d.%03d', $time / 3600000, $time / 60000 % 60, $time / 1000 % 60, $time % 1000);
				$html = "{$time}";
				break;
			case 'challenge':
				$points = sprintf('%.2f', (double)$result->challenge_points);
				$challenge_class = $this->challenge_points_class($points);
				$right = $result->n_successful_challenges;
				$wrong = $result->n_failed_challenges;
				$html = "+{$right}/-{$wrong} = <span class=\"bonus {$challenge_class}\">{$points}</span>";
				break;
			case 'new_rating':
				$rating = $result->new_rating;
				$rating_class = $this->rating_class($rating);
				$html = "<span class=\"rating {$rating_class}\">{$rating}</span>";
				break;
			case 'rating_change':
				$old_rating = (int)$result->old_rating;
				$new_rating = (int)$result->new_rating;
				$sign = ($old_rating === $new_rating ? '' : ($old_rating < $new_rating ? '▲' : '▼'));
				$rating_change = abs($old_rating - $new_rating);
				$rating_change_class = $this->rating_change_class($old_rating, $new_rating);
				$html = "<span class=\"rating-change {$rating_change_class}\">{$sign}{$rating_change}</span>";
				break;
			case 'new_volatility':
				$volatility = $result->new_volatility;
				$html = "{$volatility}";
				break;
			default:
				break;
		}
		return $html;
	}

	public function coder($coder, $item) {
		$html = '';
		switch ($item) {
			case 'handle':
				$handle = $coder->handle;
				$rating_class = $this->rating_class($coder->algorithm_rating);
				$coder_url = "algorithm/coder/{$coder->id}";
				$html = "<a href=\"{$coder_url}\" class=\"coder {$rating_class}\">{$handle}</a>";
				break;
			case 'real_name':
				$real_name = $coder->real_name;
				$html = "{$real_name}";
				break;
			case 'n_matches':
				$n_matches = $coder->n_algorithm_matches;
				$html = "{$n_matches}";
				break;
			case 'rating': case 'max_rating': case 'min_rating':
				$name = ($item === 'rating' ? 'algorithm_rating' : $item);
				$rating = eval("return \$coder->{$name};");
				$rating_class = $this->rating_class($rating);
				$html = "<span class=\"rating {$rating_class}\">{$rating}</span>";
				break;
			case 'volatility':
				$volatility = $coder->algorithm_volatility;
				$html = "{$volatility}";
				break;
			default:
				break;
		}
		return $html;
	}

	public function rating_class($rating) {
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

	public function problem_status_class($status) {
		if ($status === 'Failed System Test') {
			return 'failed';
		}
		if ($status === 'Challenge Succeeded') {
			return 'hacked';
		}
		return 'default';
	}

	public function language_class($language) {
		if ($language === 'C++') {
			return 'cpp';
		}
		if ($language === 'Java') {
			return 'java';
		}
		if ($language === 'C#') {
			return 'csharp';
		}
		if ($language === 'VB') {
			return 'vb';
		}
		return 'default';
	}

	public function challenge_points_class($points) {
		$points = (double)$points;
		if ($points > 0.0) {
			return 'up';
		}
		if ($points < 0.0) {
			return 'down';
		}
		return 'default';
	}

	public function rating_change_class($old_rating, $new_rating) {
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

/* End of file Algorithm.php */
/* Location: ./application/libraries/Algorithm.php */
?>
