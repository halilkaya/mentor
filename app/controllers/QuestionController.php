<?php

class QuestionController extends BaseController {

	public function details($id) {
		
		if (Auth::check()) {

			$qic = DB::table('questions')->where('id', $id)->where(Session::get('user')->user_type.'_id', Session::get('user')->id)->count();

			if ($qic>0) {
				return View::make('question_detail')->with('question_id', $id);
			} else {
				return Redirect::to('');
			}

		} else {
			return Redirect::to('');
		}

	}

	public function close($id, $to) {

		if (Auth::check()) {

			$process = DB::table('questions')->where('id', $id)->update(array('isActive' => 0));

			if ($process) {
				if ($to=='list') {
					return Redirect::to('question-and-answer');
				} elseif ($to=='detail') {
					return Redirect::to('question/'.$id);
				} elseif ($to=='home') {
					return Redirect::to('');
				}
			}

		} else {

			return Redirect::to('');

		}

	}

	public function ask() {

		if (Auth::check()) {

			return View::make('question_ask');

		} else {

			return Redirect::to('');

		}

	}

	public function save() {

		if (Auth::check()) {

			$mentor = DB::table('users')->where('id', Session::get('user')->mentor_id)->first();

			$title = Input::get('title');
			$question = Input::get('question');

			$data1 = array(
				'title' => $title,
				'question' => $question
			);

			$rules1 = array(
				'title' => 'required',
				'question' => 'required'
			);

			$validation1 = Validator::make($data1, $rules1);

			if ($validation1->fails()) {

				Input::flash();
				return Redirect::to('ask-a-question')->with('error', 'err1')->with_only('only', array('title', 'question'));

			} else {

				$data = array(
					'mentor_id' => $mentor->id,
					'mentee_id' => Session::get('user')->id,
					'title' => $title,
					'question' => $question,
					'date_time' => date('Y-m-d H:i:s'),
					'isActive' => 1
				);

				$data2 = array(
					'mentor_id' => $mentor->id,
					'mentee_id' => Session::get('user')->id,
					'title' => $title,
					'question' => $question,
					'date_time' => date('Y-m-d H:i:s'),
					'isActive' => 1,
					'mentorEmail' => $mentor->email,
					'mentorName' => $mentor->name.' '.$mentor->surname
				);

				$process = DB::table('questions')->insert($data);

				Mail::send('emails.newquestion', $data2, function($message) use ($data2) {
					$message->to($data2['mentorEmail'], $data2['mentorName'])->subject('Yeni soru!');
				});

				if ($process) {
					$newidd = DB::table('questions')->orderby('id', 'desc')->first();
					$newid = $newidd->id;
					return Redirect::to('question/'.$newid);
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
		$questions = DB::table('questions')->get();
		return Response::json($questions, 200);
	}

	public function apiGetOne($id) {
		$question = DB::table('questions')->where('id', $id)->first();
		return Response::json($question, 200);
	}

	public function apiPost() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$data = array(
			'mentor_id' => $json->mentor_id,
			'mentee_id' => $json->mentee_id,
			'title' => $json->title,
			'question' => $json->question,
			'date_time' => date('Y-m-d H:i:s'),
			'isActive' => 1
		);
		$mentor = DB::table('users')->where('id', $json->mentor_id)->first();
		$data2 = array(
			'mentor_id' => $mentor->id,
			'mentee_id' => $json->mentee_id,
			'title' => $json->title,
			'question' => $json->question,
			'date_time' => date('Y-m-d H:i:s'),
			'isActive' => 1,
			'mentorEmail' => $mentor->email,
			'mentorName' => $mentor->name.' '.$mentor->surname
		);
		$process = DB::table('questions')->insert($data);
		Mail::send('emails.newquestion', $data2, function($message) use ($data2) {
			$message->to($data2['mentorEmail'], $data2['mentorName'])->subject('Yeni soru!');
		});
		if ($process) {
			return Response::json(array('result' => 'Question added!'), 201);
		} else {
			return Response::json(array('result' => 'Question not added!'), 400);
		}
	}

	public function apiDelete() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$process = DB::table('questions')->where('id', $json->id)->delete();
		if ($process) {
			return Response::json(array('result' => 'Question deleted!'), 200);
		} else {
			return Response::json(array('result' => 'Question not deleted!'), 400);
		}
	}

	public function apiPut() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$data = array();
		if (@$json->mentor_id) {
			$data['mentor_id'] = $json->mentor_id;
		}
		if (@$json->mentee_id) {
			$data['mentee_id'] = $json->mentee_id;
		}
		if (@$json->title) {
			$data['title'] = $json->title;
		}
		if (@$json->question) {
			$data['question'] = $json->question;
		}
		if (@$json->date_time) {
			$data['date_time'] = $json->date_time;
		}
		if (@$json->isActive) {
			$data['isActive'] = $json->isActive;
		}
		$process = DB::table('questions')->where('id', $json->id)->update($data);
		if ($process) {
			return Response::json(array('result' => 'Question updated!'), 200);
		} else {
			return Response::json(array('result' => 'Question not updated!'), 400);
		}
	}

	public function apiClose($id) {
		$process = DB::table('questions')->where('id', $id)->update(array('isActive' => 0));
		if ($process) {
			return Response::json(array('result' => 'Question closed!'), 200);
		} else {
			return Response::json(array('result' => 'Question not closed!'), 400);
		}
	}

	// API end
	
}