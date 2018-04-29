@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Project</div>
                    <div class="panel-body">
                        {{ Form::open(['class' => 'form-horizontal', 'route' => ['projects.update', $project->id]]) }}
                        {!! method_field('patch') !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                {{ Form::text('name', $project->name, ['required', 'autofocus', 'class' => 'form-control', 'placeholder' => 'Name...']) }}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('room') ? ' has-error' : '' }}">
                            {{ Form::label('room', 'Room', ['class' => 'col-md-4 control-label']) }}

                            <div class="col-md-6">
                                {{ Form::text('room', $project->room, ['required', 'autofocus', 'class' => 'form-control', 'placeholder' => 'Room...']) }}
                                @if ($errors->has('room'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('room') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                {{ Form::submit('Update project', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
