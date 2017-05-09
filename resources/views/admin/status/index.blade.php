@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Status</h4>
    <a href="{{ route('admin.status.create') }} " class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    <section class="col-sm-9">
    @if ($statuses->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($statuses as $status)
                    <tr>
                        <td class="col-md-5"><a href="{{ route('admin.status.edit', $status) }}">{{ $status->name }}</a></td>
                        <td class="col-md-3">
                            <form action="{{ route('admin.status.destroy', $status) }}" method="post">
                                {{csrf_field()}} {{method_field('delete')}}
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.status.edit', $status) }} "><i class="fa fa-edit"></i> Edit</a>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $statuses])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No status found</strong></div>
    @endif
    </section>
@stop
