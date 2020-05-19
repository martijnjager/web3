<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit {{ $task->title }}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::model($task, ['url' => route('auth.project.task.update', [$task->project_id, $task->id]), 'method' => 'post']) !!}
            @method('put')
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="Title">Title:</label>
                                {!! Form::text('title', null, ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}
                                @include('layouts.error', ['error' => 'title'])
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                {!! Form::label('description') !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}
                                @include('layouts.error', ['error' => 'description'])
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                {!! Form::label('comment (optional)') !!}
                                {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}
                                @include('layouts.error', ['error' => 'comment'])
                            </div>
                        </div>
{{--                        <div class="col-md">--}}
{{--                            <div class="form-group">--}}
{{--                                --}}{{--                        <button type="submit" class="btn btn-success float-right">Add Task</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="col-md-6">
                        <div class="col-md">
                            <div class="form-group">
                                {!! Form::label('Planned hours to spend on task') !!}
                                {!! Form::number('planned_time', $task->getPlannedTime(), ['class' => 'form-control', 'min' => '1']) !!}
                                @include('layouts.error', ['error' => 'planned_time'])
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label> Start Date : </label>
                                {!! Form::date('start_date', null, ['id' => 'startdate', 'class' => 'date form-control']) !!}
                                @include('layouts.error', ['error' => 'start_date'])
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label> Deadline : </label>
                                {!! Form::date('end_date', null, ['id' => 'deadline', 'class' => 'date form-control']) !!}
                                @include('layouts.error', ['error' => 'end_date'])
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Assign to </label>
                                        @if(auth()->user()->isAdministrator() || auth()->user()->isDeveloper())
                                            @if(auth()->user()->isAdministrator())
                                            <select name="user_id" class="rounded-pill form-control">
                                                @foreach($developers as $developer)
                                                    @if($developer->id == $task->user_id)
                                                        <option value="{{ $developer->id }}" selected>{{ $developer->name }}</option>
                                                    @else
                                                        <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @else
                                                <select name="user_id" class="rounded-pill form-control">
                                                    <option value="{{ $task->user->id }}" selected disabled>{{ $task->user->name }}</option>
                                                    <option value="{{ auth()->id() }}">{{ auth()->user()->name }}</option>
                                                </select>
                                            @endif
                                        @else
                                            <select name="user_id" disabled="" class="rounded-pill form-control">
                                                <option value="{{ $task->user->id }}" selected disabled>{{ $task->user->name }}</option>
                                            </select>
                                        @endif
                                        @include('layouts.error', ['error' => 'user_id'])
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('MoSCoW') !!}
                                        <select name="moscow_id" class="rounded-pill form-control">
                                            @foreach($moscow as $m)
                                                @if($m->id == $task->moscow_id)
                                                    <option value="{{ $m->id }}" selected>{{ $m->value }}</option>
                                                @else
                                                    <option value="{{ $m->id }}">{{ $m->value }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @include('layouts.error', ['error' => 'moscow_id'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::submit("Save", ['class' => 'btn btn-primary mr-3']) !!}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



{{--@extends('layouts.auth.dashboard')--}}
{{--@section('title', "Update task $task->title")--}}
{{--@section('breadcrumbs', Breadcrumbs::render('task-edit', $task->project_id, $task->id))--}}
{{--@section('content')--}}
{{--    <div class="col-md-12">--}}
{{--        {!! Form::model($task, ['url' => route('auth.project.task.update', [$task->project_id, $task->id]), 'method' => 'put']) !!}--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-6">--}}
{{--                <div class="col-md">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="Title">Title:</label>--}}
{{--                        {!! Form::text('title', null, ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}--}}
{{--                        @include('layouts.error', ['error' => 'title'])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md">--}}
{{--                    <div class="form-group">--}}
{{--                        {!! Form::label('description') !!}--}}
{{--                        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}--}}
{{--                        @include('layouts.error', ['error' => 'description'])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md">--}}
{{--                    <div class="form-group">--}}
{{--                        {!! Form::label('comment (optional)') !!}--}}
{{--                        {!! Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5', 'cols' => '10']) !!}--}}
{{--                        @include('layouts.error', ['error' => 'comment'])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label> Assign to </label>--}}
{{--                                <select name="user_id" class="rounded-pill form-control">--}}
{{--                                    @foreach($developers as $developer)--}}
{{--                                        @if($developer->id == $task->user_id)--}}
{{--                                            <option value="{{ $developer->id }}" selected>{{ $developer->name }}</option>--}}
{{--                                        @else--}}
{{--                                            <option value="{{ $developer->id }}">{{ $developer->name }}</option>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @include('layouts.error', ['error' => 'user_id'])--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                {!! Form::label('MoSCoW') !!}--}}
{{--                                <select name="moscow_id" class="rounded-pill form-control">--}}
{{--                                    @foreach($moscow as $m)--}}
{{--                                        @if($m->id == $task->moscow_id)--}}
{{--                                            <option value="{{ $m->id }}" selected>{{ $m->value }}</option>--}}
{{--                                        @else--}}
{{--                                            <option value="{{ $m->id }}">{{ $m->value }}</option>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @include('layouts.error', ['error' => 'moscow_id'])--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md">--}}
{{--                    <div class="form-group">--}}
{{--                        {!! Form::submit('Add task', ['class' => 'btn btn-success float-right']) !!}--}}
{{--                        --}}{{--                        <button type="submit" class="btn btn-success float-right">Add Task</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-4">--}}
{{--                <div class="col-md">--}}
{{--                    <div class="form-group">--}}
{{--                        {!! Form::label('Planned hours to spend on task') !!}--}}
{{--                        {!! Form::number('planned_time', $task->getPlannedTime(), ['class' => 'form-control', 'min' => '1']) !!}--}}
{{--                        @include('layouts.error', ['error' => 'planned_time'])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md">--}}
{{--                    <div class="form-group">--}}
{{--                        <label> Start Date : </label>--}}
{{--                        {!! Form::date('start_date', null, ['id' => 'startdate', 'class' => 'date form-control']) !!}--}}
{{--                        @include('layouts.error', ['error' => 'start_date'])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md">--}}
{{--                    <div class="form-group">--}}
{{--                        <label> Deadline : </label>--}}
{{--                        {!! Form::date('end_date', null, ['id' => 'deadline', 'class' => 'date form-control']) !!}--}}
{{--                        @include('layouts.error', ['error' => 'end_date'])--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        {!! Form::close() !!}--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@push('css')--}}
{{--@endpush--}}

{{--@push('script')--}}
    <script>
        $(function () {
            $('.selectpicker').selectpicker();
        });

    </script>
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
{{--@endpush--}}
