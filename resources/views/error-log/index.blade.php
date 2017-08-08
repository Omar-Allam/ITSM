@extends('layouts.app')

@section('title', 'Error Logs')

@section('header')
    <h3>Error Logs</h3>
@endsection

@section('body')
    <div class="col-sm-12">
        
        @if ($errorLogs->count())
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="col-sm-8">Message</th>
                        <th class="col-sm-2">User</th>
                        <th class="col-sm-2">Time</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($errorLogs as $log)
                        <tr>
                            <td><strong>{{ $log->id }}</strong></td>
                            <td>
                                <a href="{{ route('error-log.show', $log) }}" title="{{ $log->message }}">{{ str_limit($log->message, 130)  }}</a>
                            </td>
                            <td>{{ $log->user->name ?? '' }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                Hoooooray, no errors found 🎉
            </div>
        @endif


    </div>
@endsection