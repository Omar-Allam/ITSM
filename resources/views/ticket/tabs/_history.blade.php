<ul class="list-group">
    <li class="list-group-item">
        <strong>{{t('Ticket created by')}}  {{$ticket->created_by->name}} at {{$ticket->created_at->format('d/m/Y H:i')}}</strong>
    </li>
    @foreach ($ticket->logs as $log)
        <li class="list-group-item">
            @if ($log->type == \App\TicketLog::AUTO_CLOSE)
                <strong>Ticket has been closed by the system</strong>
            @else
                <strong>{{t('Ticket '.$log->type_action.' by')}}   {{$log->user->name}}
                    {{t('at')}} {{$log->created_at->format('d/m/Y H:i')}}</strong>
                <ul>
                    @foreach($log->entries as $entry)
                        <li>
                            <small>{{ t($entry->label.' changed from') }}  <strong>{{t($entry->old_value) ?: 'None'}}</strong>
                                {{t('to')}} <strong>{{t($entry->new_value) ?: 'None'}}</strong></small>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>