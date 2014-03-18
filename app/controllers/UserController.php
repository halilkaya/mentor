<?php

class UserController extends BaseController {

	public function get() {

		return View::make('user');

	}

	public function getMyMentor($mentor_id) {

		if (Auth::check()) {

			$mentee = DB::table('users')->where('mentor_id', $mentor_id)->count();

			if ($mentee>0) {
				return View::make('my_mentor')->with('mentor_id', $mentor_id);
			} else {
				return Redirect::to('');
			}
			
		} else {

			return Redirect::to('');

		}

	}

	public function getMyMentee() {

		if (Auth::check()) {

			return View::make('my_mentee');
			
		} else {

			return Redirect::to('');

		}

	}

	public function myProfile() {

		if (Auth::check()) {

			return View::make('my_profile');
			
		} else {

			return Redirect::to('');

		}

	}

	public function deleteUser($id) {

		if (Auth::check()) {
			if (Session::get('user')->username=='admin') {

				$getUser = DB::table('users')->where('id', $id)->first();

				$process1 = DB::table('users')->where('id', $id)->delete();
				if ($getUser->user_type=='mentor') {
					$process2 = DB::table('questions')->where('mentor_id', $id)->delete();
				} elseif ($getUser->user_type=='mentee') {
					$process2 = DB::table('questions')->where('mentee_id', $id)->delete();
				}

				if (($process1) and ($process2)) {
					return Redirect::to('');
				} else {
					return Redirect::to('');
				}

			}
		}

	}

	public function newAccount() {

		if (Auth::check()) {
			if (Session::get('user')->username=='admin') {

				return View::make('create_account');

			}
		} else {
			return Redirect::to('');
		}

	}

	public function account($id) {

		if (Auth::check()) {
			if (Session::get('user')->username=='admin') {

				return View::make('account')->with('account_id', $id);

			}
		} else {
			return Redirect::to('');
		}

	}

