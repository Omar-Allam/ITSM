import Vue from 'vue';
import Attachments from './AttachmentModal.vue';

window.app = new Vue({
    el: '#TicketForm',
    data: {
        category: window.category,
        subcategory: window.subcategory,
        item: window.item,
        subcategories: {},
        items: {},
        technicians: []
    },

    created() {
        this.loadCategory(false);
        this.loadSubcategory(false);
    },

    methods: {
        loadCategory(withFields) {
            if (this.category) {
                jQuery.get(`/list/subcategory/${this.category}`).then(response => {
                    this.subcategories = response;
                });
                if (withFields) this.loadCustomFields();
            }
        },

        loadSubcategory(withFields) {
            if (this.subcategory) {
                jQuery.get(`/list/item/${this.subcategory}`).then(response => {
                    this.items = response;
                });

                if (withFields) this.loadCustomFields();
            }
        },

        loadItem() {
            if (this.item) {
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
           this.loadCategory(false);
        },

        subcategory() {
            this.loadSubcategory(false);
        },

        item() {
            this.loadItem();
        }
    },

    components: {Attachments}
});
