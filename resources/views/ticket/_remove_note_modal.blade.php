<form method="POST" action="#" accept-charset="UTF-8" class="modal fade in" id="removeNoteModal">
    {{csrf_field()}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Remove Note</h4>
            </div>

            <div class="modal-body" id="TicketForm">
                <div class="row">
                    <div class="col-md-6">
                        Are you sure to remove a note?
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Remove</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</form>