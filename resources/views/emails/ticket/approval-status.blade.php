<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Action taken on approval sent to {{$ticketApproval->approver->email}}</title>
</head>
<body>
<div style="font-size: 13px; font-face: arial,helvetica,sans-serif">
    <font family="arial,helvetica,sans-serif">
        Request ID : {{$ticketApproval->ticket_id}}
        @if ($ticketApproval->ticket->creator_id != $ticketApproval->ticket->requester_id)
            By: {{$ticketApproval->ticket->created_by->name}}<br/>
        @endif
        Requester: {{$ticketApproval->ticket->requester->name}}<br/>
        Subject: <strong>{{$ticketApproval->ticket->subject}}</strong><br>
        At: {{$ticketApproval->ticket->created_at->format('d/m/Y H:i')}}<br/>
        Status: {{$ticketApproval->approval_status}} <br />
        Action Date: {{$ticketApproval->updated_at? $ticketApproval->updated_at->format('d/m/Y H:i') : 'N/A'}}<br/>
        Content: <br/><br/>
    </font>

    <div>
        {!! $ticketApproval->comment !!}
    </div>

    <br/><br/>
    To view ticket details please go to {{link_to_route('ticket.show', null, $ticketApproval->ticket->id)}}
</div>
</body>
</html>
