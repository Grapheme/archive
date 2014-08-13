
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{{(isset($page_title))?$page_title:Config::get('app.default_page_title')}}}</title>
        <meta name="description" content="{{{(isset($page_description))?$page_description:''}}}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        {{ HTML::stylemod('css/select2.css') }}
        {{ HTML::stylemod('css/fonts.css') }}
        {{ HTML::stylemod('css/normalize.css') }}
        {{ HTML::stylemod('css/main.css') }}
        {{ HTML::stylemod('css/fotorama.css') }}

        {{ HTML::stylemod('css/slider.css') }}

        {{ HTML::scriptmod('js/vendor/modernizr-2.6.2.min.js') }}
