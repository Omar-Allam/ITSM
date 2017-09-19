@extends('layouts.app')

@section('header')
    <h2>{{ $report->title }}</h2>
    <a href=""></a>
    <div class="btn-toolbar">
        <a href="?excel" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> {{ t('Excel') }}</a>
        <a href="{{route('reports.index')}}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> {{ t('Back') }}
        </a>
    </div>
@endsection

@section('body')
    <div class="container report-container">

        <section class="report-horizontal-scroll">
            <table class="table table-condensed report-head">
                <thead>
                <tr>
                    <th class="col-sm-3">{{ t('Technician') }}</th>
                    <th class="col-sm-1">{{ t('Count of Requests') }}</th>
                    <th class="col-sm-1">{{ t('Resolved') }}</th>
                    <th class="col-sm-1">{{ t('On Time') }}</th>
                    <th class="col-sm-1">{{ t('Late') }}</th>
                    <th class="col-sm-1">{{ t('Very Late') }}</th>
                    <th class="col-sm-1">{{ t('Critical Late') }}</th>
                    <th class="col-sm-1">{{ t('Open') }}</th>
                    <th class="col-sm-1">{{ t('On Hold') }}</th>
                    <th class="col-sm-1">{{ t('Performance') }}</th>
                </tr>
                </thead>
            </table>
            <div class="report-vertical-scroll">
                <table class="table table-condensed report-body">
                    <tbody>
                    @foreach ($data as $ticket)
                        <tr>
                            <td class="col-sm-3">{{ $ticket->technician }}</td>
                            <td class="col-sm-1">{{number_format($ticket->total)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->total_resolved)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->ontime)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->late)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->very_late)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->critical_late)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->open)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->onhold)}}</td>
                            <td class="col-sm-1">{{number_format($ticket->performance, 2)}}%</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <div class="text-center">
            {{$data->links()}}
        </div>
    </div>




@endsection