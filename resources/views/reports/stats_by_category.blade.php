@extends('layouts.app')

@section('header')
    <h2>{{ $report->title }}</h2>
    <a href=""></a>
    <div class="btn-toolbar">
        <a href="?excel" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> {{ t('Excel') }}</a>
        <a href="{{route('reports.index')}}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> {{ t('Back') }}</a>
    </div>
@endsection

@section('body')
    <div class="container report-container">

        <section class="report-horizontal-scroll">
            <table class="table table-condensed report-table">
                <thead>
                <tr>
                    <th>{{ t('Category') }}</th>
                    <th>{{ t('Subcategory') }}</th>
                    <th>{{ t('Count of Requests') }}</th>
                    <th>{{ t('Resolved') }}</th>
                    <th>{{ t('On Time') }}</th>
                    <th>{{ t('Late') }}</th>
                    <th>{{ t('Very Late') }}</th>
                    <th>{{ t('Critical Late') }}</th>
                    <th>{{ t('Open') }}</th>
                    <th>{{ t('On Hold') }}</th>
                    <th>{{ t('Performance') }}</th>
                </tr>
                </thead>

                    <tbody>
                    @foreach ($data->groupBy('category') as $category => $tickets)
                        <tr class="group-head">
                            <th colspan="11">{{ $category }}</th>
                        </tr>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->category }}</td>
                                <td>{{ $ticket->subcategory }}</td>
                                <td>{{number_format($ticket->total)}}</td>
                                <td>{{number_format($ticket->total_resolved)}}</td>
                                <td>{{number_format($ticket->ontime)}}</td>
                                <td>{{number_format($ticket->late)}}</td>
                                <td>{{number_format($ticket->very_late)}}</td>
                                <td>{{number_format($ticket->critical_late)}}</td>
                                <td>{{number_format($ticket->open)}}</td>
                                <td>{{number_format($ticket->onhold)}}</td>
                                <td>{{number_format($ticket->performance, 2)}}%</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </section>

        <div class="text-center">
            {{$data->links()}}
        </div>
    </div>




@endsection