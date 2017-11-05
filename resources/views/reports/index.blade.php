@extends('layouts.app')

@section('title', t('Reports'))

@section('header')
    <h2>Reports</h2>
@endsection

@section('sidebar')
    @include('reports._sidebar')
@endsection

@section('body')
    <div class="col-sm-9">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Report</th>
                <th>Created By</th>
                <th>Created at</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td><a href="{{route('reports.show', $report)}}">{{$report->title}}</a></td>
                    <td>{{$report->user->name}}</td>
                    <td>{{$report->created_at->format('d/m/Y H:i')}}</td>
                    <td class="col-md-2 col-sm-3">
                        <article class="actions">
                            <a href="{{route('reports.show', $report)}}"><i class="fa fa-eye"></i> View</a> |
                            <a href="{{route('reports.edit', $report)}}"><i class="fa fa-edit"></i> Edit</a>
                        </article>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('stylesheets')
    <style>
        .actions {
            display: none;
        }

        tr:hover .actions {
            display: block;
        }
    </style>
@endsection
