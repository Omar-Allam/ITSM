@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Service Level Agreements</h4>
    <a href="{{ route('admin.sla.create') }} " class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    @if ($slas->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($slas as $sla)
                    <tr>
                        <td class="col-md-5"><a href="{{ route('admin.sla.edit', $sla) }}">{{ $sla->name }}</a></td>
                        <td class="col-md-3">
                            <form action="{{ route('admin.sla.destroy', $sla) }}" method="post">
                                {{csrf_field()}} {{method_field('delete')}}
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.sla.edit', $sla) }} "><i class="fa fa-edit"></i> Edit</a>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $slas])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No service level agreements found</strong></div>
    @endif
@stop
