@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Priority</h4>
    <a href="{{ route('admin.priority.create') }} " class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    @if ($priorities->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($priorities as $priority)
                    <tr>
                        <td class="col-md-5"><a href="{{ route('admin.priority.edit', $priority) }}">{{ $priority->name }}</a></td>
                        <td class="col-md-3">
                            <form action="{{ route('admin.priority.destroy', $priority) }}" method="post">
                                {{csrf_field()}} {{method_field('delete')}}
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.priority.edit', $priority) }} "><i class="fa fa-edit"></i> Edit</a>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $priorities])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No priority found</strong></div>
    @endif
@stop
