@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('bug-create', $project_id))
@section('title', "Add bug")

@section('content')
    <form action="{{route('auth.project.bug.addImage', $project_id)}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label>Description</label>
            <input type="text" name='description' class="form-control" placeholder="Enter Description">
        </div>
        <div class="form-group">
            <label>Status</label>
            <input type="text" name="status" class="form-control" placeholder="Enter Status">
        </div>
        <input type="text" hidden name="project" value="{{ $project_id }}" class="form-control" placeholder="Enter Project Name">
        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="image" class="custom-file-input">
                <label class="custom-file-label">Choose file</label>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary mt-3">Save Data</button>

    </form>
@endsection
