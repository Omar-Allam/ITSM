@extends('layouts.app')

@section('header')
    <h4>Ticket Reports</h4>
    <a href="/report" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
@endsection

@section('body')
    <div class="col-sm-12">
        <div class="report-container">
            @if (!empty($title))
                <h3 class="page-header">{{$title}}</h3>
            @endif

            <div class="display-flex">
                {{$results->links()}}
            </div>

            <section class="report-table-container">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        @foreach($fields as $field)
                            <th>{{$fieldLabels[$field]}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($results as $row)
                        <tr>
                            @foreach($fields as $field)
                                <td>
                                    @if ($field == 'id')
                                        <a href="{{route('ticket.show', $row['id'])}}"><strong>{{$row['id']}}</strong></a>
                                    @elseif (is_a($row[$field], \Carbon\Carbon::class))
                                        {{$row[$field]->format('d/m/Y H:i')}}
                                    @else
                                        {{$row[$field] ?: 'N/A'}}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>

            <div class="display-flex">
                {{$results->links()}}
            </div>

        </div>
    </div>

@endsection