@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('calendar'))
@section('title', 'Calendar')

@section('content')
    <div class="col-md-12">
        {!! $calendar->calendar() !!}
    </div>

    <div class="modal-content"></div>
@endsection

@push('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endpush

@push('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    {!! $calendar->script() !!}
@endpush

{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="container">--}}
{{--    @if (\Session::has('success'))--}}
{{--        <div class="alert alert-success">--}}
{{--            <p>{{ \Session::get('success') }}</p>--}}
{{--        </div><br />--}}
{{--    @endif--}}
{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            {!! $calendar->calendar() !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>--}}
{{--{!! $calendar->script() !!}--}}
{{--</body>--}}
{{--</html>--}}
