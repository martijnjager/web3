@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('project-edit', $project->id))
@section('title', "Edit project $project->name")

@section('content')

    {!! Form::model($project, ['url' => route('auth.project.update', $project), 'method' => 'put',  'enctype' =>"multipart/form-data"]) !!}
    <div class="row">
        <div class="col-md-7">
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
                            <select name="users[]" multiple data-style="bg-white rounded-pill px-4 py-3 shadow-sm" class="selectpicker form-control w-200 mb-5">
                            @foreach($developers as $key => $developer)
                                @php
                                $devs = $project->user->where('role_id', \App\Role::DEVELOPER)->pluck('id')->toArray();
                                @endphp

                                @if(in_array($key, $devs))
{{--                                @if($key == $devs->id)--}}
                                    <option value="{{ $key }}" selected="selected">{{ $developer }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $developer }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        @include('layouts.error', ['error' => 'users'])
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('Select client') !!}
                            {!! Form::select('client', $clients, $project->getClient()->id, ['data-style="bg-white rounded-pill px-4 py-3 shadow-sm"', 'class="selectpicker form-control w-200"']); !!}
                        </div>
                        @include('layouts.error', ['error' => 'client'])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
                {!! Form::number('planned_time', $project->getPlannedTime(), ['class' => 'form-control', 'min' => '1', 'placeholder' => '1']) !!}
                @include('layouts.error', ['error' => 'planned_time'])
            </div>
            <div class="col-md form-group">
                {!! Form::submit("Save", ['class' => 'btn btn-primary mt-3']) !!}
            </div>
        </div>
{{--        <div class="col-md-4">--}}
{{--            <a class="btn btn-secondary mb-2" href="{{ route('auth.project.document.create', $project->id) }}">--}}
{{--                {{ __('Create document') }}--}}
{{--            </a>--}}
{{--            <table class="table table-hover">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>Name</th>--}}
{{--                    <th>Options</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($project->file as $file)--}}
{{--                <tr>--}}
{{--                    <td><a href="{{ route('auth.project.document.stream', [$project->id, $file->id])  }}">{{ substr($file->path, strrpos($file->path, '/') + 1, strlen($file->path)) }}</a></td>--}}
{{--                    <td>--}}
{{--                        <div class="dropdown btn-group">--}}
{{--                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                Options--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
{{--                                <a class="dropdown-item" type="button" href="{{ route('auth.project.edit', $project->id) }}">--}}
{{--                                    {{ __('Details')  }}--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item" href="#" style="color: red;" onclick="confirmDelete('{{ $project->name }}', {{ $project->id }})">--}}
{{--                                    {{ __('Delete')  }}--}}
{{--                                    <form id="delete-form-{{$project->id}}" action="{{ route('auth.project.destroy', $project->id) }}" method="POST" style="display: none;">--}}
{{--                                        @method('delete')--}}
{{--                                        @csrf--}}
{{--                                    </form>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
    </div>
    {!! Form::close() !!}
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css"/>
@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
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
