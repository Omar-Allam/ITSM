<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addTaskModal">
    <i class="fa fa-plus-square"></i> Add Task
</button>


@if ($ticket->tasks->count())
    <task v-bind:ticket="{{$ticket->id}}"></task>
@else
    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No Tasks</div>
@endif

@include('ticket.tasks._task_modal')
@include('ticket.tasks._remove_task_modal')



@section('javascript')
    <script src="/js/ticket.js"></script>
    <script>
        window.x = 0;
        $('.btn-danger').on('click', function (e) {


        });
        $('.remove-task').on('click', function (e) {
            alert(window.x);
//        e.stopPropagation();
//        e.preventDefault();
//        let task_id = jQuery('.btn-danger').data('remove');
//        jQuery.ajax({
//            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//            url: '/task/' + task_id,
//            data: {_method: 'DELETE'},
//            type: 'delete',
//        }).done(() => {
//            console.log('good')
//        }).fail(() => {
//            console.log('wrong')
//        })
//        jQuery('#removeTaskModal').modal('hide');
        })
    </script>
@endsection

