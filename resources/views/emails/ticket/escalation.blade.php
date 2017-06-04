<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Escalation Ticket #{{$ticket->id}}</title>
</head>
<body>
<div style="font-size: 13px; font-face: arial,helvetica,sans-serif">
    <font family="arial,helvetica,sans-serif">
        Ticket #{{$ticket->id}} has been Escalated to you as it is exceed it's resolution time. <br /><br />

        @if ($ticket->creator_id != $ticket->requester_id)
            By: {{$ticket->created_by->name}}<br/>
        @endif
        Technician: {{$ticket->technician->name or 'N/A'}}<br />
        Subject: <strong>{{$ticket->subject}}</strong><br />
        Created at: {{$ticket->created_at->format('d/m/Y H:i')}}<br/>
    </font>

    <div>
        Content: {!! $ticket->description !!}
    </div>

    <br/><br/>
    To view ticket details please go to {{link_to_route('ticket.show', null, $ticket->id)}}
</div>
</body>
</html>
