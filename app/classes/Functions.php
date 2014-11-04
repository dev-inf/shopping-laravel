<?php

class Functions {

	public static function convertBindingData($data) {
		$result = $data;
		$multilanguage = @$data->multilanguage;
		if (is_array($multilanguage) && !empty($multilanguage)) {
			unset($result->multilanguage);
			foreach ($multilanguage as $lang_code => $fields) {
				foreach ($fields as $field => $value) {
					$result->{'multilanguage[' . $lang_code . '][' . $field . ']'} = $value;
				}
			}
		}
		return $result;
	}

	public static function export($data) {
		if (!empty($data)) {
			$objPHPExcel = new PHPExcel();
			PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);

			// auto resize to fit data for each column from A - Z
			foreach (range('A', 'Z') as $columnID) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}

			$objWorksheet = $objPHPExcel->getActiveSheet();
			if (is_object($data[0])) {
				$data[0] = get_object_vars($data[0]);
			}

			$columns = array_keys($data[0]);
			$i = 'A';
			foreach ($columns as $column) {
				$objWorksheet->getCell($i . '1')->setValue($column);
				$i++;
			}

			$j = 2;
			foreach ($data as $items) {
				$i = 'A';
				if (is_object($items)) {
					$items = get_object_vars($items);
				}
				foreach ($items as $item) {
					$objWorksheet->getCell($i . $j)->setValue($item);
					$i++;
				}
				$j++;
			}

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			// $f = @fopen($path_to_file, 'rb');
			// if($f){
			// 	$fsize = filesize($path_to_file);
			// echo 123;die;
			header("Cache-Control: max-age=0");
			header('Content-Description: File Transfer');
			header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=export");
			header("Content-Transfer-Encoding: binary");

