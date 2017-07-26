<section class="col-sm-6">
    <section class="ticket">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-user"></i> {{t('Requester Details')}}</h4>
            </div>
            <table class="table table-striped table-condensed">
                <tr>
                    <th>{{t('Name')}}</th>
                    <td>{{$ticketApproval->ticket->requester->name}}</td>
                    <th>{{t('Business Unit')}}</th>
                    <td>{{$ticketApproval->ticket->requester->business_unit->name or 'Not Assigned'}}</td>
                </tr>
                <tr>
                    <th>{{t('Email')}}</th>
                    <td>{{$ticketApproval->ticket->requester->email or 'Not Assigned'}}</td>
                    <th>{{t('Location')}}</th>
                    <td>{{$ticketApproval->ticket->requester->location->name or 'Not Assigned'}}</td>
                </tr>
                <tr>
                    <th>{{t('Phone')}}</th>
                    <td>{{$ticketApproval->ticket->requester->phone or 'Not Assigned'}}</td>
                    <th>{{t('Mobile')}}</th>
                    <td>{{$ticketApproval->ticket->requester->mobile or 'Not Assigned'}}</td>
                </tr>
            </table>
        </div>
        @if ($ticketApproval->ticket->fields->count())
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-asterisk"></i> {{t('Additional Information')}}</h4>
                </div>

                <table class="table table-bordered table-condensed table-striped">
                    <tbody>
                    @foreach($ticketApproval->ticket->fields as $field)
                        <tr>
                            <td class="col-sm-4 text-right"><strong>{{$field->name}}</strong></td>
                            <td>
                                {{$field->value}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</section>