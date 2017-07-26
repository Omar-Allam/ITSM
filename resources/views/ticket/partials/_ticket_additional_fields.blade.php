@if ($ticket->fields->count())
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-asterisk"></i> {{t('Additional Information')}}</h4>
    </div>

    <table class="table table-bordered table-condensed table-striped">
        <tbody>
        @foreach($ticket->fields as $field)
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