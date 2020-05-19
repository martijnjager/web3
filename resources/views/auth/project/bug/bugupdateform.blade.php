@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('bug-edit', $bug->project->id, $bug->id))
@section('title', "Edit bug")

@section('content')
    {!! Form::model($bug, ['url' => route('auth.project.bug.update', [$bug->project->id, $bug]), 'enctype' => 'multipart/form-data']) !!}
    @method('PUT')
        {{csrf_field()}}
        <div class="form-group">
            <label>Description</label>
            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>Status</label>
            {!! Form::number('status', null, ['class' => 'form-control']) !!}
        </div>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="image" class="custom-file-input">
                <label class="custom-file-label">Choose file</label>
            </div>
        </div>

        {!! Form::submit('Save data', ['class' => 'btn btn-primary mt-3']) !!}
    {!! Form::close() !!}
@endsection
