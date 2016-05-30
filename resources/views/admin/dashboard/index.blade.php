@extends('layouts.app')

@section('header')
    <h4>Admin</h4>
@stop

@section('body')
    <div class="row">
        <div class="col-md-4">
            <h5>Users</h5>
            <ul class="list-inline">
                <li><a href="{{route('admin.user.index')}}">Users</a></li>
                <li><a href="{{route('admin.group.index')}}">Groups</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <h5>Categories</h5>
            <div class="nav">
                <ul class="list-inline">
                    <li><a href="{{route('admin.category.index')}}">Categories</a></li>
                    <li><a href="{{route('admin.subcategory.index')}}">Subcategories</a></li>
                    <li><a href="{{route('admin.item.index')}}">Items</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <h5>Locations</h5>
            <ul class="list-inline">
                <li><a href="{{route('admin.region.index')}}">Regions</a></li>
                <li><a href="{{route('admin.city.index')}}">Cities</a></li>
                <li><a href="{{route('admin.location.index')}}">Location</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <hr />
        </div>
        <div class="col-md-4">
            <h5>Business Units</h5>
            <ul class="list-inline">
                <li><a href="{{route('admin.business-unit.index')}}">Business Units</a></li>
                <li><a href="{{route('admin.branch.index')}}">Branches</a></li>
                <li><a href="{{'admin.department.index'}}">Departments</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <h5>Configuration</h5>
            <ul class="list-inline">
                <li><a href="{{route('admin.sla.index')}}">Service Level Agreement</a></li>
                <li><a href="{{route('admin.business-rule.index')}}">Business Rules</a></li>
                <li><a href="{{route('admin.priority.index')}}">Priority</a></li>
                <li><a href="{{route('admin.urgency.index')}}">Urgency</a></li>
                <li><a href="{{route('admin.impact.index')}}">Impact</a></li>
            </ul>

        </div>
    </div>
@endsection