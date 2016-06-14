<template>
    <div class="form-group">
        <a href="#attachmentModal" data-toggle="modal" class="btn btn-primary"><i class="fa fa-upload"></i> Attachments</a>
    </div>
    <div id="attachmentModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Attachments</h4>
                </div>
                <div class="modal-body">
                    <table class="listing-table table-condensed">
                        <thead>
                        <tr>
                            <th>Attachment</th>
                            <th class="text-center">
                                <button type="button" @click="add" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="attach in attachments">
                            <td class="col-md-10">
                                <input type="file" class="form-control input-sm" name="attachments[$index]">
                            </td>
                            <td class="col-md-2 text-center">
                                <button type="button" @click="remove($index)" class="btn btn-warning btn-sm"><i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return { attachments: [{}] }
        },

        props: {
            limit: { 'default': 1 }
        },

        methods: {
            add() {
                if (this.attachments.length < this.limit) {
                    this.attachments.push({});
                }
            },

            remove(key) {
                let trail = this.attachments.splice(key);
                trail.shift();
                trail.forEach(item => {
                    this.attachments.push(item);
                });
            }
        }
    }
</script>