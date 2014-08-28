
    @if(Config::get('app.use_scripts_local'))
        {{ HTML::scriptmod('js/vendor/jquery.min.js') }}
    @else
        {{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js") }}
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
    @endif

    {{ HTML::script("js/vendor/jquery.validate.min.js") }}
    {{ HTML::script("http://jqueryvalidation.org/files/dist/additional-methods.min.js") }}

    {{ HTML::script("js/vendor/jquery-form.min.js") }}

    {{ HTML::scriptmod("js/plugins.js") }}
    {{ HTML::scriptmod("js/main.js") }}

    {{ HTML::scriptmod("js/app.js") }}

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter26002131 = new Ya.Metrika({id:26002131,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/26002131" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
