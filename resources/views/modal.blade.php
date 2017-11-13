<div class="modal fade" id="myModal{{$index}}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Workers for {{$project['project']}}</h4>
            </div>
            <div class="modal-body">
                @foreach($project['workers'] as $worker)
                    <strong>{{$worker}}</strong>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
</div>