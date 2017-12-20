<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approval request</title>
</head>
<body style="margin: 10px;padding: 10px">
<p>Attachments have been uploaded to your request ##{{$ticket->sdp_id}}## by {{$ticket->technician->name}}</p><br>

<div style="font-size: 13px; font-family: 'Helvetica Neue', Helvetica, Arial,sans-serif">
    @foreach($attachs as $key=>$attach)
        {{$key+1}} : <a href="{{$attach->url}}"> {{basename($attach->url)}}</a><br>
    @endforeach
    To view ticket details please go to <a href="http://helpdesk.alkifah.com/WorkOrder.do?woMode=viewWO&woID={{$ticket->sdp_id}}"> HelpDesk</a>
</div>
</body>
</html>