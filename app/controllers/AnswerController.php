<?php

class AnswerController extends BaseController {

	public function save() {
		
		if (Auth::check()) {

			$question_id = Input::get('question_id');
			$user_id = Input::get('user_id');
			$answer = Input::get('answer');

			$data1 = array('answer' => $answer);
			$rules1 = array('answer' => 'required');
			$validation1 = Validator::make($data1, $rules1);

			if ($validation1->fails()) {

				return Redirect::to('question/'.$question_id.'#writeAnswer')->with('answerError', 'err1');

			} else {

				$data = array(
					'question_id' => $question_id,
					'user_id' => $user_id,
					'answer' => $answer,
					'date_time' => date('Y-m-d H:i:s')
				);

				$ut = DB::table('users')->where('id', $user_id)->first();

				if ($ut->user_type=='mentee') {
					$emailto = DB::table('users')->where('id', $ut->mentor_id)->first()->email;
					$nameto = DB::table('users')->where('id', $ut->mentor_id)->first()->name.' '.DB::table('users')->where('id', $ut->mentor_id)->first()->surname;
					$titleto = 'Sorun devam ediyor galiba. Yeni bir cevap geldi!';
				} elseif ($ut->user_type=='mentor') {
					$getMentee = DB::table('questions')->where('id', $question_id)->first()->mentee_id;
					$emailto = DB::table('users')->where('id', $getMentee)->first()->email;
					$nameto = DB::table('users')->where('id', $getMentee)->first()->name.' '.DB::table('users')->where('id', $getMentee)->first()->surname;
					$titleto = 'Sorun cevaplandı!';
				}

				$data2 = array(
					'question_id' => $question_id,
					'user_id' => $user_id,
					'answer' => $answer,
					'date_time' => date('Y-m-d H:i:s'),
					'emailto' => $emailto,
					'nameto' => $nameto,
					'titleto' => $titleto
				);

				$process = DB::table('answers')->insert($data);

				if ($process) {

					Mail::send('emails.newanswer', $data2, function($message) use ($data2) {
						$message->to($data2['emailto'], $data2['nameto'])->subject($data2['titleto']);
					});

					DB::table('questions')->where('id', $question_id)->update(array('isActive' => 1));
					return Redirect::to('question/'.$question_id);
				} else {
					return 'ERROR!';
				}

			}

		} else {

			return Redirect::to('');

		}

	}





	// API begin

	public function apiGet() {
		$answers = DB::table('answers')->get();
		return Response::json($answers, 200);
	}

	public function apiGetOne($id) {
		$anwer = DB::table('answers')->where('id', $id)->first();
		return Response::json($anwer, 200);
	}

	public function apiPost() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$data = array(
			'question_id' => $json->question_id,
			'user_id' => $json->user_id,
			'answer' => $json->answer,
			'date_time' => date('Y-m-d H:i:s')
		);
		$user = DB::table('users')->where('id', $json->user_id)->first();
		if ($user->user_type=='mentee') {
			$emailto = DB::table('users')->where('id', $user->mentor_id)->first()->email;
			$nameto = DB::table('users')->where('id', $user->mentor_id)->first()->name.' '.DB::table('users')->where('id', $user->mentor_id)->first()->surname;
			$titleto = 'Sorun devam ediyor galiba. Yeni bir cevap geldi!';
		} elseif ($user->user_type=='mentor') {
			$getMentee = DB::table('questions')->where('id', $json->question_id)->first()->mentee_id;
			$emailto = DB::table('users')->where('id', $getMentee)->first()->email;
			$nameto = DB::table('users')->where('id', $getMentee)->first()->name.' '.DB::table('users')->where('id', $getMentee)->first()->surname;
			$titleto = 'Sorun cevaplandı!';
		}
		$data2 = array(
			'question_id' => $json->question_id,
			'user_id' => $json->user_id,
			'answer' => $json->answer,
			'date_time' => date('Y-m-d H:i:s'),
			'emailto' => $emailto,
			'nameto' => $nameto,
			'titleto' => $titleto
		);
		$process = DB::table('answers')->insert($data);
		if ($process) {
			Mail::send('emails.newanswer', $data2, function($message) use ($data2) {
				$message->to($data2['emailto'], $data2['nameto'])->subject($data2['titleto']);
			});
			return Response::json(array('result' => 'Answer added!'), 201);
		} else {
			return Response::json(array('result' => 'Answer not added!'), 400);
		}
	}

	public function apiDelete() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$process = DB::table('answers')->where('id', $json->id)->delete();
		if ($process) {
			return Response::json(array('result' => 'Answer deleted!'), 200);
		} else {
			return Response::json(array('result' => 'Answer not deleted!'), 400);
		}
	}

	public function apiPut() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$data = array();
		if (@$json->question_id) {
			$data['question_id'] = $json->question_id;
		}
		if (@$json->user_id) {
			$data['user_id'] = $json->user_id;
		}
		if (@$json->answer) {
			$data['answer'] = $json->answer;
		}
		if (@$json->date_time) {
			$data['date_time'] = $json->date_time;
		}
		$process = DB::table('answers')->where('id', $json->id)->update($data);
		if ($process) {
			return Response::json(array('result' => 'Answer updated!'), 200);
		} else {
			return Response::json(array('result' => 'Answer not updated!'), 400);
		}
	}

	// API end
	
}