<!DOCTYPE html>
<html>
    <head>
        {{-- googleタグマネージャー --}}
        @if (config('app.env') == 'production')
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-P646PW5');</script>
        @endif
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link href="{{ mix('/css/user.css') }}?v=16" rel="stylesheet" />
        <script src="{{ mix('/js/user.js') }}?v=16" defer></script>
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/android-chrome-192x192.png">
        @inertiaHead
    </head>
    <body>
        {{-- googleタグマネージャー --}}
        @if (config('app.env') == 'production')
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P646PW5"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        @endif
        @inertia
    </body>
</html>