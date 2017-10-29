window.jQuery = window.$ = require('jquery');

$('#request-details').click(function (e) {
    $('.print-ticket-details').toggle();
})

$('#request-conversation').click(function (e) {
    $('.print-ticket-conversation').toggle();
})

$('#request-approvals').click(function (e) {
    $('.print-ticket-approvals').toggle();
})

$('#request-resolution').click(function (e) {
    $('.print-ticket-resolution').toggle();
})

$('#requester-details').click(function (e) {
    $('.print-ticket-requester-details').toggle();
})

$('#printTicket').click(function (e) {
    window.print()
})
