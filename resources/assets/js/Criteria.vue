<template>

    <table class="listing-table table-bordered">
        <thead>
            <tr>
                <th class="bg-info col-md-3">Field</th>
                <th class="bg-info col-md-2">Operator</th>
                <th class="bg-info col-md-6">Value</th>
                <th class="bg-info">
                    <button class="btn btn-sm btn-primary pull-right" @click="addCriterion" type="button"><i class="fa fa-plus-circle"></i></button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr is="Criterion" v-for="(key, criterion) in criterions" :key="key" :criterion="criterion"></tr>
        </tbody>
    </table>


    <div class="modal fade selection-modal" tabindex="-1" role="dialog" id="CriteriaSelectionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{modal.field}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="search" class="form-control" v-model="modal.search" placeholder="Filters">
                    </div>
                    <div class="form-group">
                        <select class="form-control" v-model="modal.selected" multiple="multiple">
                            <option v-for="(index, label) in modal.options|filterBy modal.search" value="{{index}}">{{label}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="modalApply"><i class="fa fa-check-circle"></i> Apply</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import Criterion from './Criterion.vue';

export default {

    props: [ 'criterions' ],

    data() {
        return {
            modal: {
                field: '',
                options: {},
                search: '',
                key: null,
                selected: []
            }
        }
    },

    ready () {
        if (!this.criterions) {
            this.criterions = [];
            this.addCriterion();
        }
    },

    methods: {
        addCriterion() {
            this.criterions.push({
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
            this.$broadcast('setCriterionValue', this.modal.key, this.modal.selected, labels);
            jQuery('#CriteriaSelectionModal').modal('hide');
        }
    },

    components: { Criterion },

    events: {
        openSelectModal(options) {
            this.modal.field = options.field;
            this.modal.options = options.options;
            this.modal.key = options.key;
            this.modal.selected = [];
            if (options.selected) {
                this.modal.selected = options.selected;
            }
            jQuery('#CriteriaSelectionModal').modal('show');
        },

        removeCriterion(key) {
            if (this.criterions.length > 1) {
                const criterions = [];
                let i = 0;
                for (let i = 0; i < this.criterions.length; i++) {
                    if (i == key) continue;
                    criterions.push(this.criterions[i]);
                }
                this.criterions = criterions;
            }
        }
    }
};

</script>