			$objWriter->save('php://output');
			// while(!feof($f)){
			// 	$buffer = fread($f, 1*(1024*1024));
			// 	echo $buffer;
			// 	ob_flush();
			// 	flush();
			// }
			// fclose($f);
			exit();
			// }
			// $objWriter = PHPExcel_IOFactory::createWriter('Excel5');
		}
	}

	public static function getMethodPrevious($controller = "") {
		$urlPrevios = URL::previous();
		$pathInfoPrevios = pathinfo($urlPrevios);
		$dataInfo = explode('-', $pathInfoPrevios['basename']);
		switch ($controller) {
			case 'film':
				if (count($dataInfo) > 1) {
					$dataInfo[1] = ucfirst($dataInfo[1]);
					$method = $dataInfo[1];
				} else {
					$method = $dataInfo[0];
				}

				break;

			default:
				if (count($dataInfo) > 1) {
					$dataInfo[1] = ucfirst($dataInfo[1]);
				}
				$pathInfoPrevios['basename'] = implode('', $dataInfo);
				$dataDirname = explode('/', $pathInfoPrevios['dirname']);
				$method = end($dataDirname) . '.' . $pathInfoPrevios['basename'];
				break;
		}
		return $method;
	}

	public static function checkUrl($url) {
		$headers = @get_headers($url);
		$headers = (is_array($headers)) ? implode("\n ", $headers) : $headers;
		return (bool) preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
	}

	public static function strToUrl($title, $separator = '-') {
		return Illuminate\Support\Str::slug($title, $separator);
	}

	public static function getNumeric($str) {
		$result = 0;

		if ($str != '') {
			if (!is_numeric($str)) {
				$responce = preg_replace('#\D#', '', $str);
				if ($responce != "") {
					$result = $responce;
				}
			} else {
				$result = $str;
			}
		}

		return $result;
	}

	public static function strposArray($haystack, $needles = array(), $offset = 0) {
		$chr = array();
		foreach ($needles as $needle) {
			$res = strpos($haystack, $needle, $offset);
			if ($res !== false)
				$chr[$needle] = $res;
		}
		if (empty($chr))
			return false;
		return min($chr);
	}

	public static function explodeArray($delimiters, $string) {
		$return_array = Array($string); // The array to return
		$d_count = 0;
		while (isset($delimiters[$d_count])) {
			$new_return_array = Array();
			foreach ($return_array as $el_to_split) {
				$put_in_new_return_array = explode($delimiters[$d_count], $el_to_split);
				foreach ($put_in_new_return_array as $substr) {
					$new_return_array[] = $substr;
				}
			}
			$return_array = $new_return_array; // Replace the previous return array by the next version
			$d_count++;
		}
		return $return_array; // Return the exploded elements
	}

	public static function saveLogAdmin($action, $id = "") {
		if (Route::currentRouteName() != Session::get('actionLog')) {
			$message = '';
			switch ($action) {
				case 0:$message = Auth::admin()->user()->username . ' đăng nhập';
					break;
				case 1:$message = Auth::admin()->user()->username . ' đăng xuất';
					break;
				case 2:$message = 'Xem ' . Route::currentRouteName();
					break;
				case 3:
					if ($id != 0) {
						$message = 'Tạo mới ' . Route::currentRouteName() . ' với id là: ' . $id;
					}
					break;
				case 4:
					if ($id != 0) {
						$message = 'Cập nhật ' . Route::currentRouteName() . ' với id là: ' . $id;
					}
					break;
				case 5:
					if ($id != 0) {
						$message = 'Xóa ' . Route::currentRouteName() . ' với id là: ' . $id;
					}
					break;
				case 6:$message = 'Lấy data ' . Route::currentRouteName();
					break;
			}
			if ($message != '') {
				$message .= ' trong thời gian là ' . date('d-m-Y H:i:s');
			}
			$log = new App\Modules\Admin\Models\Log;
			$log->user_id = base64_encode(Auth::admin()->user()->id);
			$log->action = Functions::encrypt(Route::currentRouteName(), date('Ymd'));
			$log->message = Functions::encrypt($message, date('Ymd'));
			$log->time = Functions::encrypt(time(), Auth::admin()->user()->id);
			$log->save();
		}
		Session::put('actionLog', Route::currentRouteName());
	}

	public static function encrypt($data, $key) {
		return base64_encode(
				mcrypt_encrypt(
						MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
				)
		);
	}

	public static function decrypt($data, $key) {
		$decode = base64_decode($data);
		return mcrypt_decrypt(
				MCRYPT_RIJNDAEL_128, $key, $decode, MCRYPT_MODE_CBC, "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"
		);
	}

	public static function getDataPosition($strData) {
		$arr = explode(',', $strData);
		$positions = DB::table('position')
						->select('fullname')
						->whereIn('id', $arr)->get();
		$dataPosition = array();
		foreach ($positions as $pos) {
			$dataPosition[] = $pos->fullname;
		}
		return implode(',', $dataPosition);
	}

	public static function getDataTags($strData) {
		$arr = explode(',', $strData);
		$dataTags = DB::table('tags')
						->select('name')
						->whereIn('id', $arr)->get();
		$tags = array();
		foreach ($dataTags as $tag) {
			$tags[] = $tag->name;
		}
		return implode(',', $tags);
	}

	static function getCurrentInfoMVC() {
		$path = \Route::currentRouteAction();
		$path = explode('\\', $path);
		if (@$path['1'] == 'Modules') {
			$module = $path['2'];
		}
		$controller_action = end($path);
		$controller_action = explode('@', $controller_action);

		$controller = str_replace('Controller', '', $controller_action['0']);
		$action = $controller_action['1'];

		$currentMvc = array(
			'module' => $module,
			'controller' => $controller,
			'action' => $action,
		);
		return $currentMvc;
	}

	static function changeDate($date) {
		$date = str_replace('//', '', $date);
		$date = str_replace('January', '1', $date);
		$date = str_replace('February', '2', $date);
		$date = str_replace('March', '3', $date);
		$date = str_replace('April', '4', $date);
		$date = str_replace('May', '5', $date);
		$date = str_replace('June', '6', $date);
		$date = str_replace('July', '7', $date);
		$date = str_replace('August', '8', $date);
		$date = str_replace('September', '9', $date);
		$date = str_replace('October', '10', $date);
		$date = str_replace('November', '11', $date);
		$date = str_replace('December', '12', $date);
		return $date;
	}

	static function getIdYoutubeFromUrl($url) {
		$url = htmlspecialchars_decode($url);
		$pattern = '%^# Match any youtube URL
			(?:https?://)?  # Optional scheme. Either http or https
			(?:www\.)?      # Optional www subdomain
			(?:             # Group host alternatives
			  youtu\.be/    # Either youtu.be,
			| youtube\.com  # or youtube.com
			  (?:           # Group path alternatives
				/embed/     # Either /embed/
			  | /v/         # or /v/
			  | /watch\?v=  # or /watch\?v=
			  )             # End path alternatives.
			)               # End host alternatives.
			([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
			$%x'
		;
		$result = preg_match($pattern, $url, $matches);
		if (false !== $result) {
			if (!empty($matches)) {
				return $matches[1];
			}
		}
		return false;
	}

}
