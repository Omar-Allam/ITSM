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

            By: {{$reply->user->name}}
            At: {{$reply->created_at->format('d/m/Y H:i')}}
            Status: {{$reply->status->name}} <br /><br />
            Due Date: {{$reply->ticket->due_date->format('d/m/Y H:i')}}
            Content: <br/><br/>
        </font>

        <div>
            {!! $reply->cotent !!}
        </div>
        <br/><br/>
        To view ticket details please go to {{url('ticket/' . $reply->ticket_id)}}
    </div>
</body>
</html>
