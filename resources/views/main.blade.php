<html>
    <head>
        <title>{{ $settings->get('branding.site_name') }}</title>

        <base href="{{ $htmlBaseUri }}">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,400italic' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/x-icon" href="{{$settings->get('branding.favicon')}}">

        {{--custom theme begin--}}
        @if ($settings->get('branding.use_custom_theme'))
            <link rel="stylesheet" href="{{asset('storage/appearance/theme.css')}}">
        @endif
        {{--custom theme end--}}

        {{--angular styles begin--}}
		<link href="styles.b13cab02dcadc2ede4d8.bundle.css" rel="stylesheet">
		{{--angular styles end--}}

        @if ($settings->has('custom_code.css'))
            <style>{!! $settings->get('custom_code.css') !!}</style>
        @endif
	</head>

    <body>
        <app-root></app-root>

        <script>
            window.bootstrapData = "{!! $bootstrapData !!}";
        </script>

        {{--angular scripts begin--}}
		<script type="javascript/text">window.onload = function() {
            console.log('load');
            var leftSide = document.getElementsByClassName('media-icon-left');
            var rightSide = document.getElementsByClassName('media-icon-right');
            leftSide[0].onclick = function() {
                var doc = this.parentElement;
                console.log(doc.childNodes);
                for (var i = 0; i < doc.childNodes.length; i++) {
                    if (doc.childNodes[i].className == "media-grid-item") {
                        console.log(doc.childNodes[i]);
                        console.log(doc.childNodes[i].style.transform);
                        var t = doc.childNodes[i].style.transform;
                        if (t == '') {
                            var c = 170 * (i+1);
                            doc.childNodes[i].style.transform = "translate('-170px')";
                            console.log('t : ' + doc.childNodes[i].style.transform);
                        } else {
                            console.log(t);
                        }
                    }
                }
            }
            rightSide[0].onclick = function() {
                var doc = this.parentElement;
                console.log(doc.childNodes);
                for (var i = 0; i < doc.childNodes.length; i++) {
                    if (doc.childNodes[i].className == "media-grid-item") {
                        console.log(doc.childNodes[i]);
                    }
                }
            }
        }</script>
		<script type="text/javascript" src="inline.56ce65e53fbb4b41a9cf.bundle.js"></script>
		<script type="text/javascript" src="polyfills.6cf1a1a5d1d90dd1f583.bundle.js"></script>
		<script type="text/javascript" src="vendor.4fc04776621096a2a4ac.bundle.js"></script>
		<script type="text/javascript" src="main.f55f6b1ca4a228e6ba89.bundle.js"></script>
		{{--angular scripts end--}}

        @if ($settings->has('custom_code.js'))
            <script>{!! $settings->get('custom_code.js') !!}</script>
        @endif

        @if ($code = $settings->get('analytics.tracking_code'))
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', '{{ $settings->get('analytics.tracking_code') }}', 'auto');
                ga('send', 'pageview');
            </script>
        @endif
	</body>
</html>