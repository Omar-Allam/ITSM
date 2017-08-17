<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approval request</title>
</head>
<body style="margin: 10px;padding: 10px">
<p>There are attachments have been uploaded to your request by {{$ticket->technician->name}} on your Ticket #{{$ticket->sdp_id}}</p><br>

<div style="font-size: 13px; font-family: 'Helvetica Neue', Helvetica, Arial,sans-serif">
    @foreach($attachs as $key=>$attach)
        {{$key+1}} : <a href="{{$attach->url}}"> {{basename($attach->url)}}</a><br>
    @endforeach
    To view ticket details please go to {{route('ticket.show', $ticket->id)}}
</div>
</body>
</html>