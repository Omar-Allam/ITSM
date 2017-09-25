@extends('layouts.app')

@section('header')
<h2>{{ $report->title }}</h2>
<a href=""></a>
<div class="btn-toolbar">
    <a href="?excel" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> {{ t('Excel') }}</a>
    <a href="/reports" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> {{ t('Back') }}</a>
</div>
@endsection

@section('body')
<div class="container-fluid report-container">

    <section class="report-horizontal-scroll" style="style="width: 2650px"">
        <table class="table table-condensed report-head">
            <thead>
                <tr>
                    <th style="min-width: 100px; max-width: 100px">{{ t('ID') }}</th>
                    <th style="min-width: 100px; max-width: 100px">{{ t('Helpdesk ID') }}</th>
                    <th style="min-width: 300px; max-width: 300px">{{ t('Subject') }}</th>
                    <th style="min-width: 300px; max-width: 300px">{{ t('Technician') }}</th>
                    <th style="min-width: 300px; max-width: 300px">{{ t('Requester') }}</th>
                    <th style="min-width: 300px; max-width: 300px">{{ t('Category') }}</th>
                    <th style="min-width: 300px; max-width: 300px">{{ t('Subcategory') }}</th>
                    <th style="min-width: 100px; max-width: 100px">{{ t('Item') }}</th>
                    <th style="min-width: 150px; max-width: 150px">{{ t('Created At') }}</th>
                    <th style="min-width: 150px; max-width: 150px">{{ t('Due Date') }}</th>
                    <th style="min-width: 150px; max-width: 150px">{{ t('Resolved At') }}</th>
                    <th style="min-width: 100px; max-width: 100px">{{ t('SLA Time (In Hours)') }}</th>
                    <th style="min-width: 100px; max-width: 100px">{{ t('Resolve Time (In Hours)') }}</th>
                    <th style="min-width: 100px; max-width: 100px">{{ t('Performance') }}</th>
                    <th style="min-width: 100px; max-width: 100px">{{ t('Type') }}</th>
                </tr>
            </thead>
        </table>
        <section class="report-vertical-scroll" style="width: 2650px">
            <table class="table table-condensed report-body">
                <tbody>
                    @foreach ($data->sortBy('category')->groupBy('category') as $category => $tickets)
                    <tr class="group-head">
                        <th colspan="14">{{ $category }}</th>
                    </tr>

                    @foreach ($tickets as $ticket)
                    <tr>
                        <td style="min-width: 100px; max-width: 100px">
                            <a target="blank" href="{{ route('ticket.show', $ticket) }}">
                                <strong>{{ $ticket->id }}</strong>
                            </a>
                        </td>
                        <td style="min-width: 100px; max-width: 100px">
                            <a target="blank" href="http://helpdesk.alkifah.com/WorkOrder.do?woMode=viewWO&woID={{ $ticket->sdp_id }}">
                                <strong>{{ $ticket->sdp_id }}</strong>
                            </a>
                        </td>
                        <td style="min-width: 300px; max-width: 300px"><bdi>{{ $ticket->subject }}</bdi></td>
                        <td style="min-width: 300px; max-width: 300px">{{ $ticket->technician }}</td>
                        <td style="min-width: 300px; max-width: 300px">{{ $ticket->requester }}</td>
                        <td style="min-width: 300px; max-width: 300px">{{ $ticket->category }}</td>
                        <td style="min-width: 300px; max-width: 300px">{{ $ticket->subcategory }}</td>
                        <td style="min-width: 100px; max-width: 100px">{{ $ticket->item }}</td>
                        <td style="min-width: 150px; max-width: 150px">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                        <td style="min-width: 150px; max-width: 150px">{{ $ticket->due_date->format('d/m/Y H:i') }}</td>
                        <td style="min-width: 150px; max-width: 150px">{{ $ticket->resolve_date ? $ticket->resolve_date->format('d/m/Y H:i') : '' }}</td>
                        <td style="min-width: 100px; max-width: 100px">{{ number_format($ticket->sla_time, 1) }}</td>
                        <td style="min-width: 100px; max-width: 100px">{{ number_format($ticket->resolve_time, 1) }}</td>
                        <td style="min-width: 100px; max-width: 100px">{{ number_format($ticket->performance, 1)}}%</td>
                        <td style="min-width: 100px; max-width: 100px">{{ $ticket->service_request? 'Service' : 'Incident' }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>

    <div class="text-center">
        {{ $data->links() }}
    </div>
    
</div>




@endsection