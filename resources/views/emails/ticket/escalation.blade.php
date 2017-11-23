<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>SLA escalation warning notification. Request # {{$ticket->id}}</title>
</head>
<body>
<div style="font-size: 13px; font-face: arial,helvetica,sans-serif">
    <font family="arial,helvetica,sans-serif">
        Requester : {{$ticket->requester->name}}<br>
        Category : {{$ticket->category->name}}<br>
        Title : {{$ticket->subject}}
    </font>

    <div>
        Content: {!! $ticket->description !!}
    </div>

    <br/><br/>
    To view ticket details please go to {{link_to_route('ticket.show', null, $ticket->id)}}
</div>
</body>
</html>
