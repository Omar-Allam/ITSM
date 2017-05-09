import Vue from 'vue';
import Criteria from './Criteria.vue';
import BusinessRules from './BusinessRules.vue';

window.app = new Vue({ 
    el: '#BusinessRules',

    components: { Criteria, BusinessRules }
})
