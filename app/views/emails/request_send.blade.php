<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
        <h3>Запрос успешно отправлен.</h3>
		<p>
            {{ $name }}, Ваш запрос успешно нами получен.
		</p>

        @if ($password)
        <p>
            Для просмотра статуса запроса:<br/>
            Логин: Ваш адрес электронной почты<br/>
            Пароль: {{ $password }}
        </p>
        @endif

	</div>
</body>
</html>