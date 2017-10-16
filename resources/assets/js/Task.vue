<script>
    import Vue from 'vue';

    var $ = require('jquery');

    Vue.component('tasks', {
        props: ['ticket_id'],
        data() {
            return {
                category: window.category,
                subcategory: window.subcategory,
                item: window.item,
                tasks: [],
                errors: [],
                subject: '',
                description: '',
                subcategories: [],
                items: [],
                technicians: [],
                group: '',
                status: '',
                technician: '',
                edit: false,
                task_id: null,
            }
        },
        methods: {
            loadTasks() {
                $.ajax({
                    method: 'GET',
                    url: '/ticket/tasks/' + this.ticket_id,
                    success: function (response) {
                        this.tasks = response
                    }.bind(this),

                });
            },
            changeOnSubmit() {
                if (this.edit) {
                    this.updateTask();
                } else {
                    this.createTask();
                }
            },
            createTask() {
                jQuery.ajax({
                    method: 'POST',
                    url: '/ticket/tasks/' + this.ticket_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        subject: this.subject,
                        category: this.category,
                        subcategory: this.subcategory,
                        item: this.item,
                        status: this.status,
                        description: this.description,
                        group: this.group,
                        technician: this.technician,
                        ticket_id: this.ticket_id,

                    },
                    success: function (response) {
                        this.loadTasks();
                        this.errors = response;
                        jQuery("#TaskForm").modal('hide');
                        this.resetAll();
                    }.bind(this),
                    error: function (response) {
                        this.errors = response.responseJSON
                    }.bind(this)

                });
            },
            editTask(task) {
                let modal = jQuery('#TaskForm');
                jQuery.ajax({
                    method: 'GET',
                    url: '/ticket/tasks/edit/' + task,
                    success: function (response) {
                        this.subject = response.subject;
                        this.description = response.description;
                        this.category = response.category_id;
                        this.subcategory = response.subcategory_id;
                        this.item = response.item_id;
                        this.status = response.status_id;
                        this.group = response.group_id;
                        this.technician = response.technician_id;
                        this.errors = [];
                        modal.find('.modal-title').html('Edit Task #' + task);
                        modal.modal('show');
                    }.bind(this),

                });
            },
            deleteTask(task) {
                $.ajax({
                    method: 'DELETE',
                    url: '/ticket/tasks/' + this.ticket_id + '/' + task,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        this.loadTasks()
                    }.bind(this),

                });

            },
            resetTask() {
                this.resetAll();
                jQuery('#TaskForm').find('.modal-title').html('Create Task');
            },
            updateTask() {
                jQuery.ajax({
                    method: 'PUT',
                    url: '/ticket/tasks/' + this.ticket_id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        subject: this.subject,
                        description: this.description,
                        category: this.category,
                        subcategory: this.subcategory,
                        item: this.item,
                        status: this.status,
                        task_id: this.task_id,
                    },
                    success: function (response) {
                        this.loadTasks();
                        jQuery("#TaskForm").modal('hide');
                        this.resetAll();
                    }.bind(this),
                    error: function (response) {
                        this.errors = response.responseJSON
                    }.bind(this)

                });
            },
            loadSubcategory() {
                if (this.category) {
                    $.get(`/list/subcategory/${this.category}`).then(response => {
                        this.subcategories = response;
                    });
                }

            },
            loadItems() {
                if (this.subcategory) {
                    $.get(`/list/item/${this.subcategory}`).then(response => {
                        this.items = response;
                    });
                }
            },
            resetAll() {
                this.edit = false;
                this.subject = '';
                this.description = '';
                this.category = '';
                this.subcategory = '';
                this.item = '';
                this.cat = '';
                this.status = '';
                this.errors = [];
                this.subcategories = [];
                this.items = [];
                this.technicians = [];
                this.group = '';
                this.technician ='';

            },
            loadTechnicians() {
                if (this.group) {
                    $.get(`/list/group-technicians/${this.group}`).then(response => {
                        this.technicians = response;
                    });
                }
            }
        }, watch: {
            category() {
                this.loadSubcategory();
            },

            subcategory() {
                this.loadItems();
            },
            group() {
                this.loadTechnicians();
            }

        },

        created() {
            this.loadTasks();
            this.loadSubcategory();
            this.loadItems();
            this.loadTechnicians();
        }
    });
    window.app = new Vue({
        el: '#tasks',

    });
</script>