	public function accountSave() {

		if (Auth::check()) {
			if (Session::get('user')->username=='admin') {

				$id = $_POST['id'];
				$user_type = $_POST['user_type'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$department = $_POST['department'];
				$email = $_POST['email'];
				$class = $_POST['class'];
				$available_time = $_POST['available_time'];
				$help_topics = $_POST['help_topics'];
				$hobbies = $_POST['hobbies'];
				$description = $_POST['description'];
				$mentor_id = $_POST['mentor_id'];

				if ($user_type=='mentor') {
					$mentor_id = 0;
				}

				if ($password=='') {

					$process = DB::table('users')->where('id', $id)->update(array(
						'user_type' => $user_type,
						'username' => $username,
						'name' => $name,
						'surname' => $surname,
						'department' => $department,
						'email' => $email,
						'class' => $class,
						'available_time' => $available_time,
						'help_topics' => $help_topics,
						'hobbies' => $hobbies,
						'created' => date('Y-m-d H:i:s'),
						'last_login' => date('Y-m-d H:i:s'),
						'mentor_id' => $mentor_id
					));

				} else {

					$process = DB::table('users')->where('id', $id)->update(array(
						'user_type' => $user_type,
						'username' => $username,
						'password' => Hash::make($password),
						'name' => $name,
						'surname' => $surname,
						'department' => $department,
						'email' => $email,
						'class' => $class,
						'available_time' => $available_time,
						'help_topics' => $help_topics,
						'hobbies' => $hobbies,
						'created' => date('Y-m-d H:i:s'),
						'last_login' => date('Y-m-d H:i:s'),
						'mentor_id' => $mentor_id
					));

				}

				if ($process) {
					return Redirect::to('');
				} else {
					return 'ERROR! (1)';
				}

			}
		} else {
			return Redirect::to('');
		}

	}

	public function newAccountSave() {

		if (Auth::check()) {
			if (Session::get('user')->username=='admin') {

				$user_type = $_POST['user_type'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$department = $_POST['department'];
				$email = $_POST['email'];
				$class = $_POST['class'];
				$available_time = $_POST['available_time'];
				$help_topics = $_POST['help_topics'];
				$hobbies = $_POST['hobbies'];
				$description = $_POST['description'];
				$mentor_id = $_POST['mentor_id'];

				if ($mentor_id==' ') {
					$user_type = 'mentor';
				}

				if ($user_type=='mentor') {
					$mentor_id = 0;
				}

				$data1 = array(
						'user_type' => $user_type,
						'username' => $username,
						'password' => Hash::make($password),
						'name' => $name,
						'surname' => $surname,
						'department' => $department,
						'email' => $email,
						'class' => $class,
						'available_time' => $available_time,
						'help_topics' => $help_topics,
						'hobbies' => $hobbies,
						'created' => date('Y-m-d H:i:s'),
						'last_login' => date('Y-m-d H:i:s'),
						'mentor_id' => $mentor_id
				);

				$data2 = array(
						'user_type' => $user_type,
						'username' => $username,
						'password' => $password,
						'name' => $name,
						'surname' => $surname,
						'department' => $department,
						'email' => $email,
						'class' => $class,
						'available_time' => $available_time,
						'help_topics' => $help_topics,
						'hobbies' => $hobbies,
						'created' => date('Y-m-d H:i:s'),
						'last_login' => date('Y-m-d H:i:s'),
						'mentor_id' => $mentor_id
				);

				$process = DB::table('users')->insert($data1);

				Mail::send('emails.newaccount', $data2, function($message) use ($data2) {
					$message->to($data2['email'], $data2['name'].' '.$data2['surname'])->subject('MentorMarmara başvurun kabul edildi!');
				});

				if ($process) {
					return Redirect::to('');
				} else {
					return 'ERROR! (1)';
				}

			}
		} else {
			return Redirect::to('');
		}

	}

	public function saveProfile() {

		if (Auth::check()) {

			$password = Input::get('password');
			$password_again = Input::get('password_again');
			$name = Input::get('name');
			$surname = Input::get('surname');
			$department = Input::get('department');
			$email = Input::get('email');
			$class = Input::get('class');
			$available_time = Input::get('available_time');
			$help_topics = Input::get('help_topics');
			$hobbies = Input::get('hobbies');
			$description = Input::get('description');

			$data1 = array(
				'name' => $name,
				'surname' => $surname,
				'department' => $department,
				'email' => $email,
				'class' => $class,
				'available_time' => $available_time,
				'help_topics' => $help_topics
			);

			$rules1 = array(
				'name' => 'required',
				'surname' => 'required',
				'department' => 'required',
				'email' => 'required|email',
				'class' => 'required',
				'available_time' => 'required',
				'help_topics' => 'required'
			);

			$validation1 = Validator::make($data1, $rules1);

			if ($validation1->fails()) {
				Input::flash();
				return Redirect::to('/my_profile')
					->with('error', 'Lütfen gerekli alanları doldurunuz!')
					->with_only('only', array('name'))
					->with_only('only', array('surname'))
					->with_only('only', array('department'))
					->with_only('only', array('email'))
					->with_only('only', array('class'))
					->with_only('only', array('available_time'))
					->with_only('only', array('help_topics'));
			} else {
				
				if ($password!=null) {
					if ($password_again==null) {
						return Redirect::to('/my_profile')->with('error', 'err1');
					} elseif ($password!=$password_again) {
						return Redirect::to('/my_profile')->with('error', 'err2');
					} else {
						$changePassword = true;
					}
				} else {
					$changePassword = false;
				}

				if ($changePassword==false) {

					$update = DB::table('users')
						->where('id', Session::get('user')->id)
						->update(array(
							'name' => $name,
							'surname' => $surname,
							'department' => $department,
							'email' => $email,
							'class' => $class,
							'available_time' => $available_time,
							'help_topics' => $help_topics,
							'hobbies' => $hobbies,
							'description' => $description
						));

					if ($update) {
						return Redirect::to('/logout');
					} else {
						return Redirect::to('/my_profile')->with('error', 'err3');
					}

				} else {

					$update = DB::table('users')
						->where('id', Session::get('user')->id)
						->update(array(
							'password' => Hash::make($password),
							'name' => $name,
							'surname' => $surname,
							'department' => $department,
							'email' => $email,
							'class' => $class,
							'available_time' => $available_time,
							'help_topics' => $help_topics,
							'hobbies' => $hobbies,
							'description' => $description
						));

					if ($update) {
						return Redirect::to('/logout');
					} else {
						return Redirect::to('/my_profile')->with('error', 'err3');
					}

				}

			}

		} else {
			return Redirect::to('');
		}

	}





	// API begin

	public function apiGet() {
		$users = DB::table('users')->get();
		return Response::json($users, 200);
	}

	public function apiGetOne($id) {
		$user = DB::table('users')->where('id', $id)->first();
		return Response::json($user, 200);
	}

	public function apiPost() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$data = array(
			'user_type' => $json->user_type,
			'username' => $json->username,
			'password' => Hash::make($json->password),
			'name' => $json->name,
			'surname' => $json->surname,
			'department' => $json->department,
			'email' => $json->email,
			'class' => $json->class,
			'available_time' => $json->available_time,
			'help_topics' => $json->help_topics,
			'hobbies' => $json->hobbies,
			'description' => $json->description,
			'created' => date('Y-m-d H:i:s'),
			'last_login' => date('Y-m-d H:i:s'),
			'mentor_id' => $json->mentor_id
		);
		$data2 = array(
			'user_type' => $json->user_type,
			'username' => $json->username,
			'password' => $json->password,
			'name' => $json->name,
			'surname' => $json->surname,
			'department' => $json->department,
			'email' => $json->email,
			'class' => $json->class,
			'available_time' => $json->available_time,
			'help_topics' => $json->help_topics,
			'hobbies' => $json->hobbies,
			'description' => $json->description,
			'created' => date('Y-m-d H:i:s'),
			'last_login' => date('Y-m-d H:i:s'),
			'mentor_id' => $json->mentor_id
		);
		$process = DB::table('users')->insert($data);
		Mail::send('emails.newaccount', $data2, function($message) use ($data2) {
			$message->to($data2['email'], $data2['name'].' '.$data2['surname'])->subject('MentorMarmara başvurun kabul edildi!');
		});
		if ($process) {
			return Response::json(array('result' => 'User created!'), 201);
		} else {
			return Response::json(array('result' => 'User not created!'), 400);
		}
	}

	public function apiDelete() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$user = DB::table('users')->where('id', $json->id)->first();
		if ($user->user_type=='mentor') {
			$process2 = DB::table('questions')->where('mentor_id', $json->id)->delete();
		} elseif ($user->user_type=='mentee') {
			$process2 = DB::table('questions')->where('mentee_id', $json->id)->delete();
		}
		$process = DB::table('users')->where('id', $json->id)->delete();
		if ($process) {
			return Response::json(array('result' => 'User deleted!'), 200);
		} else {
			return Response::json(array('result' => 'User not deleted!'), 400);
		}
	}

