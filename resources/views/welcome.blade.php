<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<div class="content">
    <form action="{{ url('/addWorker') }}" method="post">
        {{ csrf_field() }}
        Worker name: <input type="text" name="workerName"><br><br>
        project name: <input type="text" name="projectName"><br><br>
        <input type="submit" value="Create Project">
    </form>

    <br>
    @foreach (\App\Project::all() as $project)
        <div style="float: left; margin-left: 40px">
            <h1>{{$project->name}}
                <a href="{{ url('project/'.$project->id.'/delete') }}">
                    <span class="glyphicon glyphicon-remove text-danger"></span>
                </a>
            </h1>

            <form method="Post" action="{{ url($project->id.'/addWorker') }}">
                {{ csrf_field() }}
                <input type="text" name="workerName">
                <button class="btn btn-primary" type="submit"> add worker</button>

            </form>

            @foreach($project->workers as $worker)

                <div>{{$worker->name}}
                    <a href="{{ url('worker/'.$worker->id.'/delete') }}">
                        <span class="glyphicon glyphicon-remove text-danger"></span>
                    </a>
                </div>

            @endforeach
        </div>
    @endforeach

</div>
</body>
</html>
