<template>
    <tr>
        <td>
            <select @change="update" class="form-control input-sm" name="rules[{{key}}][field]" v-model="rule.field">
                <option value="">Select Field</option>
                <option value="subject">Subject</option>
                <option value="description">Description</option>
                <option value="category_id">Category</option>
                <option value="subcategory_id">Subcategory</option>
                <option value="item_id">Item</option>
                <option value="urgency_id">Urgency</option>
                <option value="priority_id">Priority</option>
                <option value="impact_id">Impact</option>
                <option value="business_unit_id">Business Unit</option>
                <option value="location_id">Location</option>
            </select>
        </td>
        <td>
            <div class="input-group" v-if="showMenuIcon">
                <input class="form-control input-sm" name="rules[{{key}}][label]" type="text" @click="loadOptions()" v-model="rule.label" readonly>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default btn-sm" @click="loadOptions()"><i class="fa fa-bars"></i></button>
                </div>
            </div>
            <input class="form-control input-sm" name="rules[{{key}}][label]" type="text" v-model="rule.label" @change="update" v-else>

            <input type="hidden" name="rules[{{key}}][value]" v-model="rule.value">
        </td>
        <td>
            <button class="btn btn-sm btn-warning pull-right" type="button" @click="remove()"><i class="fa fa-remove"></i></button>
        </td>
    </tr>
</template>

<script>
var fields = {
    subject: {type: 'text'},
    description: {type: 'text'},
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

    methods: {
        update() {
            this.rule.value = this.rule.label;
        },

        remove() {
            this.$dispatch('removeRule', this.key);
        },

        loadOptions() {
            const field = fields[this.rule.field];
            if (!field || field.type != 'select') {
                return false;
            }

            this.$http.get('/list/' + field.list).then(response => {
                this.$dispatch('openSelectModal', { options: response.data, key: this.key, field: field.name });
            });
        }
    },

    computed: {
        showMenuIcon() {
            const field = fields[this.rule.field];
            if (!field) {
                return false;
            }
            return field.type == 'select';
        }
    },

    events: {
        setRuleValue(key, values, labels) {
            if (key != this.key) {
                return false;
            }

            this.rule.value = values.join(',');
            this.rule.label = labels.join(', ');
        }
    }
};
</script>