	public function apiPut() {
		$json = file_get_contents("php://input");
		$json = json_decode($json);
		$data = array();
		if (@$json->user_type) {
			$data['user_type'] = $json->user_type;
		}
		if (@$json->username) {
			$data['username'] = $json->username;
		}
		if (@$json->password) {
			$data['password'] = Hash::make($json->password);
		}
		if (@$json->department) {
			$data['department'] = $json->department;
		}
		if (@$json->email) {
			$data['email'] = $json->email;
		}
		if (@$json->class) {
			$data['class'] = $json->class;
		}
		if (@$json->available_time) {
			$data['available_time'] = $json->available_time;
		}
		if (@$json->help_topics) {
			$data['help_topics'] = $json->help_topics;
		}
		if (@$json->hobbies) {
			$data['hobbies'] = $json->hobbies;
		}
		if (@$json->description) {
			$data['description'] = $json->description;
		}
		if (@$json->created) {
			$data['created'] = $json->created;
		}
		if (@$json->mentor_id) {
			$data['mentor_id'] = $json->mentor_id;
		}
		$process = DB::table('users')->where('id', $json->id)->update($data);
		if ($process) {
			return Response::json(array('result' => 'User updated!'), 200);
		} else {
			return Response::json(array('result' => 'User not updated!'), 400);
		}
	}

	public function apiGetMentor($id) {
		$mentee_info = DB::table('users')->where('id', $id)->first();
		$mentor = DB::table('users')->where('id', $mentee_info->mentor_id)->first();
		return Response::json($mentor, 200);
	}

	public function apiGetMentee($id) {
		$mentee = DB::table('users')->where('mentor_id', $id)->get();
		return Response::json($mentee, 200);
	}

	// API end
	
}