</br>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Send Message
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">send a message to all {{$project}} Project members</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open([
                     'route' => ['projects.sendMessage', $project],
                     'class' => 'pull-right'
                 ]) }}
                {{ Form::hidden('_method', 'POST') }}

                <div class="form-group">
                    {{ Form::textarea('message') }}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div class="col-md-8 col-md-offset-4">
                    {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>