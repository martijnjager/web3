{{--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-xl" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="exampleModalLabel">Create Project</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            {!! Form::open(['url' => route('auth.project.store'), 'method' => 'post',  'enctype' =>"multipart/form-data"]) !!}--}}
{{--            <div class="modal-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-8">--}}
{{--                        <div class="col-md form-group">--}}
{{--                            {!! Form::label('Name') !!}--}}
{{--                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}--}}
{{--                            @include('layouts.error', ['error' => 'name'])--}}
{{--                        </div>--}}
{{--                        <div class="col-md form-group">--}}
{{--                            {!! Form::label('Description') !!}--}}
{{--                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}--}}
{{--                            @include('layouts.error', ['error' => 'description'])--}}
{{--                        </div>--}}
{{--                        <div class="col-md">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('Select developers') !!}--}}
{{--                                        {!! Form::select('users[]', $developers, null, ['multiple', 'data-style="bg-white rounded-pill px-4 py-3 shadow-sm"', 'class="selectpicker form-control w-200 mb-5"']); !!}--}}
{{--                                    </div>--}}
{{--                                    @include('layouts.error', ['error' => 'users'])--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('Select client') !!}--}}
{{--                                        {!! Form::select('client', $clients, null, ['data-style="bg-white rounded-pill px-4 py-3 shadow-sm"', 'class="selectpicker form-control w-200"']); !!}--}}
{{--                                    </div>--}}
{{--                                    @include('layouts.error', ['error' => 'client'])--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-4">--}}
{{--                        <div class="col-md form-group">--}}
{{--                            {!! Form::label('Start date') !!}--}}
{{--                            {!! Form::date('start_time', null, ['class' => 'form-control']) !!}--}}
{{--                            @include('layouts.error', ['error' => 'start_time'])--}}
{{--                        </div>--}}
{{--                        <div class="col-md form-group">--}}
{{--                            {!! Form::label('Deadline') !!}--}}
{{--                            {!! Form::date('deadline', null, ['class' => 'form-control']) !!}--}}
{{--                            @include('layouts.error', ['error' => 'deadline'])--}}
{{--                        </div>--}}
{{--                        <div class="col-md form-group">--}}
{{--                            {!! Form::label('Planned hours to spend on project') !!}--}}
{{--                            {!! Form::number('planned_time', null, ['class' => 'form-control', 'min' => '1', 'placeholder' => '1']) !!}--}}
{{--                            @include('layouts.error', ['error' => 'planned_time'])--}}
{{--                        </div>--}}
{{--                        --}}{{--                        <div class="col-md form-group float-right">--}}
{{--                        --}}{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                {!! Form::submit("Save", ['class' => 'btn btn-primary mr-3', 'data-dismiss' => 'modal']) !!}--}}
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--            </div>--}}
{{--            {!! Form::close() !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('project-create'))
@section('title', 'Create Project')

@section('content')

    {!! Form::open(['url' => route('auth.project.store'), 'method' => 'post',  'enctype' =>"multipart/form-data"]) !!}
    <div class="row">
        <div class="col-md-8">
            <div class="col-md form-group">
                {!! Form::label('Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
                @include('layouts.error', ['error' => 'name'])
            </div>
            <div class="col-md form-group">
                {!! Form::label('Description') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                @include('layouts.error', ['error' => 'description'])
            </div>
            <div class="col-md">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Select developers') !!}
                            {!! Form::select('users[]', $developers, null, ['multiple', 'data-style="bg-white rounded-pill px-4 py-3 shadow-sm"', 'class="selectpicker form-control w-200 mb-5"']); !!}
                        </div>
                        @include('layouts.error', ['error' => 'users'])
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Select client') !!}
                            {!! Form::select('client', $clients, null, ['data-style="bg-white rounded-pill px-4 py-3 shadow-sm"', 'class="selectpicker form-control w-200"']); !!}
                        </div>
                        @include('layouts.error', ['error' => 'client'])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md form-group">
                {!! Form::label('Start date') !!}
                {!! Form::date('start_time', null, ['class' => 'form-control']) !!}
                @include('layouts.error', ['error' => 'start_time'])
            </div>
            <div class="col-md form-group">
                {!! Form::label('Deadline') !!}
                {!! Form::date('deadline', null, ['class' => 'form-control']) !!}
                @include('layouts.error', ['error' => 'deadline'])
            </div>
            <div class="col-md form-group">
                {!! Form::label('Planned hours to spend on project') !!}
                {!! Form::number('planned_time', null, ['class' => 'form-control', 'min' => '1', 'placeholder' => '1']) !!}
                @include('layouts.error', ['error' => 'planned_time'])
            </div>
            <div class="col-md form-group">
                {!! Form::submit("Save", ['class' => 'btn btn-primary mt-5']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('script')
    <script>
        $(function () {
            $('.selectpicker').selectpicker();
        });

        $('[name=start_time]').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('[name=deadline]').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush
