<?php

class HomeController extends BaseController {

	public function home() {

		if (Auth::check()) {
			$user = Auth::getUser();
			return View::make('home')->with('user', $user);
		} else {
			return View::make('home');
		}
	}

	public function getQandA() {

		if (Auth::check()) {
			return View::make('question_and_answer');
		}

	}

	public function changeLocale($lang) {
		$defLang = Session::get('lang');
		if ($defLang==null) { $defLang='tr'; }
		App::setLocale($lang);
		if (Lang::get('messages.selected_language')==$lang) {
			Session::put('lang', $lang);
		} else {
			Session::put('lang', $defLang);
		}
		return Redirect::to('/');
	}

	public function login() {

		$getUsername = Input::get('username');
		$getPassword = Input::get('password');

		$data1 = array(
			'username' => $getUsername,
			'password' => $getPassword
		);

		$rules1 = array(
			'username' => 'required',
			'password' => 'required'
		);

		$validation1 = Validator::make($data1, $rules1);

		if ($validation1->fails()) {

			Input::flash();
			return Redirect::to('/')->with('loginError', 'err1')->with_input('only', array('username'));

		} else {

			if (Auth::attempt(array('username' => $getUsername, 'password' => $getPassword))) {
				$user = Auth::getUser();
				Session::put("user", $user);
				return Redirect::to('/');
			} else {
				Input::flash();
				return Redirect::to('/')->with('loginError', 'err2')->with_only('only', array('username'));
			}

		}

	}

	public function logout() {

		if (Auth::check()) {
			DB::table('users')->where('id', Session::get('user')->id)->update(array('last_login' => date('Y-m-d H:i:s')));
			Auth::logout();
		}

		return Redirect::to('/');

	}

}