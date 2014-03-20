@extends("layout.main")


@section("content")
<!-- Body Begin -->

<!-- Get language Begin -->
@if (Session::get('lang'))
	{{App::setLocale(Session::get('lang'))}}
@else
	{{App::setLocale('tr')}}
@endif
<!-- Get language End -->

		<div style="height:50px"></div>
		@if (Auth::check())

			<!-- Dashboard Begin -->

			@if (Session::get('user')->username=='admin')

				<div align="center" style="margin-bottom:20px">
					<a href="create-new-account" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus-sign" style="margin-right:5px"></span> {{Lang::get('messages.create_new_account')}} </a>
				</div>

				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>{{Lang::get('messages.admin_id')}}</th>
						<th>{{Lang::get('messages.admin_user_type')}}</th>
						<th>{{Lang::get('messages.admin_user_name')}}</th>
						<th>{{Lang::get('messages.admin_name')}}</th>
						<th>{{Lang::get('messages.admin_surname')}}</th>
						<th>{{Lang::get('messages.admin_action')}}</th>
					</tr>

					<?php $getUsers = DB::table('users')->get(); ?>

					@foreach ($getUsers as $gUser)
						<tr>
							<td style="font-weight:bold">1</td>
							<td>{{$gUser->id}}</td>
							<td>
								@if ($gUser->username=='admin')
									system
								@else
									{{$gUser->user_type}}
								@endif
							</td>
							<td>{{$gUser->username}}</td>
							<td>{{$gUser->name}}</td>
							<td>{{$gUser->surname}}</td>
							<td>
								@if ($gUser->username=='admin')
									<a href="{{ URL::to('/account/' . $gUser->id) }}" class="btn btn-primary btn-xs" disabled>{{Lang::get('messages.admin_update')}}</a>
									<a href="javascript:void(0)" class="btn btn-danger btn-xs" onClick="javascript:if(confirm('{{Lang::get('messages.admin_delete_are_you_sure')}}')) { window.location='{{ URL::to('/delete-user/' . $gUser->id) }}' }" disabled>{{Lang::get('messages.admin_delete')}}</a>
								@else
									<a href="{{ URL::to('/account/' . $gUser->id) }}" class="btn btn-primary btn-xs">{{Lang::get('messages.admin_update')}}</a>
									<a href="javascript:void(0)" class="btn btn-danger btn-xs" onClick="javascript:if(confirm('{{Lang::get('messages.admin_delete_are_you_sure')}}')) { window.location='{{ URL::to('/delete-user/' . $gUser->id) }}' }">{{Lang::get('messages.admin_delete')}}</a>
								@endif
							</td>
						</tr>
					@endforeach

				</table>

			@else

				<div class="alert alert-info">
					<span class="glyphicon glyphicon-user" style="margin-right:10px"></span>
					{{Lang::get('messages.hi')}}, <b>{{$user->name}}</b>.
					<div style="height:4px"></div>
					<span class="glyphicon glyphicon-time" style="margin-right:10px"></span>
					<?php
						$eDateTime = explode(" ", $user->last_login);
						$eTime = $eDateTime[1];
						$eDate = explode("-", $eDateTime[0]);
						$eDay = $eDate[2];
						$eMonth = $eDate[1];
						$eYear = $eDate[0];
						$eRes = $eDay.'.'.$eMonth.'.'.$eYear.' '.$eTime;
					?>
					{{Lang::get('messages.last_login')}} <i>{{$eRes}}</i>.
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" style="cursor:default">
							<span class="glyphicon glyphicon-question-sign" style="margin-right:10px"></span> {{Lang::get('messages.last_question_and_answer')}}
							<div class="navbar-right" style="margin-top:-2px">
								@if (Session::get('user')->user_type=='mentee')
									<a href="{{ URL::to('/ask-a-question') }}" class="btn btn-success btn-xs">{{Lang::get('messages.ask_a_new_question')}}</a>
								@endif
								<a href="{{ URL::to('/question-and-answer') }}" class="btn btn-primary btn-xs">{{Lang::get('messages.show_all')}}</a>
							</div>
						</h3>
					</div>
					<div class="panel-body">
						<ul class="nav nav-pills nav-stacked">

									<?php

										if (Session::get('user')->user_type=='mentor') {
											$rCount = DB::table('questions')->where('mentor_id', Session::get('user')->id)->count();
											if ($rCount<=0) {
												echo '<div class="alert alert-danger">'.Lang::get('messages.no_question_found_for_mentor_main').'</div>';
											} else {
												$questions = DB::table('questions')->where('mentor_id', Session::get('user')->id)->orderBy('id', 'desc')->take(5)->get();
												$c = 1;

									?>

									<table class="table table-hover">
										<tr>
											<th>{{Lang::get('messages.q_title_count')}}</th>
											<th>{{Lang::get('messages.q_title_date')}}</th>
											<th>{{Lang::get('messages.q_title_question')}}</th>
											<th>{{Lang::get('messages.q_title_mentee')}}</th>
											<th>{{Lang::get('messages.q_title_status')}}</th>
											<th>{{Lang::get('messages.q_title_action')}}</th>
										</tr>
										@foreach ($questions as $question)
										<?php $getMentee = DB::table('users')->where('id', $question->mentee_id)->first(); ?>
										<tr>
											<td><b>{{$c}}</b></td>
											<?php
												$eDateTime = explode(" ", $question->date_time);
												$eTime = $eDateTime[1];
												$eDate = explode("-", $eDateTime[0]);
												$eDay = $eDate[2];
												$eMonth = $eDate[1];
												$eYear = $eDate[0];
												$eRes = $eDay.'.'.$eMonth.'.'.$eYear.' '.$eTime;
											?>
											<td>{{$eRes}}</td>
											<td><a href="{{ URL::to('/question/' . $question->id) }}">{{$question->title}}</a></td>
											<td>{{$getMentee->name}} {{$getMentee->surname}}</td>
											@if ($question->isActive==0)
												<td>{{Lang::get('messages.q_title_closed')}}</td>
											@else
												<td style='color:green'>{{Lang::get('messages.q_title_active')}}</td>
											@endif
											<td>
												<a href="{{ URL::to('/question/' . $question->id) }}#writeAnswer" class="btn btn-primary btn-xs">{{Lang::get('messages.q_title_answer')}}</a>
												@if ($question->isActive==0)
													<a href="{{ URL::to('/close-question/' . $question->id . '/home') }}" class="btn btn-danger btn-xs" disabled>{{Lang::get('messages.q_title_close')}}</a>
												@else
													<a href="{{ URL::to('/close-question/' . $question->id . '/home') }}" class="btn btn-danger btn-xs">{{Lang::get('messages.q_title_close')}}</a>
												@endif
											</td>
										</tr>
										<?php $c++; ?>
										@endforeach
									</table>

									<?php

											}
										} elseif (Session::get('user')->user_type=='mentee') {
											$eCount = DB::table('questions')->where('mentee_id', Session::get('user')->id)->count();
											if ($eCount<=0) {
												echo '<div class="alert alert-warning">'.Lang::get('messages.no_question_found_for_mentee_main').'</div>';
											} else {
												$questions = DB::table('questions')->where('mentee_id', Session::get('user')->id)->orderBy('id', 'desc')->take(5)->get();
												$c = 1;

									?>

									<table class="table table-hover">
										<tr>
											<th>{{Lang::get('messages.q_title_count')}}</th>
											<th>{{Lang::get('messages.q_title_date')}}</th>
											<th>{{Lang::get('messages.q_title_question')}}</th>
											<th>{{Lang::get('messages.q_title_status')}}</th>
											<th>{{Lang::get('messages.q_title_action')}}</th>
										</tr>
										@foreach ($questions as $question)
										<?php $getMentee = DB::table('users')->where('id', $question->mentee_id)->first(); ?>
										<tr>
											<td><b>{{$c}}</b></td>
											<?php
												$eDateTime = explode(" ", $question->date_time);
												$eTime = $eDateTime[1];
												$eDate = explode("-", $eDateTime[0]);
												$eDay = $eDate[2];
												$eMonth = $eDate[1];
												$eYear = $eDate[0];
												$eRes = $eDay.'.'.$eMonth.'.'.$eYear.' '.$eTime;
											?>
											<td>{{$eRes}}</td>
											<td><a href="{{ URL::to('/question/' . $question->id) }}">{{$question->title}}</a></td>
											@if ($question->isActive==0)
												<td>{{Lang::get('messages.q_title_closed')}}</td>
											@else
												<td style='color:green'>{{Lang::get('messages.q_title_active')}}</td>
											@endif
											<td>
												<a href="{{ URL::to('/question/' . $question->id) }}#writeAnswer" class="btn btn-primary btn-xs">{{Lang::get('messages.q_title_answer')}}</a>
												@if ($question->isActive==0)
													<a href="{{ URL::to('/close-question/' . $question->id . '/home') }}" class="btn btn-danger btn-xs" disabled>{{Lang::get('messages.q_title_close')}}</a>
												@else
													<a href="{{ URL::to('/close-question/' . $question->id . '/home') }}" class="btn btn-danger btn-xs">{{Lang::get('messages.q_title_close')}}</a>
												@endif
											</td>
										</tr>
										<?php $c++; ?>
										@endforeach
									</table>

									<?php

											}
										}

									?>

						</ul>
					</div>
				</div>

			@endif

			<!-- Dashboard End -->

		@else

			<div align="center">
				<div class="panel panel-default mmLoginPanel">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-lock"></span> {{Lang::get('messages.login_title')}}
						</h3>
					</div>

					@if (Session::has('loginError'))
						@if (Session::get('loginError')=='err1')
							<div class="alert alert-danger">{{Lang::get('messages.username_and_password_required')}}</div>
						@elseif (Session::get('loginError')=='err2')
							<div class="alert alert-danger">{{Lang::get('messages.login_incorrect')}}</div>
						@else
							<div class="alert alert-danger">{{Session::get('loginError')}}</div>
						@endif
					@endif

					<div class="panel-body">
						
						{{ Form::open(array('action' => 'HomeController@login')) }}
							{{Form::token()}}
							{{ Form::text('username', Input::old('username'), array('placeholder' => Lang::get('messages.username'), 'class' => 'form-control', 'style' => 'margin:10px;width:300px')) }}
							{{ Form::password('password', array('placeholder' => Lang::get('messages.password'), 'class' => 'form-control', 'style' => 'margin:10px;width:300px')) }}
							{{ Form::submit(Lang::get('messages.login'), array('class' => 'btn btn-primary', 'style' => 'margin:10px')) }}
						{{ Form::close() }}

					</div>
				</div>
			</div>

		@endif
		<div style="height:50px"></div>
		<!-- Body End -->

@stop