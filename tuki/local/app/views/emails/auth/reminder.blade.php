<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<!-- <h2>Reestablecer contraseña</h2> -->
		<div>
			Para cambiar tu contraseña porfavor ve a este link: {{ URL::to('passreset/reset', array($token)) }}.<br/>
			El link dejara de ser válido en {{ Config::get('auth.reminder.expire', 60) }} minutos.
		</div>
	</body>
</html>
