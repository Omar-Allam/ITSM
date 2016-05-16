<ul class="list-group">
    <li class="list-group-item">
        <strong>Ticket created by {{$ticket->created_by->name}} at {{$ticket->created_at->format('d/m/Y H:i')}}</strong>
    </li>
    @foreach ($ticket->logs as $log)
        <li class="list-group-item">
            <strong>Ticket {{$log->action}} by {{$ticket->created_by->name}} at {{$ticket->created_at->format('d/m/Y H:i')}}</strong>
            @foreach($log->old_data as $key => $value)
                {{ $key }} changed from {{$value}} to {{$log->new_data[$key]}}
            @endforeach
        </li>
    @endforeach
</ul>