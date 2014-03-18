@extends('layout.main')

@section('content')

<!-- Get language Begin -->
@if (Session::get('lang'))
	{{App::setLocale(Session::get('lang'))}}
@else
	{{App::setLocale('tr')}}
@endif
<!-- Get language End -->

<div style="height:45px"></div>

<div style="margin-bottom:15px" align="center">
	@if (Session::get('user')->user_type=='mentee')
		<a href="/mentor/public/ask-a-question" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-pencil" style="margin-right:10px"></span> {{Lang::get('messages.ask_a_new_question')}}</a>
	@endif
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<span class="glyphicon glyphicon-question-sign" style="margin-right:10px"></span> {{Lang::get('messages.question_and_answer')}}
		</h3>
	</div>
	<div class="panel-body">

		<?php

			if (Session::get('user')->user_type=='mentor') {
				$rCount = DB::table('questions')->where('mentor_id', Session::get('user')->id)->count();
				if ($rCount<=0) {
					echo '<div class="alert alert-danger">'.Lang::get('messages.no_question_found_for_mentor_main').'</div>';
				} else {
					$questions = DB::table('questions')->where('mentor_id', Session::get('user')->id)->orderBy('id', 'desc')->get();
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
				<td><a href="/mentor/public/question/{{$question->id}}">{{$question->title}}</a></td>
				<td>{{$getMentee->name}} {{$getMentee->surname}}</td>
				@if ($question->isActive==0)
					<td>{{Lang::get('messages.q_title_closed')}}</td>
				@else
					<td style='color:green'>{{Lang::get('messages.q_title_active')}}</td>
				@endif
				<td>
					<a href="/mentor/public/question/{{$question->id}}#writeAnswer" class="btn btn-primary btn-xs">{{Lang::get('messages.q_title_answer')}}</a>
					@if ($question->isActive==0)
						<a href="/mentor/public/close-question/{{$question->id}}/list" class="btn btn-danger btn-xs" disabled>{{Lang::get('messages.q_title_close')}}</a>
					@else
						<a href="/mentor/public/close-question/{{$question->id}}/list" class="btn btn-danger btn-xs">{{Lang::get('messages.q_title_close')}}</a>
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
					$questions = DB::table('questions')->where('mentee_id', Session::get('user')->id)->orderBy('id', 'desc')->get();
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
				<td><a href="/mentor/public/question/{{$question->id}}">{{$question->title}}</a></td>
				@if ($question->isActive==0)
					<td>{{Lang::get('messages.q_title_closed')}}</td>
				@else
					<td style='color:green'>{{Lang::get('messages.q_title_active')}}</td>
				@endif
				<td>
					<a href="/mentor/public/question/{{$question->id}}#writeAnswer" class="btn btn-primary btn-xs">{{Lang::get('messages.q_title_answer')}}</a>
					@if ($question->isActive==0)
						<a href="/mentor/public/close-question/{{$question->id}}/list" class="btn btn-danger btn-xs" disabled>{{Lang::get('messages.q_title_close')}}</a>
					@else
						<a href="/mentor/public/close-question/{{$question->id}}/list" class="btn btn-danger btn-xs">{{Lang::get('messages.q_title_close')}}</a>
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

	</div>
</div>

<div style="height:75px"></div>

@stop