<template>
<section class="table-container">
    <table class="listing-table table-bordered">
        <thead>
            <tr>
                <th class="col-md-3">Field</th>
                <th class="col-md-8">Value</th>
                <th>
                    <button class="btn btn-sm btn-primary pull-right" @click="addRule" type="button"><i class="fa fa-plus-circle"></i></button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr is="BusinessRule" v-for="(rule, index) in currentRules" :index="index" :rule="rule" :key="index"></tr>
        </tbody>
    </table>

    <div class="modal fade selection-modal" tabindex="-1" role="dialog" id="RuleSelectionModal">
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
                            <option v-for="(index, label) in modal.options" :value="index">{{label}}</option>
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
    </section>
</template>

<script>
import BusinessRule from './BusinessRule.vue';
import EventBus from './Bus';

export default {
    props: ['rules'],

    data() {
        let currentRules = [];
        if (this.rules && this.rules.length) {
            currentRules = this.rules;
        }

        return { modal: {field: '', options: [], search: '', key: null, selected: []}, currentRules }
    },

    methods: {
        addRule() {
            this.currentRules.push({
                name: '', field: '', value: '', label: ''
            });
        },

        modalApply() {
            let labels = [], i = 0;
            for (i; i < this.modal.selected.length; ++i) {
                let value = this.modal.selected[i];
                labels.push(this.modal.options[value]);
            }
            this.$broadcast('setRuleValue', this.modal.key, this.modal.selected, labels);
            jQuery('#RuleSelectionModal').modal('hide');
        }
    },

    ready() {
        if (!this.rules.length) {
            this.addRule();
        }
    },

    created() {
        EventBus.$on('removeRule', (key) => {
            if (this.currentRules.length > 1) {
                const rules = [];
                let i = 0;
                for (let i = 0; i < this.currentRules.length; i++) {
                    if (i == key) continue;
                    rules.push(this.currentRules[i]);
                }
                this.currentRules = rules;
            }
        });
    },

    events: {
        openSelectModal(options) {
            this.modal.field = options.field;
            this.modal.options = options.options;
            this.modal.key = options.key;
            this.modal.selected = [];
            jQuery('#RuleSelectionModal').modal('show');
        },
    },

    components: { BusinessRule }
};
</script>
