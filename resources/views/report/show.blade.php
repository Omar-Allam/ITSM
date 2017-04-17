@extends('layouts.app')

@section('header')
    <div class="clearfix">
        <h4 class="pull-left">Ticket Reports</h4>
        <a href="/report" class="btn btn-default btn-sm pull-right"><i class="fa fa-chevron-left"></i></a>
    </div>
@endsection

@section('body')

    <table class="table table-bordered table-striped table-condensed">
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

    <div class="text-center">
        {{$results->links()}}
    </div>

@endsection