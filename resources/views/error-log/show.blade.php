@extends('layouts.app')

@section('title', 'E#' . $errorLog->id . ' &mdash; Error Logs')

@section('header')
    <h3 class="flex">Error Logs</h3>
    <a href="{{ route('error-log.index') }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
@endsection

@section('body')
    <div class="col-sm-12">
        <p>
            <strong>Occured At: </strong> {{ $errorLog->created_at->format('d/m/Y H:i:s') }}

            @if ($errorLog->user)
                <strong>By: </strong> {{ $errorLog->user->name }}
            @endif
        </p>

        <h3><code>{{ $errorLog->message }} / {{ $errorLog->file }} @ {{ $errorLog->line }}</code></h3>

        @if ($errorLog->code)
            <pre><code>{{ $errorLog->code }}</code></pre>
        @endif

        <p>&nbsp;</p>
        
        @php $lines = explode(PHP_EOL, $errorLog->trace); @endphp
        <table class="table table-condensed">
            <tbody>
                @foreach ($lines as $line)    
                    <tr>
                        <td><code>{{ $line }}</code></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection