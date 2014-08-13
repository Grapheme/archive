
    @if(Config::get('app.use_scripts_local'))
        {{ HTML::scriptmod('js/vendor/jquery.min.js') }}
    @else
        {{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js") }}
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
    @endif

    {{ HTML::scriptmod("js/vendor/fotorama.js") }}
    {{ HTML::scriptmod("js/vendor/select2.js") }}
    {{ HTML::scriptmod("js/main.js") }}

    {{ HTML::scriptmod("js/app.js") }}

    <script src="/js/libs/jquery-ui-1.10.3.min.js"></script>
    <script src="/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>
    <script>
        $.fn.slider&&$(".slider").slider();
    </script>

    <style>
        .not_ready {
            outline: 0px solid #f00 !important;
        }
        .crumb-sub {
            min-width: 100px;
        }
        .w100 {
            width: 100%;
        }
        .w70 {
            width: 70%;
        }
        .pagination {
            padding: 0;
        }
        .display_none {
            display: none;
        }
        .pagination li a, .pagination li span {
            box-sizing: border-box;
            color: #0088D0;
            display: inline-block;
            font-size: 0.94rem;
            height: 2.19rem;
            line-height: 2.19rem;
            min-width: 2.19rem;
            padding: 0px 0.63rem;
            text-align: center;
            text-decoration: none;
        }
        .pagination li.active span, .pagination li.disabled span,
        .pagination li.active:hover, .pagination li.disabled:hover {
            color: #777777;
            background: #F5F5F5;
        }
        .pagination li.disabled span, .pagination li.disabled:hover {
            background: transparent;
        }

        .grade-item .grade-panel-search-results {
            margin: 0.44rem 0px 0.44rem;
        }
        .pop-univ {
            vertical-align: top;
        }
        .univ-rating {
            z-index: 99;
        }
        .educ-types {
            text-align: left;
        }
        .univ-carts .univ-info .univ-spec a {
            color: #0088CC;
            font-size: 1.13rem;
            text-decoration: none;
        }
        .univ-carts .univ-cart {
            vertical-align: top;
        }

        .univ-carts .univ-info .univ-name a {
            color: #0088CC;
            font-size: 0.69rem;
            text-decoration: none;
        }
        .bread .crumb:not(:first-child) .crumb-sub {
            top: 20px;
            line-height: 0.90rem;
        }
        .dir-univ .dir-univ-top .univ-info .desc {
            max-width: 400px;
        }
        .event-img {
            background-size: cover;
            background-position: 0 50%;
        }
        .block-right .faq-block .faq-answer {
            margin-right: 10px;
        }
        button > i.fa {
            display: none;
        }
        button[disabled='disabled'] > i.fa {
            display: inline-block;
        }
        .send-result {
            margin-top: 20px;
        }
        .error {
            color: #bc0000;
        }
        .success {
            color: #00c300;
        }
        .bold {
            font-weight: bold;
        }
        .block-left .faq-textarea {
            margin-bottom: 0;
        }
        .faq-submit {
            margin-top: 0.94rem;
        }
        .media-all-link {
            font-size: 12px;
            margin-right: 10px;
        }
        .media-item:focus {
            border: 0;
            outline: 0;
        }
        .people-ul {
            height: 129px;
            overflow: hidden;
        }
    </style>