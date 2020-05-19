@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('bugs', $project_id))
@section('title', "Bug index")

@section('content')
    <div class="jumbotron">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Project</th>
                <th scope="col">Image</th>
                <th> OPTIONS </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($bugs as $bug)
                <tr>
                    <th>{{$bug->id}}</th>
                    <th>{{$bug->description}}</th>
                    <th>{{$bug->status}}</th>
                    <th>{{$bug->project->name}}</th>
                    <th><img src="{{asset('uploads/bug' . $bug->image)}}" width="100px;" height="100px;" alt="Image"></th>

                    <th><a href=" {{ route('auth.project.bug.edit', [$bug->project->id, $bug->id]) }}" class="btn btn-success">EDIT</a>
                        <a class="btn btn-danger" href="#" onclick="document.getElementById('delete-form{{$bug->id}}').submit()">
                            {{ __('DELETE')  }}
                            <form id="delete-form{{$bug->id}}" action="{{ route('auth.project.bug.delete', [$bug->project->id, $bug->id]) }}" method="POST" style="display: none;">
                                @method('delete')
                                @csrf
                            </form>
                        </a></th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
