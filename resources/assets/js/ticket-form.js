import Vue from 'vue';
import VueResource from 'vue-resource';

Vue.use(VueResource);

new Vue({
    el: '#TicketForm',
    data: {
        category: '',
        subcategory: window.subcategory,
        item: window.item,
        subcategories: {},
        items: {},
        technicians: []
    },

    watch: {
        category() {
            console.log(this.category);
            if (this.category) {
                this.$http.get(`/list/subcategory/${this.category}`).then(response => this.subcategories = response.data);
            }
        },

        subcategory() {
            this.$http.get(`/list/item/${this.subcategory}`).then(response =>
                this.items = response.data
            );
        }
    }
});
