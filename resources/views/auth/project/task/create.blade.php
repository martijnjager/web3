@extends('layouts.auth.dashboard')
@section('title', 'New Task')
@section('breadcrumbs', Breadcrumbs::render('task-create', $project))
@section('content')
    <div class="col-md-12">
        {!! Form::open(['url' => route('auth.project.task.store', $project), 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="col-md">
                    <div class="form-group">
                        <label for="Title">Title:</label>
                        {!! Form::text('title', '', ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}
                        @include('layouts.error', ['error' => 'title'])
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        {!! Form::label('description') !!}
                        {!! Form::textarea('description', '', ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}
                        @include('layouts.error', ['error' => 'description'])
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        {!! Form::label('comment (optional)') !!}
                        {!! Form::textarea('comment', '', ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}
                        @include('layouts.error', ['error' => 'comment'])
                    </div>
                </div>
                <div class="col-md">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Assign to </label>
                                <select name="user_id" class="rounded-pill form-control">
                                    <option disabled selected>Not assigned</option>
                                    @foreach($developers as $developer)
                                        <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                                    @endforeach
                                </select>
                                @include('layouts.error', ['error' => 'user_id'])
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('MoSCoW') !!}
                                <select name="moscow_id" class="rounded-pill form-control">
                                    @foreach($moscow as $m)
                                        <option value="{{ $m->id }}">{{ $m->value }}</option>
                                    @endforeach
                                </select>
                                @include('layouts.error', ['error' => 'moscow_id'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        {!! Form::submit('Add task', ['class' => 'btn btn-success float-right']) !!}
{{--                        <button type="submit" class="btn btn-success float-right">Add Task</button>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md">
                    <div class="form-group">
                        {!! Form::label('Planned hours to spend on task') !!}
                        {!! Form::number('planned_time', '', ['class' => 'form-control', 'min' => '1']) !!}
                        @include('layouts.error', ['error' => 'planned_time'])
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label> Start Date : </label>
                        <input class="date form-control"  type="date" id="startdate" name="start_date">
                        @include('layouts.error', ['error' => 'start_date'])
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label> Deadline : </label>
                        <input class="date form-control"  type="date" id="deadline" name="end_date">
                        @include('layouts.error', ['error' => 'end_date'])
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css"/>
@endpush

@push('script')
    <script>
        $(function () {
            $('.selectpicker').selectpicker();
        });

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">
        $('[name=start_date]').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('[name=end_date]').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush
