{{Form::model($ticket, ['route' => ['ticket.duplicate', $ticket], 'class' => 'modal fade', 'id' => 'DuplicateForm','method'=>'get'])}}
{{csrf_field()}}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{t('Duplicate Ticket')}} #{{$ticket->id}}</h4>
        </div>

        <div class="modal-body" id="TicketForm">
            <div class="row">
                <div class="col-md-6">
                Are you sure to duplicate Ticket #{{$ticket->id}}?
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success"><i class="fa fa-copy"></i> {{t('Duplicate')}}</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
{{Form::close()}}

@section('javascript')
    <script>
        var category = '{{Form::getValueAttribute('category_id') ?? $ticket->category_id}}';
        var subcategory = '{{Form::getValueAttribute('subcategory_id') ?? $ticket->subcategory_id}}';
        var item = '{{Form::getValueAttribute('item_id') ?? $ticket->item_id}}';
        var group = '{{Form::getValueAttribute('group_id') ?? $ticket->group_id}}'
    </script>
    <script src="{{asset('/js/ticket-form.js')}}"></script>
    <script src="{{asset('/js/tinymce/tinymce.min.js')}}"></script>
@append