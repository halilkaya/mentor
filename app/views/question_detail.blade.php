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

<?php
	$q = DB::table('questions')->where('id', $question_id)->first();
	$m = DB::table('users')->where('id', $q->mentee_id)->first();
?>

<center>
	<div class="btn-group">
		<a href="/mentor/public/question-and-answer" class="btn btn-default">&larr; {{Lang::get('messages.q_title_all_questions')}}</a>
		@if ($q->isActive==1)
			<a href="/mentor/public/close-question/{{$question_id}}/detail" class="btn btn-default"><span class="glyphicon glyphicon-ok-circle"></span> {{Lang::get('messages.q_title_close_if_solved')}}</a>
		@else
			<a href="/mentor/public/close-question/{{$question_id}}/detail" class="btn btn-default" disabled><span class="glyphicon glyphicon-ok-circle"></span> {{Lang::get('messages.q_title_close_if_solved')}}</a>
		@endif
		<a href="/mentor/public/question/{{$question_id}}#writeAnswer" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> {{Lang::get('messages.q_title_answer')}}</a>
	</div>
</center>

<div style="height:15px"></div>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">
			<span class="glyphicon glyphicon-question-sign" style="margin-right:10px"></span> {{$q->title}}
		</h3>
	</div>
	<div class="panel-body">
		<?php
			$viewQuestion = str_replace("\n", "<br />", $q->question);
		?>
		{{$viewQuestion}}
	</div>
	<div class="panel-footer panel-info" style="background:#e5f4fb">
		<small><span class="glyphicon glyphicon-user"></span> {{$m->name}} {{$m->surname}}</small>
		<br />
		<?php
			$eDateTime = explode(" ", $q->date_time);
			$eTime = $eDateTime[1];
			$eDate = explode("-", $eDateTime[0]);
			$eDay = $eDate[2];
			$eMonth = $eDate[1];
			$eYear = $eDate[0];
			$eRes = $eDay.'.'.$eMonth.'.'.$eYear.' '.$eTime;
		?>
		<small><span class="glyphicon glyphicon-calendar"></span> {{$eRes}}</small>
	</div>
</div>

<?php
	$answers = DB::table('answers')->where('question_id', $question_id)->orderby('id', 'desc')->get();
?>

@foreach ($answers as $answer)
	<div class="panel panel-default">
		<div class="panel-body">
			<?php
				$viewAnswer = str_replace("\n", "<br />", $answer->answer);
			?>
			{{$viewAnswer}}
		</div>
		<div class="panel-footer">
			<?php
				$aUser = DB::table('users')->where('id', $answer->user_id)->first();
				$eDateTime = explode(" ", $answer->date_time);
				$eTime = $eDateTime[1];
				$eDate = explode("-", $eDateTime[0]);
				$eDay = $eDate[2];
				$eMonth = $eDate[1];
				$eYear = $eDate[0];
				$eRes = $eDay.'.'.$eMonth.'.'.$eYear.' '.$eTime;
			?>
			<small><span class="glyphicon glyphicon-user"></span> {{$aUser->name}} {{$aUser->surname}}</small>
			<br />
			<small><span class="glyphicon glyphicon-calendar"></span> {{$eRes}}</small>
		</div>
	</div>
@endforeach

<div id="writeAnswer" style="margin-top:50px">
	<h2 class="primary"> {{Lang::get('messages.write_answer')}} </h2>

	@if (Session::has('answerError'))
		@if (Session::get('answerError')=='err1')
			<div class="alert alert-danger">
				{{Lang::get('messages.error_write_answer')}}
			</div>
		@endif
	@endif

	{{ Form::open(array('action' => 'AnswerController@save')) }}
		{{ Form::hidden('question_id', $question_id) }}
		{{ Form::hidden('user_id', Session::get('user')->id) }}
		{{ Form::textarea('answer', Input::old('answer'), array('placeholder' => Lang::get('messages.write_answer_here'), 'class' => 'form-control')) }}
		<center> {{ Form::submit(Lang::get('messages.question_send'), array('class' => 'btn btn-primary btn-lg', 'style' => 'margin-top:20px')) }} </center>
	{{ Form::close() }}
</div>

<div style="height:75px"></div>

@stop