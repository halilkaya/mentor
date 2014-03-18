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

<?php $acc = DB::table('users')->where('id', $account_id)->first(); ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<span class="glyphicon glyphicon-pencil" style="margin-right:10px"></span> Hesap Bilgileri ve Düzenleme
		</h3>
	</div>
	<div class="panel-body">
		
		{{ Form::open(array('action' => 'UserController@accountSave')) }}
			{{ Form::hidden('id', $acc->id) }}
			<b>Hesap Tipi:</b> &nbsp; 

			@if ($acc->user_type=='mentor')
				{{ Form::radio('user_type', 'mentor', true) }} Mentor &nbsp; 
				{{ Form::radio('user_type', 'mentee', false) }} Mentee <br /><br />
			@elseif ($acc->user_type=='mentee')
				{{ Form::radio('user_type', 'mentor', false) }} Mentor &nbsp; 
				{{ Form::radio('user_type', 'mentee', true) }} Mentee <br /><br />
			@endif

			<b>Mentörü:</b> &nbsp; 
			<?php $mentors = DB::table('users')->where('user_type', 'mentor')->whereNotIn('username', array('admin'))->get(); ?>

			<?php
				$allmentors = array();
				foreach ($mentors as $mentor) {
					$allmentors[$mentor->id] = $mentor->id.' - '.$mentor->name.' '.$mentor->surname;
				}
			?>

			{{ Form::select('mentor_id', $allmentors) }} &nbsp; <small><i>(Hesap tipini <b>mentor</b> olarak seçtiğinizde bu kısım işleme alınmayacaktır.)</i></small><br /><br />
			
			{{ Form::text('username', $acc->username, array('placeholder' => 'Kullanıcı adı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			<small><i>Şifreyi değiştirmek istemiyorsanız bu alanı boş bırakın.</i></small>
			{{ Form::password('password', array('placeholder' => 'Şifre (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('name', $acc->name, array('placeholder' => 'Adı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('surname', $acc->surname, array('placeholder' => 'Soyadı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('department', $acc->department, array('placeholder' => 'Bölümü (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('email', $acc->email, array('placeholder' => 'E-mail adresi (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('class', $acc->class, array('placeholder' => 'Sınıfı (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('available_time', $acc->available_time, array('placeholder' => 'Uygun zamanları (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::textarea('help_topics', $acc->help_topics, array('placeholder' => 'Yardım konuları (gerekli)', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::textarea('hobbies', $acc->hobbies, array('placeholder' => 'Hobi ve ilgi alanları', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			{{ Form::text('description', $acc->description, array('placeholder' => 'Detaylar', 'class' => 'form-control', 'style' => 'margin-bottom:15px')) }}
			<center>{{ Form::submit('Kaydet', array('class' => 'btn btn-primary btn-lg')) }}</center>
		{{ Form::close() }}

	</div>
</div>

<div style="height:75px"></div>

@stop