<template>
    <table class="listing-table table-condensed">
        <thead>
        <tr>
            <th>Attachments</th>
            <th class="text-right">
                <button type="button" @click="add" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(index, attach) in attachments">
            <td class="col-md-10">
                <input type="file" class="form-control input-xs" :name="`attachments[${index}]`">
            </td>
            <td class="col-md-2 text-right">
                <button type="button" @click="remove(index)" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        data() {
            return {attachments: [{}]}
        },

        props: {
            limit: {'default': 1}
        },

        methods: {
            add() {
                if (this.attachments.length < this.limit) {
                    this.attachments.push({});
                }
            },

            remove(key) {
                if (this.attachments.length > 1) {
                    let trail = this.attachments.splice(key);
                    trail.shift();
                    trail.forEach(item => {
                        this.attachments.push(item);
                    });
                }
            }
        }
    }
</script>