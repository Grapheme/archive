<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
        <h3>Статус Вашего запроса изменился.</h3>
		<p>
            Добрый день, {{ $name }}.
		</p>
        <p>
            Сообщаем Вам, что статус Вашего запроса №{{ $request->id }} изменился с "{{ $status_old->name }}" на "{{ $status_new->name }}".
        </p>
        <p>
            Проверить статус запроса Вы можете <a href="{{ URL::route('status') }}">здесь</a>. Для входа используйте Ваш адрес электронной почты и пароль, который Вы получили при отправке запроса.
        </p>

	</div>
</body>
</html>