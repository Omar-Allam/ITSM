<template>
<article>
    <table class="listing-table table-bordered">
        <thead>
        <tr>
            <th class="col-md-3">Field</th>
            <th class="col-md-2">Operator</th>
            <th class="col-md-6">Value</th>
            <th>
                <button class="btn btn-sm btn-primary pull-right" @click="addCriterion" type="button">
                    <i class="fa fa-plus-circle"></i></button>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr is="Criterion" v-for="(criterion, index) in criteria" :index="index" :criterion="criterion"></tr>
        </tbody>
    </table>


    <div class="modal fade selection-modal" tabindex="-1" role="dialog" id="CriteriaSelectionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{modal.field}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="search" class="form-control" v-model="modal.search" placeholder="Filters">
                    </div>
                    <div class="form-group">
                        <select class="form-control" v-model="modal.selected" multiple="multiple">
                            <option v-for="(label, index) in filteredOptions" :value="index">
                                {{label}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="modalApply"><i class="fa fa-check-circle"></i>
                        Apply
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times-circle"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</article>
</template>

<script>

import Criterion from './Criterion.vue';
import EventBus from '../Bus';

export default {

    props: [ 'criterions' ],

    data() {
        let criteria = this.criterions;
        if (!criteria) {
            criteria = [];
        }
        return {
            modal: {
                field: '',
                options: {},
                search: '',
                index: null,
                selected: []
            },

            criteria
        }
    },

    created() {
        EventBus.$on('openSelectModal', (options) => {
            this.modal.field = options.field;
            this.modal.options = options.options;
            this.modal.index = options.index;
            this.modal.selected = [];
            if (options.selected) {
                this.modal.selected = options.selected;
            }
            jQuery('#CriteriaSelectionModal').modal('show');
        });

        EventBus.$on('removeCriterion', (index) => {
            if (this.criteria.length > 1) {
                const criterions = [];
                let i = 0;
                for (let i = 0; i < this.criteria.length; i++) {
                    if (i == key) continue;
                    criterions.push(this.criteria[i]);
                }
                this.criteria = criterions;
            }
        });
    },

    ready () {
        if (!this.criteria) {
            this.criteria = [];
            this.addCriterion();
        }
    },

    methods: {
        addCriterion() {
            this.criteria.push({
                field: '',
                operator: 'is',
                label: '',
                value: '',
                showMenuIcon: false
            })
        },

        modalApply() {
            let labels = [], i = 0;
            for (i; i < this.modal.selected.length; ++i) {
                let value = this.modal.selected[i];
                labels.push(this.modal.options[value]);
            }
            EventBus.$emit('setCriterionValue', { index: this.modal.index, values: this.modal.selected, labels});
            jQuery('#CriteriaSelectionModal').modal('hide');
        }
    },

    computed: {
        filteredOptions() {
            if (!this.modal.search) {
                return this.modal.options;
            }

            const term = this.modal.search.toLowerCase();
            let filtered = {};
            for (let key in this.modal.options) {
                if (!this.modal.options.hasOwnProperty(key)) continue;
                let value = this.modal.options[key];
                if (value.toLowerCase().indexOf(term) != -1) {
                    filtered[key] = value;
                }
            }

            return filtered;
        }
    },

    components: { Criterion }
};
</script>
