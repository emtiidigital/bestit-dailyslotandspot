@extends('layouts.app')

@section('content')

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
        $selectedTime = '09:20';
        ?>
        <tr>
            <td>09:20</td>
            @foreach($coll as $index => $project)

                @if($spot < 3 && $previousValue === $project['position'])
                    <?php $spot++?>
                    <td>{{$project['project']}}
                        <div class="modal-body">
                            @foreach($project['workers'] as $worker)
                                <strong>{{$worker}}</strong>
                                <br>
                            @endforeach
                        </div>
                    </td>
                @else
                    <?php
                    $spot = 1;
                    $endTime = strtotime('+10 minutes', strtotime($selectedTime));
                    $selectedTime = date('h:i', $endTime);
                    ?>
        </tr>
        <tr>
            <td>{{date('h:i', $endTime)}}</td>
            <td>{{$project['project']}}
                <div class="modal-body">
                    @foreach($project['workers'] as $worker)
                        <strong>{{$worker}}</strong>
                        <br>
                    @endforeach
                </div>
            </td>
            @endif

            <?php $previousValue = $project['position'] ?>

            @endforeach
        </tr>
        </tbody>
    </table>
@endsection