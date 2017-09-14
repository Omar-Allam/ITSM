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
                    <th class="col-sm-3">{{ t('Category') }}</th>
                    <th class="col-sm-3">{{ t('Subcategory') }}</th>
                    <th class="col-sm-2">{{ t('Target Time (Hours)') }}</th>
                    <th class="col-sm-2">{{ t('Resolve Time (Hours)') }}</th>
                    <th class="col-sm-2">{{ t('Performance') }}</th>
                </tr>
                </thead>

                    <tbody>
                    @foreach ($data->sortBy('category')->groupBy('category') as $category => $tickets)
                        <tr class="group-head">
                            <th colspan="4">{{ $category }}</th>
                            <th>{{ number_format($tickets->avg('performance'), 2) }}%</th>
                        </tr>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="col- sm-3">{{ $ticket->category }}</td>
                                <td class="col-sm-3">{{ $ticket->subcategory }}</td>
                                <td class="col-sm-2">{{number_format($ticket->target_time, 1)}}</td>
                                <td class="col-sm-2">{{number_format($ticket->resolve_time, 1)}}</td>
                                <td class="col-sm-2">{{number_format($ticket->performance, 2)}}%</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </section>
    </div>




@endsection