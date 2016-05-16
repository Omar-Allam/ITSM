
@if ($ticket->approvals->count())
    <table class="listing-table">
        <thead>
        <tr>
            <th>Sent to</th>
            <th>By</th>
            <th>Sent at</th>
            <th>Status</th>
            <th>Comment</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ticket->approvals as $approval)
            <tr>
                <td>{{$approval->approver->name}}</td>
                <td>{{$approval->created_by->name}}</td>
                <td>{{$approval->created_at->format('d/m/Y H:i')}}</td>
                <td>{{App\TicketApproval::$statuses[$approval->status]}}</td>
                <td>{{$approval->comment}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@else
    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> No approvals yet</div>
@endif