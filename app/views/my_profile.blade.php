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
		<div class="alert alert-danger">{{Lang::get('messages.enter_password_again')}}</div>
	@elseif (Session::get('error')=='err2')
		<div class="alert alert-danger">{{Lang::get('messages.passwords_not_same')}}</div>
	@elseif (Session::get('error')=='err3')
		<div class="alert alert-danger">{{Lang::get('messages.profile_update_error')}}</div>
	@else
		<div class="alert alert-danger">{{Session::get('error')}}</div>
	@endif
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<b>{{Lang::get('messages.my_profile')}}</b>
		</h3>
	</div>
	<div class="panel-body">

		<div class="alert alert-warning">
			{{Lang::get('messages.profile_update_warning')}}
		</div>
		
		{{ Form::open(array('action' => 'UserController@saveProfile')) }}

		<table class="table table-hover">
			<tr>
				<td><span class="glyphicon glyphicon-user" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_username')}}</b></td>
				<td>{{ Form::text('username', Session::get('user')->username, array('placeholder' => Lang::get('messages.my_username'), 'class' => 'form-control', 'style' => '', 'disabled')) }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><small><i>{{Lang::get('messages.change_password_info')}}</i></small></td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-lock" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_password')}}</b></td>
				<td>{{ Form::password('password', array('placeholder' => Lang::get('messages.my_password'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-lock" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_password_again')}}</b></td>
				<td>{{ Form::password('password_again', array('placeholder' => Lang::get('messages.my_password_again'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-user" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_name')}}</b> <font color="red">*</font></td>
				<td>{{ Form::text('name', Session::get('user')->name, array('placeholder' => Lang::get('messages.my_name'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-user" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_surname')}}</b> <font color="red">*</font></td>
				<td>{{ Form::text('surname', Session::get('user')->surname, array('placeholder' => Lang::get('messages.my_surname'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-book" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_department')}} <font color="red">*</font></b></td>
				<td>{{ Form::text('department', Session::get('user')->department, array('placeholder' => Lang::get('messages.my_department'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-envelope" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_email')}}</b> <font color="red">*</font></td>
				<td>{{ Form::text('email', Session::get('user')->email, array('placeholder' => Lang::get('messages.my_email'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-bookmark" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_class')}}</b> <font color="red">*</font></td>
				<td>{{ Form::text('class', Session::get('user')->class, array('placeholder' => Lang::get('messages.my_class'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-time" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_available_time')}}</b> <font color="red">*</font></td>
				<td>{{ Form::text('available_time', Session::get('user')->available_time, array('placeholder' => Lang::get('messages.my_available_time'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-list-alt" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_'.Session::get('user')->user_type.'_help_topics')}}</b> <font color="red">*</font></td>
				<td>{{ Form::text('help_topics', Session::get('user')->help_topics, array('placeholder' => Lang::get('messages.my_'.Session::get('user')->user_type.'_help_topics'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-star-empty" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_hobbies')}}</b></td>
				<td>{{ Form::text('hobbies', Session::get('user')->hobbies, array('placeholder' => Lang::get('messages.my_hobbies'), 'class' => 'form-control', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td><span class="glyphicon glyphicon-search" style="margin-right:15px"></span> <b>{{Lang::get('messages.my_description')}}</b></td>
				<td>{{ Form::textarea('description', Session::get('user')->description, array('placeholder' => Lang::get('messages.my_description'), 'class' => 'form-control readOnly', 'style' => '')) }}</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><small><i><font color="red">*:</font> {{Lang::get('messages.fields_required')}}</i></small><br /><br />{{ Form::submit(Lang::get('messages.save'), array('class' => 'btn btn-primary')) }}</td>
			</tr>
		</table>

		{{ Form::close() }}

	</div>
</div>

@stop