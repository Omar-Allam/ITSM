<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KDesk | Ticket Auto-close</title>
</head>
<body>
<div style="font-size: 13px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif">
    Dear {{$ticket->requester->name}}, <br/><br />
    Your ticket [#{{$ticket->id}}#] has been closed automatically by the system.
    Resolution of your ticket has been added on {{$ticket->resolve_date->format('d/m/Y')}}.<br><br>

    Your ticket's resolution is: <br>
    <p> =================================================== </p>

    {!! $ticket->resolution->content !!}

    <p> =================================================== </p>

    For more information please view ticket details at {{link_to_route('ticket.show', null, $ticket)}}
</div>
</body>
</html>