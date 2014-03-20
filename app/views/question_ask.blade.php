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

@if (Session::has('error'))
	@if (Session::get('error')=='err1')
		<div class="alert alert-danger">
			{{Lang::get('messages.new_question_error')}}
		</div>
	@endif
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<span class="glyphicon glyphicon-pencil" style="margin-right:10px"></span> {{Lang::get('messages.ask_a_new_question')}}
		</h3>
	</div>
	<div class="panel-body">
		
		{{ Form::open(array('action' => 'QuestionController@save')) }}
			{{ Form::text('title', Input::old('title'), array('placeholder' => Lang::get('messages.question_title'), 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::textarea('question', Input::old('question'), array('placeholder' => Lang::get('messages.question_content'), 'class' => 'form-control', 'style' => '')) }}
			<center>{{ Form::submit(Lang::get('messages.question_send'), array('class' => 'btn btn-primary btn-lg', 'style' => 'margin-top:15px')) }}</center>
		{{ Form::close() }}

	</div>
</div>

<div style="height:50px"></div>

@stop