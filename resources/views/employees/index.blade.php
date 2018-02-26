@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="pull-right">
            <a class="btn btn-sm btn-default" href="{{ route('employees.create') }}">New Employee <span
                        class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        {{ Form::open([
                       'route' => ['employees.edit', $employee->id],
                       'class' => 'pull-right'
                        ]) }}
                        {{ Form::hidden('_method', 'GET') }}
                        {{ Form::submit('Edit this Nerd', ['class' => 'btn btn-warning']) }}
                        {{ Form::close() }}

                    </td>
                    <td>
                        {{ Form::open([
                            'route' => ['employees.destroy', $employee->id],
                            'class' => 'pull-right'
                        ]) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete this Nerd', ['class' => 'btn btn-danger']) }}
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
