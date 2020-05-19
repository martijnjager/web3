@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('projects'))
@section('title', 'Projects overview')

@section('content')
    @can('create-project')
    <div class="col-md-12 mb-5">
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-info" href="{{ route('auth.project.create') }}" {{--id="AddProject"--}}{{-- onclick="event.preventDefault(); window.location = '{{ route('auth.project.create') }}'"--}}>New Project</a>
                    <!-- Button trigger modal -->
{{--                    <button type="button" class="btn btn-primary" id="AddProject">--}}
{{--                        Launch demo modal--}}
{{--                    </button>--}}
            </div>
            <div class="col-md-9">
                @include('layouts.auth.legend')
            </div>
        </div>
    </div>
    @endcan
    <div class="col-md-12">
        <table class="table table-responsive" id="dataTable">
            <thead>
            <tr>
                <th>Project</th>
                <th>Client</th>
                <th>Deadline</th>
                <th>Planned time</th>
                <th>Worked time</th>
                @if(!auth()->user()->isClient())
                <th>Bugs</th>
                @endif
                <th>Progress</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr {{ $project->addAppropriateMark() }}>

                    <td>{{ $project->name }}</td>
                    <td>{{ $project->getClient()->name }}</td>
                    <td>{{ $project->deadline }}</td>
                    <td>{{ $project->planned_time }}</td>
                    <td {{ $project->timerStatus() }} id="project-{{$project->id}}" data-content="{{ $project->toSeconds($project->workedTime()) }}">{{ $project->workedTime() }}</td>
                    @if(!auth()->user()->isClient())
                    <td><a href="{{ route('auth.project.bug.create', $project->id) }}" class="btn btn-primary">Add bug</a></td>
                    @endif
                    <td><div class="progress">
                            @php $progress = $project->getProgress();  $taskNumber = $project->task->count() @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{$project->calculateProgressWidth()}}%; color: black"
                                 aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="{{ $taskNumber }}">
                                {{ $progress }} / {{ $taskNumber  }} tasks
                            </div>
                        </div></td>
                    <td>
                        <a href="{{ route('auth.project.show', $project->id) }}" class="btn btn-primary">View</a>
                        <a href="{{ route('auth.project.bug.index', $project->id) }}" class="btn btn-secondary">View bugs</a>
                        @role('admin')
                        <div class="dropdown btn-group">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Options
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" type="button" href="{{ route('auth.project.edit', $project->id) }}">
                                    {{ __('Details')  }}
                                </a>
                                @if(!$project->finished)
                                    <a class="dropdown-item" type="button" onclick="event.preventDefault(); document.getElementById('finish-form' + {{$project->id}}).submit()" href="#">
                                        {{ __('Finish')  }}
                                        <form id="finish-form{{$project->id}}" action="{{ route('auth.project.finish', $project->id) }}" method="POST" style="display: none;">
                                            @method('patch')
                                            @csrf
                                        </form>
                                    </a>
                                @endif
                                {{--<a class="dropdown-item" type="button" href="{{ route('auth.project.bug.edit', $project->id) }}">--}}
                                    {{--{{ __('Bug Details')  }}--}}
                                {{--</a>--}}
                                <a class="dropdown-item" href="#" style="color: red;" onclick="confirmDelete('{{ $project->name }}', {{ $project->id }})">
                                    {{ __('Delete')  }}
                                    <form id="delete-form-{{$project->id}}" action="{{ route('auth.project.destroy', $project->id) }}" method="POST" style="display: none;">
                                        @method('delete')
                                        @csrf
                                    </form>
                                </a>
                            </div>
                        </div>
                        @endrole
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal-content"></div>
@endsection

@push('script')
    <script>
        function confirmDelete(project, id) {
            var c = confirm("Are you sure you want to delete " + project + "?");

            if(c === true) {
                document.getElementById('delete-form-'+id).submit()
            }
        }

        {{--$('#AddProject').click(function(e) {--}}
        {{--    $.ajax({--}}
        {{--        type: 'GET',--}}
        {{--        url: '{{ route('auth.project.create') }}',--}}
        {{--        success: function(result) {--}}
        {{--            // loading modal into the page--}}
        {{--            $('.modal-content').html(result);--}}
        {{--            $('#exampleModal').modal('show');--}}
        {{--        },--}}
        {{--        error: function (e) {--}}
        {{--            console.log('Error processing your request: ' + e.responseText);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}


        String.prototype.toHHMMSS = function(){
            var sec_num = parseInt(this);
            var hours   = Math.floor(sec_num / 3600);
            var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
            var seconds = sec_num - (hours * 3600) - (minutes * 60);

            if(hours    < 10) {hours = "0"+hours;}
            if(minutes  < 10) {minutes = "0"+minutes;}
            if(seconds  < 10) {seconds = "0"+seconds;}
            return hours+':'+minutes+':'+seconds;
        };

        getTime = function(){

            $('.start_timer').each(function(e){
                var taskId = '#'+$(this).attr('id');
                console.log(taskId, $(taskId).data('content'));
                var total_sec = $(taskId).data('content');
                var time = String(total_sec++).toHHMMSS();

                $(taskId).text( time );
                $(taskId).data('content', total_sec);
            });
        };

        window.onload = getTime;
        setInterval(getTime, 1000);
    </script>
@endpush


