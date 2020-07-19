<title>{{ config('website.name') }} | eCommerce </title>
<meta charset="UTF-8">
<meta name="description" content="{{ config('website.description') }}">
<meta name="keywords" content="{{ config('website.description') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicon -->
<link href="{{ config('website.favicon') ? Helper::files('logo/'.config('website.favicon')) : Helper::files('logo/default_favicon.png') }}" rel="shortcut icon">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

@include(Helper::setExtendFrontend('css'))

<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->