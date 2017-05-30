@extends('layouts.app')

@section('header')
    <h4>Admin</h4>
@stop

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Users</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills">
                            <li><a href="{{route('admin.user.index')}}">Users</a></li>
                            <li><a href="{{route('admin.group.index')}}">Groups</a></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Categories</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills">
                            <li><a href="{{route('admin.category.index')}}">Categories</a></li>
                            <li><a href="{{route('admin.subcategory.index')}}">Subcategories</a></li>
                            <li><a href="{{route('admin.item.index')}}">Items</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Locations</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills">
                            <li><a href="{{route('admin.region.index')}}">Regions</a></li>
                            <li><a href="{{route('admin.city.index')}}">Cities</a></li>
                            <li><a href="{{route('admin.location.index')}}">Location</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <hr/>
            </div>

            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Business Units</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills">
                            <li><a href="{{route('admin.business-unit.index')}}">Business Units</a></li>
                            <li><a href="{{route('admin.branch.index')}}">Branches</a></li>
                            <li><a href="{{'admin.department.index'}}">Departments</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Business Units</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-pills">
                            <li><a href="{{route('admin.sla.index')}}">Service Level Agreement</a></li>
                            <li><a href="{{route('admin.business-rule.index')}}">Business Rules</a></li>
                            <li><a href="{{route('admin.priority.index')}}">Priority</a></li>
                            <li><a href="{{route('admin.urgency.index')}}">Urgency</a></li>
                            <li><a href="{{route('admin.impact.index')}}">Impact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection