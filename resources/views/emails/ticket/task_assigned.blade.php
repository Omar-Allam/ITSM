<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Ticket #{{$ticket->id}}</title>
</head>
<body>
<div style="font-size: 13px; font-face: arial,helvetica,sans-serif">
    <font family="arial,helvetica,sans-serif">
        Task #{{$task->id}} has been created for you on Ticket # {{$task->ticket->id}}. <br /><br />

        Subject: <strong>{{$task->subject}}</strong><br />
        Content: <br/><br/>
    </font>

    <div>
        {!! $task->description !!}
    </div>

    <br/><br/>
    To view ticket details please go to {{link_to_route('ticket.show', null, $task->ticket->id)}}
</div>
</body>
</html>
