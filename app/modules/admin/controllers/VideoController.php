<?php
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Video as VideoModel;

class VideoController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new VideoModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::video.list');
	}

	public function modify($id){
		$langs = \Config::get('custom/language.langs');
		$video = '';

		if($id != ''){
			$video = VideoModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($video == ''){
				$video = new VideoModel;
			}
			$data = \Input::get();
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';

			$rules = array(
				'title' => 'required|unique:video,title,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			if(isset($data['id'])){
				unset($data['id']);
			}
			unset($data['_token']);
			unset($data['confirm_password']);

			$contents = array();
			foreach($data as $field => $value){
				$video->{$field} = $value;
			}

			if($validator->fails()){
				print_r($validator->messages()->toArray());
				return View::make('admin::video.form', array('video' => $video, 'id' => $id, 'langs' => $langs, 'error_messages' => $validator->messages()->toArray()));
			}

			\DB::beginTransaction();
			try{
				if($id == ''){
					$video->created_by = \Auth::admin()->user()->id;
					$video->updated_by = \Auth::admin()->user()->id;
				}else{
					$video->updated_by = \Auth::admin()->user()->id;
				}
				$video->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $video->id);
				}
				// add video content
				if(!empty($contents)){
					foreach($contents as $lang_code => $content){
						$video_content = new VideoContentsModel;
						$video_content->video_id = $video->id;
						$video_content->lang_code = $lang_code;
						foreach($content as $field => $value){
							$video_content->{$field} = $value;
						}
						$video_content->save();
					}
				}
			}catch(\Exception $e){
				\DB::rollback();
				echo $e->getMessage();die;
			}
			\DB::commit();
			return \Redirect::route('video.show')->with('success', '<strong>Success! </strong>Your action is done.');
		}

		return View::make('admin::video.form', array('video' => $video, 'id' => $id, 'langs' => $langs));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$video = new VideoModel;
		$video = $video->getExportData($params);
		\Functions::export($video);
		die;
	}

	public function getImport(){
		$resp = array(
			'success' => 0,
			'status' => '',
		);

		$file = \Input::get('file');
		$from = \Input::get('from');
		$offset = \Input::get('offset');

		$file = str_replace(\Config::get('app.url'), getcwd(), $file);

		$objReader = \PHPExcel_IOFactory::createReaderForFile($file);
		$objReader->setReadDataOnly(true);
		$file = $objReader->load($file);

		$total_rows = $file->getActiveSheet()->getHighestRow();

		if($from > $total_rows){
		// if($from > 15){
			$resp['status'] = 'stop';
			return json_encode($resp);
		}
// 		$i = 2;
// 		$inserted_data = array();
// 		$updated_data = array();
// 		\DB::disableQueryLog();


// 		// \DB::table($table)->insert($row);
// 		\DB::beginTransaction();
// 		try{
// 			while(1){
// 				$title = $file->getActiveSheet()->getCell('A' . $i)->getValue();
// 				if($title == '') break;
// 				$youtube_link = trim(str_replace('[Tập ] - ', '', $file->getActiveSheet()->getCell('Q' . $i)->getValue()));
// 				$code = explode('?', $youtube_link);
// 				if(!isset($code[1])){
// 					continue;
// 				}
// 				parse_str($code[1], $code);
// 				$code = $code['v'];

// // 				$video = new VideoModel;
// // 				$video->title = $title;
// // 				$video->url = $youtube_link;
// // 				$video->created_by = $login_user->username;
// // 				$video->created_by = $login_user->username;
// // 				$video->description = $file->getActiveSheet()->getCell('P' . $i)->getValue();
// // 				$video->cata_id = 2;
// // echo 123;
// // 				$video->save();
// // break;
// 				$data = array(
// 					'title' => $title,
// 					'url' => $youtube_link,
// 					'created_by' => $login_user->username,
// 					'updated_by' => $login_user->username,
// 					'description' => $file->getActiveSheet()->getCell('P' . $i)->getValue(),
// 					'cata_id' => 2,
// 					// 'url_vao_xem_film' => mysql_real_escape_string($file->getActiveSheet()->getCell('C' . $i)->getValue()),
// 					// 'url_hinh_dai_dien_film' => mysql_real_escape_string($file->getActiveSheet()->getCell('D' . $i)->getValue()),
// 					// 'danh_muc_film' => mysql_real_escape_string($file->getActiveSheet()->getCell('E' . $i)->getValue()),
// 					// 'the_loai' => mysql_real_escape_string($file->getActiveSheet()->getCell('F' . $i)->getValue()),
// 					// 'dao_dien' => mysql_real_escape_string($file->getActiveSheet()->getCell('G' . $i)->getValue()),
// 					// 'dien_vien' => mysql_real_escape_string($file->getActiveSheet()->getCell('H' . $i)->getValue()),
// 					// 'san_xuat' => mysql_real_escape_string($file->getActiveSheet()->getCell('I' . $i)->getValue()),
// 					// 'quoc_gia' => mysql_real_escape_string($file->getActiveSheet()->getCell('J' . $i)->getValue()),
// 					// 'thoi_luong' => mysql_real_escape_string($file->getActiveSheet()->getCell('K' . $i)->getValue()),
// 					// 'nam_phat_hanh' => mysql_real_escape_string($file->getActiveSheet()->getCell('L' . $i)->getValue()),
// 					// 'chat_luong' => mysql_real_escape_string($file->getActiveSheet()->getCell('M' . $i)->getValue()),
// 					// 'url_trailer' => mysql_real_escape_string($file->getActiveSheet()->getCell('N' . $i)->getValue()),
// 					// 'tom_tat_noi_dung' => mysql_real_escape_string($file->getActiveSheet()->getCell('O' . $i)->getValue()),
// 					// 'noi_dung' => mysql_real_escape_string($file->getActiveSheet()->getCell('P' . $i)->getValue()),
// 					// 'list_server_film' => mysql_real_escape_string($youtube_link),
// 					// 'code' => mysql_real_escape_string($code),
// 					// 'created' => NOW,
// 				);
// 	// print_r($data);die;
// 		// echo '<pre>';
// 		// print_r($data);
// 		// echo '</pre>';die;
// 				// $sql = "SELECT count(id) FROM ipos_clip WHERE code = '$code'";
// 				// $query = mysql_query($sql);
// 				// if(mysql_result($query, 0) > 0){
// 		// 			$updated_data[] = $data;
// 		// 		}else{
// 					$inserted_data[] = $data;
// 		// 		}

// 				$i++;
// 			}
// 			echo count($inserted_data);
// 			// \DB::table('video')->insert($inserted_data);
// 		}catch(Exception $e){
// 			\DB::rollback();
// 			return $e->getMessage();
// 		}
// 		\DB::commit();
		$resp['success'] = $this->importFromExcel($file, $from, $offset);
		return json_encode($resp);
	}

	protected function importFromExcel($file, $from, $offset){
		$login_user = \Auth::admin()->user();

		\DB::beginTransaction();
		$limit = $from + $offset - 1;
		try{
			while($from <= $limit){
				$title = $file->getActiveSheet()->getCell('A' . $from)->getValue();
				if($title == '') break;
				$youtube_link = trim(str_replace('[Tập ] - ', '', $file->getActiveSheet()->getCell('Q' . $from)->getValue()));
//				$code = explode('?', $youtube_link);
//				if(count($code) == 1){
//					$code = explode('/', $youtube_link);
//					if(isset($code[1])){
//						$code[1] = 'v=' . $code[1];
//					}
//				}
//				if(!isset($code[1])){
//					continue;
//				}
//				parse_str($code[1], $code);
//				$code = $code['v'];
				$code = \Functions::getIdYoutubeFromUrl($youtube_link);

				if(VideoModel::where('id_youtube', '=', $code)->where('cata_id', '=', 2)->count() == 0){
					$video = new VideoModel;
					$video->title = $title;
					$video->url = $youtube_link;
					$video->created_by = $login_user->username;
					$video->created_by = $login_user->username;
					$video->description = $file->getActiveSheet()->getCell('P' . $from)->getValue();
					$video->cata_id = 2;
					$video->id_youtube = $code;
					$video->created_by = \Auth::admin()->user()->id;
					$video->updated_by = \Auth::admin()->user()->id;
					$video->save();
				}
// break;
				$from++;
			}
			// \DB::table('video')->insert($inserted_data);
		}catch(Exception $e){
			\DB::rollback();
			return $e->getMessage();
		}
		\DB::commit();
		return $from;
	}
	
	public function postWatchVideo(){
		if(\Request::ajax()){
			$data = \Input::get();
			$dataVideo = \DB::table('video')
					->select('title', 'url', 'id_youtube')
					->where('id','=',$data['id'])
					->get();
			$respone = array();
			foreach($dataVideo as $item){
				$respone = array(
					'title' => $item->title,
					'file' => $item->url,
					'banner' => 'http://i1.ytimg.com/vi/'.$item->id_youtube.'/maxresdefault.jpg',
				);
			}
			return json_encode($respone);
		}
	}
	
	public function postUpdateTitleVideo(){
		if(\Request::ajax()){
			ini_set('max_execution_time', 0);
			$dataVideo = \DB::table('video')
					->select('id','title', 'url', 'id_youtube', 'status')
					->where('check','=',0)
					->get();
			$youtube = new \Youtube(array('key' => 'AIzaSyDSIpLBRHFiu6LdX7vQgyM_mg6n5Rxjg9U'));
       
			$title = $countView = $duration = '';
			foreach($dataVideo as $item){
				if($item->id_youtube != ''){
					$vid = $item->id_youtube;
				}else{
					$vid = \Functions::getIdYoutubeFromUrl($item->url);
				}
				if($vid != ''){
					$dataYoutube = $youtube->getVideoInfo($vid);
					if(!empty($dataYoutube)){
						$title = $dataYoutube->snippet->title;
						$countView = $dataYoutube->statistics->viewCount;
						$dataDuration = $dataYoutube->contentDetails->duration;
						list($m, $s) = sscanf($dataDuration, "PT%dM%dS");
						$duration = '00:'.$m.':'.$s;
						\DB::table('video')
							->where('id', $item->id)
							->update(array(
								'title' => $title,
								'id_youtube' => $vid,
								'view_youtube' => $countView,
								'duration' => $duration,
								'status' => 1,
								'check' => 1,
								'updated_at' => date('Y-m-d H:i:s')
							));
					}else{
						\DB::table('video')
							->where('id', $item->id)
							->update(array(
								'check' => 1,
								'updated_at' => date('Y-m-d H:i:s')
							));
					}
				}else{
					\DB::table('video')
						->where('id', $item->id)
						->update(array(
							'check' => 1,
							'updated_at' => date('Y-m-d H:i:s')
						));
				}
			}
		}
	}
}