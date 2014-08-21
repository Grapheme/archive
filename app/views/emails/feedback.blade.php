<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Сообщение от {{ $name }} &lt;{{ $email }}&gt;
            <hr/>
			{{ Helper::nl2br($content) }}
            <hr/>
		</p>
	</div>
</body>
</html>