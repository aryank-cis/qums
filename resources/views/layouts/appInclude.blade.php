<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- Header Files --}}
    @notifyCss
    {{-- Library CSS --}}
    @include('includes.header')
</head>
@include('notify::components.notify')

<body>
    {{-- Header --}}
    @include('includes.navigation')

    @include('components.sidebar')
    @include('includes.footer')
    @notifyJs
</body>
