<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
        <h3>Добавлен новый запрос:</h3>
		<p>
            {{ $request->content }}
		</p>

		<p>
            @if (0)
            <a href="{{ URL::route('request.edit', $request->id) }}">Обработать</a>
            @endif
            <a href="{{ URL::route('login') }}">Обработать</a>
		</p>

	</div>
</body>
</html>