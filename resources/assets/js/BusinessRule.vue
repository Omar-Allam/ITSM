<template>
    <tr>
        <td>
            <select @change="loadOptions" class="form-control input-sm" name="rules[{{key}}][field]" v-model="rule.field">
                <option value="">Select Field</option>
                <option v-for="(field, options) in fields" value="{{field}}">{{options.name}}</option>
            </select>
        </td>
        <td>
            <select class="form-control input-sm" name="rules[{{key}}][value]" v-model="rule.value" v-if="showMenu">
                <option value="">Select {{fields[rule.field].name}}</option>
                <option v-for="(value, label) in options" value="{{value}}">{{label}}</option>
            </select>
            <input class="form-control input-sm" name="rules[{{key}}][value]" type="text" v-model="rule.value" v-else>
        </td>
        <td>
            <button class="btn btn-sm btn-warning pull-right" type="button" @click="remove()"><i class="fa fa-remove"></i></button>
        </td>
    </tr>
</template>

<script>
var fields = {
    group_id: {type: 'select', list: 'support-groups', name: 'Group'},
    technician_id: {type: 'select', list: 'technician', name: 'Technician'},
    subject: {type: 'text', name: 'Subject'},
    description: {type: 'text', name: 'Description'},
    category_id: {type: 'select', list: 'category', name: 'Category'},
    subcategory_id: {type: 'select', list: 'subcategory', name: 'Subcategory'},
    item_id: {type: 'select', list: 'item', name: 'Item'},
    location_id: {type: 'select', list: 'location', name: 'Location'},
    business_unit_id: {type: 'select', list: 'business-unit', name: 'Business Unit'},
    priority_id: {type: 'select', list: 'priority', name: 'Priority'},
    urgency_id: {type: 'select', list: 'urgency', name: 'Urgency'},
    impact_id: {type: 'select', list: 'impact', name: 'Impact'},
};

export default {
    props: ['rule', 'key'],

    data() {
        return { fields, options: [] }
    },

    ready() {
        this.loadOptions();
    },

    methods: {
        remove() {
            this.$dispatch('removeRule', this.key);
        },

        loadOptions() {
            const field = this.fields[this.rule.field];

            if (!field || field.type != 'select') {
                return false;
            }

            this.$http.get('/list/' + field.list)
                .then(response => this.options = response.data);
        }
    },

    computed: {
        showMenu() {
            const field = this.fields[this.rule.field];
            if (!field) {
                return false;
            }
            return field.type == 'select';
        }
    }
};
</script>
