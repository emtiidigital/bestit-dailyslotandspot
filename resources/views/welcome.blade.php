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

        <div class="row border justify-content-center mtop">
            <div class="mtop col-4">
                <form action="{{ url('/addWorker') }}" method="post">
                    {{ csrf_field() }}
                    Worker name: <input type="text" name="workerName"><br><br>
                    Worker email: <input type="text" name="workerEmail"><br><br>
                    <input class="btn btn-primary" type="submit" value="add new Worker">
                </form>
            </div>
            <div class="mtop col-4">
                <form action="{{ url('/addProject') }}" method="post">
                    {{ csrf_field() }}
                    project name:
                    <input type="text" name="projectName"><br><br>
                    <input class="btn btn-primary" type="submit" value="Create Project">
                </form>
            </div>
        </div>

        <br>
        <div class="projects">
            @foreach (\App\Project::all() as $project)
                <div class="project-box daily-container">
                    <div class="row justify-content-around">
                        <div>
                            <h1>
                                <a href="{{ url('project/'.$project->id.'/delete') }}">
                                    <span class="fa fa-trash text-danger"></span>
                                </a>
                                {{$project->name}}
                            </h1>
                        </div>
                        <div>
                            <form method="Post" action="{{ url($project->id.'/addWorker') }}">
                                {{ csrf_field() }}

                                <select class="custom-select" name="workerName">
                                    <option value="undefind">choose worker</option>
                                    @foreach($workers as $worker)
                                        <option value="{{$worker->id}}">{{$worker->name}}</option>
                                    @endforeach
                                </select>

                                <button class="btn btn-primary" type="submit"> add worker</button>

                            </form>
                        </div>
                    </div>
                    <div class="workers">
                        @foreach($project->workers as $worker)
                            <div class="worker-name">
                                <span class="name">{{$worker->name}}</span>
                                <a class="delete-icon" href="{{ url($project->id.'/deleteWorker/'.$worker->id) }}">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
