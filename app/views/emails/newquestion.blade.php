<?php
	$mentor = DB::table('users')->where('id', $mentor_id)->first();
	$mentee = DB::table('users')->where('id', $mentee_id)->first();
?>

<div style="border:1px solid #005e9a; border-radius:10px">
	<div style="border:1px solid #005e9a; border-radius:5px; background:#005e9a; padding:15px; color:#ffffff; font-weight:bold; font-size:25px" align="center">
		MentorMarmara
	</div>
	<div style="padding:50px; color:#004068">
		
		Selam <b>{{$mentor->name}}</b>,<br /><br />
		Mentee'lerinden <b>{{$mentee->name}}</b> sana bir soru sordu.<br />
		Soru aşağıda:<br /><br /><br />
		<div style="background:#F5F5F5; border-bottom:1px solid #C0C0C0; padding:15px; font-weight:bold; color:#111111">
			{{$title}}
		</div>
		<div style="border-left:2px solid #C0C0C0; padding:15px; color:#111111">
			{{$question}}
		</div><br /><br />
		Kendine iyi bak...<br /><br /><br />
		<center><a href="http://www.mentormarmara.com/mentor"><button style="border:1px solid #005e9a; padding:10px; background:#005e9a; color:#ffffff; font-weight:bold; text-decoration:none; border-radius:10px">Soruyu hemen cevaplamak ister misin?</button></a></center><br />

	</div>
</div>