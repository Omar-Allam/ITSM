<template>
<tr>
    <td>
        <select @change="update" class="form-control input-sm" name="criterions[{{key}}][field]" v-model="criterion.field">
            <option value="">Select Field</option>
            <optgroup label="Request">
                <option value="subject">Subject</option>
                <option value="description">Description</option>
                <option value="category_id">Category</option>
                <option value="subcategory_id">Subcategory</option>
                <option value="item_id">Item</option>
                <option value="urgency_id">Urgency</option>
                <option value="priority_id">Priority</option>
                <option value="impact_id">Impact</option>
            </optgroup>
            <optgroup label="Requester">
                <option value="requester_id">Requester</option>
                <option value="business_unit_id">Business Unit</option>
                <option value="location_id">Location</option>
            </optgroup>
            <optgroup label="Technician">
                <option value="technician_id">Technician</option>
                <option value="group_id">Support Group</option>
            </optgroup>
        </select>
    </td>
    <td>
        <select @change="update" class="form-control input-sm" name="criterions[{{key}}][operator]" v-model="criterion.operator">
            <option value="is">is</option>
            <option value="isnot">is not</option>
            <option value="contains">contains</option>
            <option value="notcontain">does not contain</option>
            <option value="starts">starts with</option>
            <option value="ends">ends with</option>
        </select>
    </td>
    <td>
        <div class="input-group" v-if="showMenuIcon">
            <input class="form-control input-sm" name="criterions[{{key}}][label]" type="text" @click="loadOptions()" v-model="criterion.label" readonly>
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-sm" @click="loadOptions()"><i class="fa fa-bars"></i></button>
            </span>
        </div>
        <input class="form-control input-sm" name="criterions[{{key}}][label]" type="text" v-model="criterion.label" @change="update" v-else>

        <input type="hidden" name="criterions[{{key}}][value]" v-model="criterion.value">
    </td>
    <td>
        <button class="btn btn-sm btn-warning pull-right" type="button" @click="remove()"><i class="fa fa-remove"></i></button>
    </td>
</tr>
</template>

<script>
    const fields = {
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
        technician_id: {type: 'select', list: 'technician', name: 'Technician'},
        group_id: {type: 'select', list: 'group', name: 'Support Group'},
    };

    export default {
        props: ['criterion', 'key'],

        computed: {
            showMenuIcon() {
                const field = fields[this.criterion.field];
                if (!field) {
                    return false;
                }
                return field.type == 'select' && (this.criterion.operator == 'is' || this.criterion.operator == 'isnot')
            }
        },

        methods: {
            update() {
                this.criterion.value = this.criterion.label;
            },

            remove() {
                this.$dispatch('removeCriterion', this.key);
            },

            loadOptions() {
                const field = fields[this.criterion.field];
                if (!field || field.type != 'select') {
                    return false;
                }

                this.$http.get('/list/' + field.list).then(response => {
                    console.log(this.criterion.value);
                    this.$dispatch('openSelectModal', { options: response.data, key: this.key, field: field.name, selected: this.criterion.value.split(',') });
                });
            }
        },

        events: {
            setCriterionValue(key, values, labels) {
                if (key != this.key) {
                    return false;
                }

                this.criterion.value = values.join(',');
                this.criterion.label = labels.join(', ');
            }
        }
    }
</script>
