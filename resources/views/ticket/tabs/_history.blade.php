<ul class="list-group">
    <li class="list-group-item">
        <strong>Ticket created by {{$ticket->created_by->name}} at {{$ticket->created_at->format('d/m/Y H:i')}}</strong>
    </li>
    @foreach ($ticket->logs as $log)
        <li class="list-group-item">
            <strong>Ticket {{$log->type_action}} by {{$log->user->name}}
                at {{$ticket->created_at->format('d/m/Y H:i')}}</strong>
            <ul>
                @foreach($log->entries as $entry)
                    <li>
                        <small>{{ $entry->label }} changed from <strong>{{$entry->old_value}}</strong>
                            to <strong>{{$entry->new_value}}</strong></small>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>