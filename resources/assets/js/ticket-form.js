import Vue from 'vue';
import Attachments from './AttachmentModal.vue';

new Vue({
    el: '#TicketForm',
    data: {
        category: window.category,
        subcategory: window.subcategory,
        item: window.item,
        subcategories: {},
        items: {},
        technicians: []
    },

    ready() {
        this.loadCategory(false);
        this.loadSubcategory(false);
    },

    methods: {
        loadCategory(withFields) {
            if (this.category) {
                $.get(`/list/subcategory/${this.category}`).then(response => this.subcategories = response.data);
                if (withFields) this.loadCustomFields();
            }
        },

        loadSubcategory(withFields) {
            if (this.subcategory) {
                $.get(`/list/item/${this.subcategory}`).then(response =>
                    this.items = response.data
                );

                if (withFields) this.loadCustomFields();
            }
        },

        loadItem() {
            if (this.item) {
                this.loadCustomFields();
            }
        },

        loadCustomFields() {
            const $ = window.jQuery;
            const customFieldsContainer = $('#CustomFields');
            const fieldValues = {};

            customFieldsContainer.find('.cf').each(function (idx, element) {
                let id = element.id;
                let type = element.type;
                if (type == 'checkbox') {
                    fieldValues[id] = element.checked;
                } else {
                    fieldValues[id] = $(element).val();
                }
            });

            let url = `/custom-fields?category=${this.category}&subcategory=${this.subcategory}&item=${this.item}`;
            $.get(url).then(response => {
                let newFields = $(response.data);
                for (let id in fieldValues) {
                    const field = newFields.find('#' + id);
                    if (field.attr('type') == 'checkbox') {
                        field.prop('checked', fieldValues[id]);
                    } else {
                        field.val(fieldValues[id]);
                    }
                }
                customFieldsContainer.html('').append(newFields);
            });
        }
    },

    watch: {
        category() {
           this.loadCategory(true);
        },

        subcategory() {
            this.loadSubcategory(true);
        },

        item() {
            this.loadItem();
        }
    },

    components: {Attachments}
});
