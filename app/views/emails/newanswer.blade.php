<?php
	$question = DB::table('questions')->where('id', $question_id)->first();
	$mentor = DB::table('users')->where('id', $question->mentor_id)->first();
	$mentee = DB::table('users')->where('id', $question->mentee_id)->first();
?>

@if (Session::get('user')->id==$mentor->id)
	<!-- Mail for mentee -->
	<div style="border:1px solid #005e9a; border-radius:10px">
		<div style="border:1px solid #005e9a; border-radius:5px; background:#005e9a; padding:15px; color:#ffffff; font-weight:bold; font-size:25px" align="center">
			MentorMarmara
		</div>
		<div style="padding:50px; color:#004068">
			
			Selam <b>{{$mentee->name}}</b>,<br /><br />
			Mentorun <b>{{$mentor->name}}</b>, <b>{{$question->title}}</b> soruna bir cevap verdi.<br />
			Cevap aşağıda:<br /><br /><br />
			<div style="border:2px solid #C0C0C0; padding:15px; color:#111111">
				{{$answer}}
			</div><br /><br />
			Kendine iyi bak...<br /><br /><br />
			<center><a href="http://www.mentormarmara.com/mentor"><button style="border:1px solid #005e9a; padding:10px; background:#005e9a; color:#ffffff; font-weight:bold; text-decoration:none; border-radius:10px">Cevabı görüntülemek, bir cevap yazmak,<br />ya da soruyu kapatmak ister misin?</button></a></center><br />

		</div>
	</div>
@elseif (Session::get('user')->id==$mentee->id)
	<!-- Mail for mentor -->
	<div style="border:1px solid #005e9a; border-radius:10px">
		<div style="border:1px solid #005e9a; border-radius:5px; background:#005e9a; padding:15px; color:#ffffff; font-weight:bold; font-size:25px" align="center">
			MentorMarmara
		</div>
		<div style="padding:50px; color:#004068">
			
			Selam <b>{{$mentor->name}}</b>,<br /><br />
			Mentee'lerinden <b>{{$mentee->name}}</b>, <b>{{$question->title}}</b> soruna bir cevap verdi.<br />
			Cevap aşağıda:<br /><br /><br />
			<div style="border:2px solid #C0C0C0; padding:15px; color:#111111">
				{{$answer}}
			</div><br /><br />
			Kendine iyi bak...<br /><br /><br />
			<center><a href="http://www.mentormarmara.com/mentor"><button style="border:1px solid #005e9a; padding:10px; background:#005e9a; color:#ffffff; font-weight:bold; text-decoration:none; border-radius:10px">Soruyu tekrar cevaplamak ister misin?</button></a></center><br />

		</div>
	</div>
@endif