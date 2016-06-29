import Vue from 'vue';
import VueResource from 'vue-resource';
import Criteria from './Criteria.vue';

Vue.use(VueResource);

new Vue({
    el: '#TicketList',
    components: { Criteria }
});


