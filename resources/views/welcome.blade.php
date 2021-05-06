<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('header')
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        @include('dashboard')
    </div>
</div>
@include('footer')
</body>
</html>
