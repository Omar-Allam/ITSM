<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-user"></i> {{t('Requester Details')}}</h4>
    </div>
    <table class="table table-striped table-condensed">
        <tr>
            <th class="col-sm-3">{{t('Name')}}</th>
            <td class="col-sm-3">{{$ticket->requester->name}}</td>
            <th class="col-sm-3">{{t('Business Unit')}}</th>
            <td class="col-sm-3">{{$ticket->requester->business_unit->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Email')}}</th>
            <td>{{$ticket->requester->email or 'Not Assigned'}}</td>
            <th>{{t('Location')}}</th>
            <td>{{$ticket->requester->location->name or 'Not Assigned'}}</td>
        </tr>
        <tr>
            <th>{{t('Phone')}}</th>
            <td>{{$ticket->requester->phone or 'Not Assigned'}}</td>
            <th>{{t('Mobile')}}</th>
            <td>{{$ticket->requester->mobile or 'Not Assigned'}}</td>
        </tr>
    </table>
</div>