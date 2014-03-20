@extends('layout.main')

@section('content')

<!-- Get language Begin -->
@if (Session::get('lang'))
	{{App::setLocale(Session::get('lang'))}}
@else
	{{App::setLocale('tr')}}
@endif
<!-- Get language End -->

<?php
	$mentees = DB::table('users')->where('mentor_id', Session::get('user')->id)->get();
?>

<div style="height:45px"></div>

@foreach ($mentees as $mentee)

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<b>{{$mentee->name}} {{$mentee->surname}}</b>
			</h3>
		</div>
		<div class="panel-body">
			
			<table class="table table-hover">
				<tr>
					<td style="width:350px"><span class="glyphicon glyphicon-book" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_department')}}</b></td>
					<td>{{$mentee->department}}</td>
				</tr>
				<tr>
					<td style="width:350px"><span class="glyphicon glyphicon-bookmark" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_class')}}</b></td>
					<td>{{$mentee->class}}</td>
				</tr>
				<tr>
					<td style="width:350px"><span class="glyphicon glyphicon-time" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_available_time')}}</b></td>
					<td>{{$mentee->available_time}}</td>
				</tr>
				<tr>
					<td style="width:350px"><span class="glyphicon glyphicon-list-alt" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentee_help_topics')}}</b></td>
					<td>{{$mentee->help_topics}}</td>
				</tr>
				<tr>
					<td style="width:350px"><span class="glyphicon glyphicon-star-empty" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_hobbies')}}</b></td>
					<td>{{$mentee->hobbies}}</td>
				</tr>
				<tr>
					<td style="width:350px"><span class="glyphicon glyphicon-search" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_description')}}</b></td>
					<td>{{$mentee->description}}</td>
				</tr>
			</table>

		</div>
	</div>

@endforeach

<div style="height:50px"></div>

@stop