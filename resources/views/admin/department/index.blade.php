@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Departments</h4>
    <a href="{{route('admin.department.create')}}" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('body')
    <section class="col-sm-9">
    @if ($departments->total())
            <table class="listing-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Business Unit</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td class="col-md-5"><a href="{{route('admin.department.edit', $department)}}">{{$department->name}}</a></td>
                        <td class="col-md-4">{{$department->business_unit->name}}</td>
                        <td class="col-md-3">
                            <a class="btn btn-sm btn-primary" href="{{route('admin.department.edit', $department)}}"><i class="fa fa-edit"></i> Edit</a>
                            <form action="{{route('admin.department.destroy', $department)}}" method="post" class="inline-block">
                                {{csrf_field()}} {{method_field('delete')}}
                                <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        
            @include('partials._pagination', ['items' => $departments])
        @else
            <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No departments found</strong></div>
        @endif
        </section>
@stop