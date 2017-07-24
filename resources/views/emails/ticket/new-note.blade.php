<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Note #{{$note->id}}</title>
</head>
<body>
<div style="font-size: 13px; font-face: arial,helvetica,sans-serif">
    <font family="arial,helvetica,sans-serif">
        Your assigned ticket #{{$note->ticket->id}} has been updated with a note #{{$note->id}}<br /><br />
        By: {{$note->creator->name or 'N/A'}}<br />
        At: {{$note->created_at->format('d/m/Y H:i A')}}<br/>
        Note:
    </font>

    <div>
        {!! $note->note !!}
    </div>

    <br/><br/>
    To view ticket details please go to {{link_to_route('ticket.show', null, $note->id)}}
</div>
</body>
</html>
