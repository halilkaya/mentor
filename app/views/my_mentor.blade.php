@extends('layout.main')

@section('content')

<!-- Get language Begin -->
@if (Session::get('lang'))
	{{App::setLocale(Session::get('lang'))}}
@else
	{{App::setLocale('tr')}}
@endif
<!-- Get language End -->

<?php $mentorInfo = DB::table('users')->where('id', $mentor_id)->first(); ?>

<div style="height:45px"></div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<b>{{Lang::get('messages.mentor_info_title')}}</b>
		</h3>
	</div>
	<div class="panel-body">
		
		<table class="table table-hover">
			<tr>
				<td style="width:350px"><span class="glyphicon glyphicon-user" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_name')}}</b></td>
				<td>{{$mentorInfo->name}} {{$mentorInfo->surname}}</td>
			</tr>
			<tr>
				<td style="width:350px"><span class="glyphicon glyphicon-book" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_department')}}</b></td>
				<td>{{$mentorInfo->department}}</td>
			</tr>
			<tr>
				<td style="width:350px"><span class="glyphicon glyphicon-bookmark" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_class')}}</b></td>
				<td>{{$mentorInfo->class}}</td>
			</tr>
			<tr>
				<td style="width:350px"><span class="glyphicon glyphicon-time" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_available_time')}}</b></td>
				<td>{{$mentorInfo->available_time}}</td>
			</tr>
			<tr>
				<td style="width:350px"><span class="glyphicon glyphicon-list-alt" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_help_topics')}}</b></td>
				<td>{{$mentorInfo->help_topics}}</td>
			</tr>
			<tr>
				<td style="width:350px"><span class="glyphicon glyphicon-star-empty" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_hobbies')}}</b></td>
				<td>{{$mentorInfo->hobbies}}</td>
			</tr>
			<tr>
				<td style="width:350px"><span class="glyphicon glyphicon-search" style="margin-right:15px"></span> <b>{{Lang::get('messages.mentor_description')}}</b></td>
				<td>{{$mentorInfo->description}}</td>
			</tr>
		</table>

	</div>
</div>

@stop