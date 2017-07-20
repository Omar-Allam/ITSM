$(document).ready(function () {
    $('.addNote').on('click',function (e) {
        let modal = $('#ReplyModal');
        modal.find('.modal-title').html('Add Note - Ticket#' + ticket.id);
        modal.find('button[type=submit]').html('<i class="fa fa-save"></i> Add Note');
        let form = modal.closest('form').attr('action','note/'+ticket.id);
        tinyMCE.activeEditor.setContent('');
        $('#display_to_requester').attr('checked', note.display_to_requester==1 ? true : false);
        $('#email_to_technician').attr('checked', note.email_to_technician==1 ? true : false);
        $('#as_first_response').parent().show();
        $('#as_first_response').attr('checked', note.as_first_response==1 ? true : false);
    });

    $('.editNote').on('click', function (e) {
        let modal = $('#ReplyModal');
        let note = $(this).data('note');
        modal.find('.modal-title').html('Edit Note - Ticket #' + note.ticket_id);
        modal.find('button[type=submit]').html('<i class="fa fa-save"></i> Save');
        let form = modal.closest('form').attr('action','note-edit/'+note.id);
        tinyMCE.activeEditor.setContent(note.note);
        $('#display_to_requester').attr('checked', note.display_to_requester==1 ? true : false);
        $('#email_to_technician').attr('checked', note.email_to_technician==1 ? true : false);
        $('#as_first_response').parent().hide();
    });

    $('.removeNote').on('click',function () {
        let modal = $('#removeNoteModal');
        let note = $(this).data('note');
        modal.find('.modal-title').html('Remove Note #' + note.id + '  - Ticket #'+note.ticket_id);
        modal.find('.modal-body').html('Are you sure to delete #' + note.id + ' note ?');
        let form = modal.closest('form').attr('action','remove-note/'+note.id);
    })
});