@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="pull-right">
            <a class="btn btn-sm btn-default" href="{{ route('projects.create') }}">New Project <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Room</th>
            </tr>
            </thead>
            <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->room }}</td>
                    <td>
                        {{ Form::open([
                       'route' => ['projects.edit', $project->id],
                       'class' => 'pull-right'
                        ]) }}
                        {{ Form::hidden('_method', 'GET') }}
                        {{ Form::submit('Edit this Project', ['class' => 'btn btn-warning']) }}
                        {{ Form::close() }}

                    </td>
                    <td>
                        {{ Form::open([
                            'route' => ['projects.destroy', $project->id],
                            'class' => 'pull-right'
                        ]) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete this Project', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td>Nothing here.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
