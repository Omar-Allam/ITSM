<div class="modal fade" id="techModal" tabindex="-1" role="dialog" aria-labelledby="techModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Select Technician Name</h4>
            </div>
            <div class="modal-body">
                <select name="technicians" multiple class="form-control" id="technicians">
                @foreach(\App\User::technicians()->get() as $technician)
                        <option value="{{$technician->email}}"> {{$technician->name}}</option>
                    @endforeach
                </select>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeTech">Close</button>
                <button type="button" class="btn btn-primary" id="chooseTech">Ok</button>
            </div>
        </div>
    </div>
</div>