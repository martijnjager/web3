@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('user-edit', $user))

@section('title', 'Update ' . $user->name)

@section('content')
    <div class="col-md-8">
        {!! Form::model($user, ['url' => route('auth.user.update', $user->id), 'method' => 'post',  'enctype' =>"multipart/form-data"] ) !!}
        @method('patch')
        <div class="col-md-5 form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            @include('layouts.error', ['error' => 'name'])
        </div>
        <div class="col-md-5 form-group">
            {!! Form::label('Email') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter email', 'autocomplete' => 'on']) !!}
            @include('layouts.error', ['error' => 'email'])
        </div>
        <div class="col-md-5 form-group">
            {!! Form::label('Password') !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter password', 'min' => '8']) !!}
        </div>
        <div class="col-md-5 form-group">
            {!! Form::label('Confirm password') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'min' => '8']) !!}
            @include('layouts.error', ['error' => 'password'])
        </div>
{{--        @role('admin')--}}
        <div class="col-md-5 form-group">
            {!! Form::label('Role') !!}
            @can('all-user')
                {!! Form::select('role_id', $roles, $user->role->id, ['class' => 'form-control']) !!}
            @else
                <select name="" id="" class="form-control" disabled>
                    <option value="{{ $user->role->id }}" selected>{{ $user->role->value }}</option>
                </select>
            @endcan
            @include('layouts.error', ['error' => 'role_id'])
        </div>
{{--        @endrole--}}
    </div>
    <div class="col-md-4">
        <label class="control-label">Profile photo</label>
        <br>
        <div style="background: transparent; border: none" class="thumbnail">
            <img id="profile_image" class="img" style="max-height: 600px" src="{{ auth()->user()->getProfileImage() }}">
        </div>
        <label class="control-label mt-3">Select File</label>
        {{ Form::file('profile_image', ['id' => 'imgInp', 'multiple' => true, 'data-show-caption' => 'true', 'class' => 'mb-3', 'data-show-upload' => 'true']) }}
        @include('layouts.error', ['error' => 'profile_image'])
        <br>
        <hr>
    </div>
    <div class="col-md-12">
        <div class="col-md-5 form-group">
            {!! Form::submit("Save", ['class' => 'btn btn-primary', 'style' => 'margin-left: 50%;']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection


@push('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile_image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    </script>
@endpush
