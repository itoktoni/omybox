<title>{{ config('website.name') }} - {{ config('website.seo') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="{{ config('website.favicon') ? Helper::files('logo/'.config('website.favicon')) : Helper::files('logo/default_favicon.png') }}" rel="shortcut icon">

<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Great+Vibes&display=swap" rel="stylesheet">

@include(Helper::setExtendFrontend('css'))
