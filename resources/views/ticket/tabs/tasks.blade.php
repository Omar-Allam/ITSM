<tasks :ticket_id="{{$ticket->id}}" inline-template>
    <div>
        <div>
            @if(Auth::id() == $ticket->technician_id)
                <button data-toggle="modal" data-target="#TaskForm" type="button" @click="resetTask"
                        class="btn btn-sm btn-success" title="{{t('Create Task')}}">
                    <i class="fa fa-plus"></i> {{t('Create Task')}}
                </button>
            @endif
        </div>
        <br>
        <table class="table"  v-if="tasks[0]">
            <tr class="bg-primary">
                <th>Subject</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <tbody>
            <tr v-for="task in tasks">
                <td class="col-md-2"> @{{ task.subject }}</td>
                <td class="col-md-8"> @{{ task.description }}</td>
                <td class="col-md-2">
                    <button class="btn btn-rounded  btn-warning" v-on:click="editTask(task.id)"
                            @click="edit = true , task_id=task.id">{{t('Edit')}}
                    </button>

                    <button class="btn btn-rounded  btn-danger" v-on:click="deleteTask(task.id)">{{t('Delete')}}</button>
                </td>
            </tr>

            </tbody>
        </table>
        <div class="alert alert-info" v-else="tasks[0]"><i class="fa fa-exclamation-circle"></i>
            <strong>{{t('No Tasks found')}}</strong>
        </div>
        @include('ticket._create_task')
    </div>
</tasks>
