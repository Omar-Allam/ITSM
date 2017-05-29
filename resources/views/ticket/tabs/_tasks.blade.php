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
    {{--<script src="/js/ticket.js"></script>--}}
    <script src="/js/task.js"></script>

@endsection

