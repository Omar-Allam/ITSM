@if ($ticket->replies->count() || $ticket->approvals->count())
    <section class="replies">

        <h4>{{t('Ticket Replies')}}</h4>

        @include('ticket.partials._ticket_conversations')

        <h4>{{t('Ticket Approvals')}}</h4>

        @include('ticket.partials._ticket_approvals')
    </section>
@endif