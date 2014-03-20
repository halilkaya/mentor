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

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<span class="glyphicon glyphicon-plus-sign" style="margin-right:10px"></span> {{Lang::get('messages.create_new_account')}}
		</h3>
	</div>
	<div class="panel-body">
		
		{{ Form::open(array('action' => 'UserController@newAccountSave')) }}
			<b>Hesap Tipi:</b> &nbsp; 
			{{ Form::radio('user_type', 'mentor', true) }} Mentor &nbsp; 
			{{ Form::radio('user_type', 'mentee', false) }} Mentee <br /><br />

			<b>Mentörü:</b> &nbsp; 
			<?php $mentors = DB::table('users')->where('user_type', 'mentor')->whereNotIn('username', array('admin'))->get(); ?>

			<?php
				$allmentors = array();
				foreach ($mentors as $mentor) {
					$allmentors[$mentor->id] = $mentor->id.' - '.$mentor->name.' '.$mentor->surname;
				}
			?>

			@if (count($allmentors)==0)
				{{ Form::hidden('mentor_id', ' ') }}
			@else
				{{ Form::select('mentor_id', $allmentors) }} &nbsp; <small><i>(Hesap tipini <b>mentor</b> olarak seçtiğinizde bu kısım işleme alınmayacaktır.)</i></small><br /><br />
			@endif
			
			{{ Form::text('username', '', array('placeholder' => 'Kullanıcı adı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::password('password', array('placeholder' => 'Şifre (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('name', '', array('placeholder' => 'Adı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('surname', '', array('placeholder' => 'Soyadı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('department', '', array('placeholder' => 'Bölümü (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('email', '', array('placeholder' => 'E-mail adresi (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('class', '', array('placeholder' => 'Sınıfı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('available_time', '', array('placeholder' => 'Uygun zamanları (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::textarea('help_topics', '', array('placeholder' => 'Yardım konuları (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::textarea('hobbies', '', array('placeholder' => 'Hobi ve ilgi alanları', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('description', '', array('placeholder' => 'Detaylar', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			<center>{{ Form::submit('Kaydet', array('class' => 'btn btn-primary btn-lg')) }}</center>
		{{ Form::close() }}

	</div>
</div>

<div style="height:75px"></div>

@stop