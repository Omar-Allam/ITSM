<tasks :ticket_id="{{$ticket->id}}" inline-template>
    <div>
        <div>

            @can('task_create',$ticket)
                <button data-toggle="modal" data-target="#TaskForm" type="button" @click="resetTask"
                        class="btn btn-sm btn-success pull-right" title="{{t('Create Task')}}">
                    <i class="fa fa-plus"></i> {{t('Create Task')}}
                </button>
            @endcan
        </div>
        <div class="clearfix"></div>
        <br>
        <table class="table" v-if="tasks[0]">
            <tr class="bg-primary">
                <th>{{t('ID')}}</th>
                <th>{{t('Subject')}}</th>
                <th>{{t('Status')}}</th>
                <th>{{t('Created At')}}</th>
                <th>{{t('Created By')}}</th>
                <th>{{t('Assigned To')}}</th>
                <th>{{t('Actions')}}</th>
            </tr>
            <tbody>
            <tr v-for="task in tasks">
                <td class="col-md-1"><a v-bind:href="'/ticket/'+ task.id">@{{ task.id }}</a></td>
                <td class="col-md-2"> @{{ task.subject }}</td>
                <td class="col-md-2"> @{{ task.status }}</td>
                <td class="col-md-2"> @{{ task.created_at }}</td>
                <td class="col-md-2"> @{{ task.requester }}</td>
                <td class="col-md-2"> @{{ task.technician }}</td>
                <td class="col-md-2">
                    <a class="btn btn-rounded  btn-info" v-bind:href="'/ticket/'+ task.id">{{t('Show')}}</a>
                    {{--<button class="btn btn-rounded  btn-warning" v-on:click="editTask(task.id)"--}}
                    {{--@click="edit = true , task_id=task.id">{{t('Edit')}}--}}
                    {{--</button>--}}

                    {{--<button class="btn btn-rounded  btn-danger" v-on:click="deleteTask(task.id)">{{t('Delete')}}</button>--}}
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
