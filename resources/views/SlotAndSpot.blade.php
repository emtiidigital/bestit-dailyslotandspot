<!doctype html>
<head>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/filter.js') }}"></script>
</head>
<body>
<div class="input-group"><span class="input-group-addon">Filter</span>

    <input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Time</th>
        <th>Spot 1</th>
        <th>Spot 2</th>
        <th>Spot 3</th>
    </tr>
    </thead>

    <tbody class="searchable">

    <?php
    $spot = 0;
    $selectedTime = '09:00';
    ?>
    <tr>
        <td>09:00</td>
        @foreach($coll as $index => $project)

            @if($spot < 3 && $previousValue === $project['position'])
                <?php $spot++?>
                <td data-toggle="modal" data-target="#myModal{{$index}}">{{$project['project']}}</td>
                @include('modal', ['index' => $index, 'project' => $project])
            @else
                <?php
                $spot = 0;
                $endTime = strtotime('+10 minutes', strtotime($selectedTime));
                $selectedTime = date('h:i', $endTime);
                ?>
                </tr>
                <tr>
                <td>{{date('h:i', $endTime)}}</td>
                <td data-toggle="modal" data-target="#myModal{{$index}}">{{$project['project']}}</td>
                @include('modal', ['index' => $index, 'project' => $project])
            @endif

            <?php $previousValue = $project['position'] ?>

        @endforeach
    </tr>
    </tbody>
</table>
</body>
</html>