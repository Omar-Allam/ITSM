<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Ticket #{{$reply->ticket_id}}</title>
</head>
<body>
    <div style="font-size: 13px; font-face: arial,helvetica,sans-serif">
        <font family="arial,helvetica,sans-serif">
            Your ticket #{{$reply->ticket->id}} has a new reply. <br /><br />

            By: {{$reply->user->name}}<br/>
            At: {{$reply->created_at->format('d/m/Y H:i')}}<br/>
            Status: {{$reply->status->name}} <br /><br />
            Due Date: {{$ticket->due_date? $ticket->due_date->format('d/m/Y H:i') : 'N/A'}}<br/>
            Content: <br/><br/>
        </font>

        <div>
            {!! $reply->content !!}
        </div>
        <br/><br/>
        To view ticket details please go to {{link_to_route('ticket.show', null, $reply->ticket_id)}}
    </div>
</body>
</html>
