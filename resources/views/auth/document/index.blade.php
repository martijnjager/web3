@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('documents'))
@section('title', 'Documents overview')

@section('content')
    @if(!auth()->user()->isClient())
    <div class="col-md-12">
        <div class="row float-right">
            <div class="col-md-6">
                <select name="project_id" class="bg-white rounded-pill form-control task_user w-200 mb-5">
                    @if(auth()->user()->project->count() > 0)
                        <option value="0" disabled selected>Select project</option>

                        @foreach(auth()->user()->project as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    @else
                        <option value="0" disabled selected>No project</option>
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">New document</button>
                <span class="alert alert-info message mt-3" role="alert" style="display: none;">
                    <strong>Select a project</strong>
                </span>
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-12">
        <table class="table table-responsive" id="dataTable">
            <thead>
            <tr>
                <th>File</th>
                <th>Project</th>
                <th>Client</th>
                @if(!auth()->user()->isClient())
                    <th>Options</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($files as $file)
                <tr>
                    <td><a href="{{ route('auth.project.document.stream', [$file->project_id, $file->id])  }}">{{ substr($file->path, strrpos($file->path, '/') + 1, strlen($file->path)) }}</a></td>
                    <td>{{ $file->project->name }}</td>
                    <td>{{ $file->project->getClient()->name }}</td>
                    <td>
                        <a class="btn btn-danger" href="#" onclick="confirmDelete('{{ substr($file->path, strrpos($file->path, '/') + 1, strlen($file->path)) }}', {{ $file->id }})">
                            {{ __('Delete')  }}
                            <form id="delete-form-{{$file->id}}" action="{{ route('auth.project.document.destroy', [$file->project->id, $file->id]) }}" method="POST" style="display: none;">
                                @method('delete')
                                @csrf
                            </form>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('script')
    <script>
        function confirmDelete(project, id) {
            var c = confirm("Are you sure you want to delete " + project + "?");

            if(c === true) {
                document.getElementById('delete-form-'+id).submit()
            }
        }

        $('[type=submit]').click(function() {

            var project_id = $('[name=project_id]').val();

            if(project_id >= 1) {
                window.location = '/dashboard/project/'+project_id+'/document/create';
            }
            else {

                $('.message').css('display', 'block');
                $('.message').css('width', '158px');

                setTimeout(function() {
                    $('.message').fadeOut("slow", function () {
                        //
                    });
                }, 3000);
            }
        });
    </script>
@endpush
