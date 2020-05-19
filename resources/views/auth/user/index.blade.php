@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('users'))
@section('title', 'Users overview')

@section('content')
    <div class="col-md-12 mb-5">
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-info -pull-right mr-3" onclick="event.preventDefault(); window.location = '{{ route('auth.user.create') }}'">Add user</button>
                <button class="btn btn-secondary" onclick="event.preventDefault(); window.location = '{{ route('auth.user.export') }}'">Export users</button>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-responsive table-striped" id="dataTable">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->value }}</td>
                    <td>
                        <a href="{{ route('auth.user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        <button class="btn btn-danger" type="button" onclick="event.preventDefault(); document.getElementById('delete-form').submit()">{{ __('Delete')  }}</button>
                        <form id="delete-form" action="{{ route('auth.user.destroy', $user->id) }}" method="POST" style="display: none;">
                            @method('delete')
                            @csrf
                        </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
