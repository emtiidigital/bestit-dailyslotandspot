@extends('layouts.app')

@section('content')

    <div class="input-group"><span class="input-group-addon">Filter</span>

        <input id="filter" type="text" class="form-control" placeholder="Type here...">
    </div>
    <?php
    $reminder = \App\Reminder::find(1);
    $maxSpots = $reminder->max_spots;
    ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Time</th>
            @for ($i = 0; $i < $maxSpots; $i++)
                <th>Spot {{$i+1}}</th>
            @endfor
        </tr>
        </thead>

        <tbody class="searchable">

        <?php
        $spot = 0;
        $selectedTime = $reminder->beginning_time;
        ?>
        <tr>
            <td>{{ Carbon\Carbon::parse($reminder->beginning_time)->format('H:i') }}</td>
            @foreach($coll as $index => $project)

                @if($spot < $maxSpots && $previousValue === $project['position'])
                    <?php $spot++?>
                    <td>{{$project['project']}} ({{$project['room']}})
                        <div class="modal-body">
                            @foreach($project['workers'] as $worker)
                                <strong>{{$worker}}</strong>
                                <br>
                            @endforeach
                            @auth
                                @include('Hipchat.message',['project' => $project['project']])
                            @endauth

                        </div>
                    </td>
                @else
                    <?php
                    $spot = 1;
                    $endTime = Carbon\Carbon::parse($selectedTime)->addMinutes(10)->format('H:i');
                    $selectedTime = $endTime;
                    ?>
        </tr>
        <tr>
            <td>{{$endTime}}</td>
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