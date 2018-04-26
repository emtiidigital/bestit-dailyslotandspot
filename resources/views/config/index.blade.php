@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>Max Spots Number</th>
                <th>Dailies beginning time</th>
                <th>Dailies end time</th>
                <th>Send Hipchat message x minutes before start</th>
            </tr>
            </thead>
            <tbody>

            {{ Form::open(['class' => 'form-horizontal', 'route' => ['config.update', $config->id]]) }}
            {!! method_field('patch') !!}

            <tr>

                <td>{{ Form::text('max_spots', $config->max_spots, ['required', 'class' => 'form-control', 'placeholder' => 'Max Spots Number']) }}</td>
                <td>{{ Form::text('beginning_time', $config->beginning_time, ['required', 'class' => 'form-control', 'placeholder' => 'dailies beginning time']) }}</td>
                <td>{{ Form::text('end_time', $config->end_time, ['required', 'class' => 'form-control', 'placeholder' => 'dailies end time']) }}</td>
                <td>{{ Form::text('hip_chat', $config->hip_chat, ['required', 'class' => 'form-control', 'placeholder' => 'Send Hipchat message x minutes before start']) }}</td>
                <td>  {{ Form::submit('Update', ['class' => 'btn btn-primary']) }} </td>
            </tr>

            {{ Form::close() }}
            </tbody>
        </table>
    </div>
@endsection
