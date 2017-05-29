import Vue from 'vue';
import Attachment from './AttachmentModal.vue';
import Task from './Task.vue';

window.app = new Vue({
    el: '#ticketArea',
    components: { Attachment , Task }
});
