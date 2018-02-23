@extends('layouts.app')

@section('content')
    <div class="content">
        @if (!$errors->loginErrors->isEmpty())
            <div class="text-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->loginErrors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="projects">
            @foreach (\App\Project::all() as $project)
                <div class="project-box daily-container">
                    <div class="daily-container-inner">
                        <div class="project-image">
                            <img src="{{ url('images/logo.png') }}" alt="{{$project->name}}"/>
                        </div>
                        <div class="row justify-content-around project-box-headline">
                            <h1>
                                <div class="project-name">
                                    {{$project->name}}
                                </div>
                                <div class="project-delete">
                                    <form action="{{ route('projects.destroy', [$project->id]) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <span class="fa fa-trash project-delete-icon"></span>
                                    </form>
                                </div>
                            </h1>
                        </div>
                        <div class="workers">
                            @foreach($project->workers as $employee)
                                <div class="worker-name">
                                    <span class="name">{{$employee->name}}</span>
                                    <a class="delete-icon"
                                       href="{{ route('projects.deleteEmployee', [$project->id, $employee->id]) }}">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="worker-select-box">
                            <form method="Post" action="{{ route('projects.addEmployee', [$project->id]) }}">
                                {{ csrf_field() }}

                                <select class="custom-select" name="workerName">
                                    <option value="undefind">choose worker</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>

                                <button class="btn btn-primary" type="submit">Add Employee</button>

                            </form>
                        </div>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Send Message to the Team
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Send Message to the Team</h4>
                                    </div>

                                    <div class="modal-body">
                                        {{ Form::open(['class' => 'form-horizontal', 'route' => ['projects.sendMessage',$project->id]]) }}
                                        {!! method_field('POST') !!}
                                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                            {{ Form::label('message', 'Message', ['class' => 'col-md-4 control-label']) }}

                                            <div class="col-md-6">
                                                {{ Form::textarea('message', old('message'), ['required', 'autofocus', 'class' => 'form-control', 'placeholder' => 'write your Message here ...']) }}
                                                @if ($errors->has('message'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection