<script src="{{ URL::asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('vendor/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('vendor/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ URL::asset('vendor/nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ URL::asset('vendor/fancybox/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ URL::asset('vendor/wow/wow.min.js') }}"></script>
<script src="{{ URL::asset('vendor/animateNumber/jquery.animateNumber.min.js') }}"></script>
<script src="{{ URL::asset('vendor/waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ URL::asset('js/topbar-virtual.js') }}"></script>
<script src="{{ URL::asset('js/moment-with-locales.js') }}"></script>
<script src="{{ URL::asset('js/app.js') }}"></script>
<script src="{{ URL::asset('js/6650c3fdcf.js') }}"></script>

@if (Route::current()->getName() == 'forum' || Route::current()->getName() == 'forums.categorie')
    <script src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>

    <script>
        // Replace the <textarea id="content"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('content', {
            language: 'fr',
        });
    </script>
@endif

@if (Auth::check())

    @if (Route::current()->getName() == 'forums.topic')

        <script src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>

        @if ($forum_topic->status == 1 && $forum_categorie->status == 1)
            <script>
                // Replace the <textarea id="content"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace('content', {
                    language: 'fr',
                });
            </script>
        @endif

    @endif

@endif

@if (Route::current()->getName() == 'cart')
    <input type="hidden" name="minDate" id="minDate" value="{{ date('Y') }}">

    <script src="{{ URL::asset('js/jquery.datetimepicker.full.min.js') }}"></script>

    <script>
        jQuery.datetimepicker.setLocale('fr');

        jQuery('#appointmentTel').datetimepicker({
            i18n: {
                fr: {
                    months: [
                        'Janvier', 'Février', 'Mars', 'Avril',
                        'Mai', 'Juin', 'Juiller', 'Août',
                        'Septembre', 'Octobre', 'Novembre', 'Décembre',
                    ],
                }
            },
            onGenerate: function(ct) {
                jQuery(this).find('.xdsoft_date.xdsoft_weekend')
                    .addClass('xdsoft_disabled');
            },
            weekends: ['01.01.2014', '02.01.2014', '03.01.2014', '04.01.2014', '05.01.2014', '06.01.2014'],
            timepicker: true,
            format: 'Y-m-d H:i',
            minDate: $('#minDate').val(),
        });

        jQuery('#appointment').datetimepicker({
            i18n: {
                fr: {
                    months: [
                        'Janvier', 'Février', 'Mars', 'Avril',
                        'Mai', 'Juin', 'Juiller', 'Août',
                        'Septembre', 'Octobre', 'Novembre', 'Décembre',
                    ],
                }
            },
            onGenerate: function(ct) {
                jQuery(this).find('.xdsoft_date.xdsoft_weekend')
                    .addClass('xdsoft_disabled');
            },
            weekends: ['01.01.2014', '02.01.2014', '03.01.2014', '04.01.2014', '05.01.2014', '06.01.2014'],
            timepicker: true,
            minDate: $('#minDate').val(),
            format: 'Y-m-d H:i'
        });
    </script>
@endif

@if (Route::current()->getName() == 'dashboard')
    <script src="{{ URL::asset('js/dashboard.min.js') }}"></script>
@endif

<script>
    window.axeptioSettings = {
        clientId: "64425b9659b38af48ea5cab7",
        cookiesVersion: "portfolio-gaetan-fr",
    };

    (function(d, s) {
        var t = d.getElementsByTagName(s)[0],
            e = d.createElement(s);
        e.async = true;
        e.src = "//static.axept.io/sdk.js";
        t.parentNode.insertBefore(e, t);
    })(document, "script");
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5E4P15ZT0C"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-5E4P15ZT0C');
</script>
