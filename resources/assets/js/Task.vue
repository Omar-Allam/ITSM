<template xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <table class="listing-table" style="margin-top: 40px">
            <thead>
            <tr>
                <th class="col col-md-2"> Title</th>
                <th class="col col-md-2">Description</th>
                <!--<th class="col col-md-1">Status</th>-->
                <th class="col col-md-1">Group</th>
                <th class="col col-md-1">Assigned To</th>
                <th class="col col-md-1">Priority</th>
                <!--<th class="col col-md-2">Comment</th>-->
                <th class="col col-md-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks">
                <td><a v-bind:href="'/task/'+ task.task_id">{{task.title}}</a></td>
                <td>{{task.description}}</td>
                <!--<td>{{task.status}}</td>-->
                <td>{{task.group}}</td>
                <td>{{task.technician}}</td>
                <td>{{task.priority}}</td>
                <!--<td>{{task.comments}}</td>-->
                <td>
                    <button class="btn btn-danger" @click="showModal(task.task_id,task.title)"><i
                            class="fa fa-trash"></i> Remove
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" id="removeTaskModal" tabindex="-1" role="dialog" aria-labelledby="removeTaskModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Remove Task</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning lead">
                            Are You sure to delete <span id="task_title"></span> task ?
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" v-on:click="removeTask()">Remove</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

</template>
<script>
    export default {
        props: ['ticket'],
        data() {
            return {
                tasks: [],
                task_id: 0,
            }
        },

        methods: {
            loadTasks() {
                jQuery.get('/get-tasks/' + this.ticket).done(response => this.tasks = response);
            },

            showModal(id, title){
                let remove_modal = jQuery('#removeTaskModal');
                let form = jQuery('#remove-task-form');
                remove_modal.find('.lead').find('#task_title').text(title);
                remove_modal.modal('show');
                this.task_id = id;
            },
            removeTask(){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/task/' + this.task_id,
                    type: 'DELETE',
                    success: function (response) {
                        console.log('task is deleted')
                    }
                });
                let remove_modal = jQuery('#removeTaskModal');
                remove_modal.modal('hide')
                this.loadTasks();
            }

        },
        created(){
            this.loadTasks()
        }
    }
</script>