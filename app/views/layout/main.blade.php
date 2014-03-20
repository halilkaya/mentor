<!DOCTYPE html>
<html>
<head>

{{ HTML::style('css/bootstrap.min.css') }}
{{ HTML::style('css/style.css') }}
{{ HTML::script('js/jquery.js') }}
{{ HTML::script('js/bootstrap.min.js') }}

<link rel="shortcut icon" href="img/favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>

@if (Session::get('lang'))
	{{App::setLocale(Session::get('lang'))}}
@else
	{{App::setLocale('tr')}}
@endif

@if (Request::is('/*'))
	@if (Auth::check())
		<title>{{Lang::get('messages.dashboard')}} &rarr; {{Lang::get('messages.site_title')}}</title>
	@else
		<title>{{Lang::get('messages.login_to_system')}} &rarr; {{Lang::get('messages.site_title')}}</title>
	@endif
@elseif (Request::is('my_mentor/*'))
	<title>{{Lang::get('messages.my_mentor')}} &rarr; {{Lang::get('messages.site_title')}}</title>
@elseif (Request::is('my_mentee'))
	<title>{{Lang::get('messages.my_mentee')}} &rarr; {{Lang::get('messages.site_title')}}</title>
@elseif (Request::is('question_and_answer'))
	<title>{{Lang::get('messages.question_and_answer')}} &rarr; {{Lang::get('messages.site_title')}}</title>
@elseif (Request::is('my_profile'))
	<title>{{Lang::get('messages.my_profile')}} &rarr; {{Lang::get('messages.site_title')}}</title>
@else
	<title>{{Lang::get('messages.site_title')}}</title>
@endif
	
	<div class="container">

		<div style="height:25px"></div>

		<!-- Navbar Begin -->
		<div class="navbar navbar-inverse mmNavbar navbar-fixed-top">
			<div class="container">

				<a href="{{ URL::to('/') }}" class="navbar-brand" style="color:#fff"><span class="glyphicon glyphicon-link"></span> {{Lang::get('messages.site_title')}}</a>

				@if (Auth::check())

				<button class="navbar-toggle" data-toggle="collapse" data-target=".navSec">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<div class="collapse navbar-collapse navSec">

					<ul class="nav navbar-nav navbar-right">

						@if (Session::get('user')->username!='admin') 

							@if (Request::is('/*'))
								<li><a href="{{ URL::to('/') }}" class="active" style="color:#fff"><span class="glyphicon glyphicon-dashboard"></span> {{Lang::get('messages.dashboard')}}</a></li>
							@else
								<li><a href="{{ URL::to('/') }}" style="color:#fff"><span class="glyphicon glyphicon-dashboard"></span> {{Lang::get('messages.dashboard')}}</a></li>
							@endif

							@if ((Request::is('question-and-answer')) || (Request::is('question/*')) || (Request::is('ask-a-question')))
								<li><a class="active" href="{{ URL::to('/question-and-answer') }}" style="color:#fff"><span class="glyphicon glyphicon-question-sign"></span> {{Lang::get('messages.question_and_answer')}}</a></li>
							@else
								<li><a href="{{ URL::to('/question-and-answer') }}" style="color:#fff"><span class="glyphicon glyphicon-question-sign"></span> {{Lang::get('messages.question_and_answer')}}</a></li>
							@endif

							@if (Session::get('user')->user_type=='mentee')

								@if (Request::is('my_mentor/*'))
									<li><a class="active" href="{{ URL::to('/my_mentor/' . Session::get('user')->mentor_id) }}" style="color:#fff"><span class="glyphicon glyphicon-user"></span> {{Lang::get('messages.my_mentor')}}</a></li>
								@else
									<li><a href="{{ URL::to('/my_mentor/' . Session::get('user')->mentor_id) }}" style="color:#fff"><span class="glyphicon glyphicon-user"></span> {{Lang::get('messages.my_mentor')}}</a></li>
								@endif

							@else

								@if (Request::is('my_mentee'))
									<li><a class="active" href="{{ URL::to('/my_mentee') }}" style="color:#fff"><span class="glyphicon glyphicon-user"></span> {{Lang::get('messages.my_mentee')}}</a></li>
								@else
									<li><a href="{{ URL::to('/my_mentee') }}" style="color:#fff"><span class="glyphicon glyphicon-user"></span> {{Lang::get('messages.my_mentee')}}</a></li>
								@endif

							@endif

							@if (Request::is('my_profile'))
								<li><a class="active" href="{{ URL::to('/my_profile') }}" style="color:#fff"><span class="glyphicon glyphicon-pencil"></span> {{Lang::get('messages.my_profile')}}</a></li>
							@else
								<li><a href="{{ URL::to('/my_profile') }}" style="color:#fff"><span class="glyphicon glyphicon-pencil"></span> {{Lang::get('messages.my_profile')}}</a></li>
							@endif

						@endif

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#fff"><span class="glyphicon glyphicon-flag"></span> {{Lang::get('messages.languages')}} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ URL::to('/locale/tr') }}">{{Lang::get('messages.turkish')}}</a></li>
								<li><a href="{{ URL::to('/locale/en') }}">{{Lang::get('messages.english')}}</a></li>
							</ul>
						</li>

						<li><a href="{{ URL::to('/logout') }}" style="color:#fff"><span class="glyphicon glyphicon-off"></span> {{Lang::get('messages.logout')}}</a></li>

					</ul>
				
				</div>

				@endif

			</div>
		</div>
		<!-- Navbar End -->

		@yield("content")

		<!-- Footer Begin -->
		<div style="height:50px"></div>
		<div class="navbar navbar-default navbar-fixed-bottom mmFooter">
			<div class="container">
				<div class="navbar-text">
					Copyright &copy; <?=date('Y');?> {{Lang::get('messages.copyright')}}.
				</div>
			</div>
		</div>
		<!-- Footer End -->

	</div>

</body>
</html>