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
                                    {{$project->name}} <span style="font-size: small">({{$project->room}})</span>
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection