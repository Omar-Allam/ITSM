import Vue from 'vue';
import VueResource from 'vue-resource';
import Criteria from './Criteria.vue';

Vue.use(VueResource);

const Report = new Vue({
    el: '#ReportArea',
    components: { Criteria }
});
