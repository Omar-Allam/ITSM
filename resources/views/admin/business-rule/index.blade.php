@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Business rule</h4>
    <a href="{{ route('admin.business-rule.create') }} " class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    <section class="col-sm-9">
    @if ($businessRules->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($businessRules as $business_rule)
                    <tr>
                        <td class="col-md-5"><a href="{{ route('admin.business-rule.edit', $business_rule) }}">{{ $business_rule->name }}</a></td>
                        <td class="col-md-3">
                            <form action="{{ route('admin.business-rule.destroy', $business_rule) }}" method="post">
                                {{csrf_field()}} {{method_field('delete')}}
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.business-rule.edit', $business_rule) }} "><i class="fa fa-edit"></i> Edit</a>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials._pagination', ['items' => $businessRules])
    @else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No business rule found</strong></div>
    @endif
    </div>
@stop
