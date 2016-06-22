import Vue from 'vue';
import VueResource from 'vue-resource';
import Criteria from './Criteria.vue';
import BusinessRules from './BusinessRules.vue';

Vue.use(VueResource);

new Vue({ 
    el: '#BusinessRules',

    components: { Criteria, BusinessRules }
})
