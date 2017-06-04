import Vue from 'vue';
import Criteria from './Criteria.vue';
import Fields from './Fields.vue';

const Report = new Vue({
    el: '#ReportArea',
    components: { Criteria, Fields }
});
