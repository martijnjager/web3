@extends('layouts.auth.dashboard')
@section('breadcrumbs', Breadcrumbs::render('project-show', $project))
@section('title', "Project $project->name")

@section('content')

    @can('create-task')
    <div class="col-md-12 mb-5">
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-info" onclick="event.preventDefault(); window.location = '{{ route('auth.project.task.create', $project->id) }}'">Add Task</button>
            @can('update-project', $project)
                <button class="btn btn-secondary" onclick="event.preventDefault(); window.location = '{{ route('auth.project.edit', $project->id) }}'">View details</button>
            @endcan
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
                <th>Name</th>
                <th>Planned Time</th>
                <th>Worked time</th>
                <th>MoSCoW</th>
                <th>Status</th>
                <th>Assigned</th>
                @if(!auth()->user()->isClient())
                <th>Options</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($project->task as $task)
                <tr {{ $task->addAppropriateMark() }}>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->planned_time }}</td>
                    <td {{ $task->timerStatus() }} id="task-{{$task->id}}" data-content="{{ $task->toSeconds($task->workedTime()) }}">{{ $task->workedTime() }}</td>
                    <td>{{ $task->moscow->value }}</td>
                    <td>
                        @if($task->isFinished())
                            <i style="font-size: 28px; margin-top: -2px; color: #636b6f;" class="fa fa-check" aria-hidden="true"></i>
                        @else
                            {{ $task->status->value}}
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->isDeveloper())
                            <select name="user_id" class="bg-white rounded-pill form-control task_user w-200 mb-5" id="{{ $task->id }}">
                                <option value="{{ $task->user->id }}" selected="selected" disabled>{{ $task->user->name }}</option>
                                <option value="{{ auth()->id() }}">{{ auth()->user()->name }}</option>
                            </select>
                        @endif

                        @if(auth()->user()->isAdministrator())
                            <select name="user_id" class="bg-white rounded-pill form-control task_user w-200 mb-5" id="{{ $task->id }}">
                                @foreach($users as $key => $developer)
                                    @if($key == $task->user_id)
                                        <option value="{{ $key }}" selected="selected">{{ $developer }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $developer }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif

                        @if(auth()->user()->isClient())
                            <label for="">{{ $task->user->name }}</label>
                        @endif
                    </td>
                    <td>
                        @if(!$task->isFinished() && auth()->user()->isAdministrator())
                            <a class="btn btn-primary" href="{{ route('auth.project.task.updateTimer', $task->id) }}" onclick="event.preventDefault(); document.getElementById('update-form' + {{$task->id}}).submit()">
                                {{ $task->status->value == "running" ? 'Stop timer' : 'Start timer'}}
                                <form id="update-form{{$task->id}}" action="{{ route('auth.project.task.updateTimer', $task->id) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </a>
                            <div class="dropdown btn-group">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Options
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if(!$task->check)
                                    <a class="dropdown-item" type="button" onclick="event.preventDefault(); document.getElementById('finish-form{{$task->id}}').submit()" href="#">
                                        {{ __('Finish')  }}
                                        <form id="finish-form{{$task->id}}" action="{{ route('auth.project.task.finish', $task->id) }}" method="POST" style="display: none;">
                                            @method('patch')
                                            @csrf
                                        </form>
                                    </a>
                                    @endif
                                    <button class="dropdown-item edit" data-content="{{ $task->id }}" type="button" href="{{ route('auth.project.task.edit', [$task->project_id, $task->id]) }}">
                                        {{ __('Edit')  }}
                                    </button>
                                    <a class="dropdown-item" href="#" style="color: red;" onclick="event.preventDefault(); document.getElementById('delete-form{{$task->id}}').submit()">
                                        {{ __('Delete')  }}
                                        <form id="delete-form{{$task->id}}" action="{{ route('auth.project.task.destroy', [$project->id, $task->id]) }}" method="POST" style="display: none;">
                                            @method('delete')
                                            @csrf
                                        </form>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if(auth()->user()->isDeveloper())
                        <button class="btn btn-secondary" data-content="{{ $task->id }}" type="button" href="{{ route('auth.project.task.edit', [$task->project_id, $task->id]) }}">
                            {{ __('Edit')  }}
                        </button>
                        <button class="btn btn-danger" type="button" onclick="event.preventDefault(); document.getElementById('delete-form-{{$task->id}}').submit()">{{ __('Delete')  }}</button>
                        <form id="delete-form-{{$task->id}}" action="{{ route('auth.project.task.destroy', [$project->id, $task->id]) }}" method="POST" style="display: none;">
                            @method('delete')
                            @csrf
                        </form>
                        @endif
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

        $('.task_user').change(function() {
            let task = $(this).attr('id');
            let user = $(this).val();

            console.log(task);

            $.ajax({
                url: '/dashboard/project/'+{{$project->id}}+'/task/'+task+"/"+user,
                type: 'patch',
                dataType: 'json',
                data: {
                    '_token' : '{{ csrf_token() }}'
                },
                success: function (response) {
                    window.location = '{{route('auth.project.show', $project->id)}}'
                },
                error: function (e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });
        });

        $('.edit').click(function() {
            let id = $(this).data('content');

            $.ajax({
                url: '/dashboard/project/' + {{ $project->id }} + '/task/' + id + '/edit',
                type: 'GET',
                success: function(result) {
                    // loading modal into the page
                    $('.modal-content').html(result);
                    $('#exampleModal').modal('show');
                },
                error: function (e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });
        });
    </script>
@endpush
