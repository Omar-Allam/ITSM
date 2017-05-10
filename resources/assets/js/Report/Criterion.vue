<template>
    <tr>
        <td>
            <select @change="update" class="form-control input-sm" :name="`filters[${index}][field]`" v-model="criterion.field">
                <option value="">Select Field</option>
                <option v-for="(title, id) in fields" :value="id">{{title}}</option>
            </select>
        </td>
        <td>
            <select @change="update" class="form-control input-sm" :name="`filters[${index}][operator]`" v-model="criterion.operator">
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
                <input class="form-control input-sm" :name="`filters[${index}][label]`" type="text" @click="loadOptions()" v-model="criterion.label" readonly>
                <span class="input-group-btn">
    <button type="button" class="btn btn-default btn-sm" @click="loadOptions()"><i class="fa fa-bars"></i></button>
    </span>
            </div>
            <input class="form-control input-sm" :name="`filters[${index}][label]`" type="text" v-model="criterion.label" @change="update" v-else>

            <input type="hidden" :name="`filters[${index}][value]`" v-model="criterion.value">
        </td>
        <td>
            <button class="btn btn-sm btn-warning pull-right" type="button" @click="remove()">
                <i class="fa fa-remove"></i></button>
        </td>
    </tr>
</template>

<script>
import EventBus from '../Bus';
const fields = {
    subject: {type: 'text'},
    category: {type: 'select', list: 'category', name: 'Category'},
    subcategory: {type: 'select', list: 'subcategory', name: 'Subcategory'},
    item: {type: 'select', list: 'item', name: 'Item'},
    location: {type: 'select', list: 'location', name: 'Location'},
    business_unit: {type: 'select', list: 'business-unit', name: 'Business Unit'},
    technician: {type: 'select', list: 'technician', name: 'Technician'},
    requester: {type: 'select', list: 'requester', name: 'Technician'},
    id: {type: 'text'}
};

export default {
    props: ['criterion', 'index'],

    data() {
        return {fields: window.fields};
    },

    computed: {
        showMenuIcon() {
            const field = fields[this.criterion.field];
            if (!field) {
                return false;
            }
            return field.type == 'select' && (this.criterion.operator == 'is' || this.criterion.operator == 'isnot')
        },
        
        filteredOptions() {
            if (!this.modal.search) {
                return this.options;
            }

            const term = this.modal.search.toLowerCase();
            let filtered = {};
            for (let index in this.options) {
                let value = this.options[index];
                if (value.toLowerCase().contains(term)) {
                    filtered[index] = value;
                }
            }

            return filtered;
        }
    },

    methods: {
        update() {
            this.criterion.value = this.criterion.label;
        },

        remove() {
            this.$dispatch('removeCriterion', this.index);
        },

        loadOptions() {
            const field = fields[this.criterion.field];
            if (!field || field.type != 'select') {
                return false;
            }

            jQuery.get('/list/' + field.list).then(response => {
                EventBus.$emit('openSelectModal', { options: response, index: this.index, field: field.name, selected: this.criterion.value.split(',') });
            });
        }
    },

    created() {
        EventBus.$on('setCriterionValue', (params) => {
            if (params.index != this.index) {
                return false;
            }

            this.criterion.value = params.values.join(',');
            this.criterion.label = params.labels.join(', ');
        });
    }
}

</script>
