<div class="panel panel-default panel-nav">
    <div class="panel-heading">
        <h5 class="panel-title"><a href="#usersNavPanel" data-toggle="collapse">Users</a></h5>
    </div>
    <div class="list-group collapse" id="usersNavPanel">
        <a href="{{route('admin.user.index')}}" class="list-group-item">Users</a>
        <a href="{{route('admin.group.index')}}" class="list-group-item">Groups</a>
    </div>
</div>

<div class="panel panel-default panel-nav">
    <div class="panel-heading">
        <h5 class="panel-title"><a href="#locationsNavPanel" data-toggle="collapse">Places</a></h5>
    </div>
    <div class="list-group collapse" id="locationsNavPanel">
        <a href="{{route('admin.region.index')}}" class="list-group-item">Regions</a>
        <a href="{{route('admin.city.index')}}" class="list-group-item">Cities</a>
        <a href="{{route('admin.location.index')}}" class="list-group-item">Locations</a>
    </div>
</div>

<div class="panel panel-default panel-nav">
    <div class="panel-heading">
        <h5 class="panel-title"><a href="#businessNavPanel" data-toggle="collapse">Business</a></h5>
    </div>
    <div class="list-group collapse" id="businessNavPanel">
        <a href="{{route('admin.business-unit.index')}}" class="list-group-item">Business units</a>
        <a href="{{route('admin.branch.index')}}" class="list-group-item">Branches</a>
        <a href="{{route('admin.department.index')}}" class="list-group-item">Departments</a>
    </div>
</div>
<div class="panel panel-default panel-nav">
    <div class="panel-heading">
        <h5 class="panel-title"><a href="#configNavPanel" data-toggle="collapse">Configuration</a></h5>
    </div>
    <div class="list-group collapse" id="configNavPanel">
        <a href="{{route('admin.category.index')}}" class="list-group-item">Categories</a>
        {{--<a href="{{route('admin.status.index')}}" class="list-group-item">Status</a>--}}
        <a href="{{route('admin.branch.index')}}" class="list-group-item">Impact</a>
        <a href="{{route('admin.priority.index')}}" class="list-group-item">Priority</a>
        <a href="{{route('admin.urgency.index')}}" class="list-group-item">Urgency</a>
        <a href="{{route('admin.business-rule.index')}}" class="list-group-item">Business Rules</a>
        <a href="{{route('admin.sla.index')}}" class="list-group-item">Service level agreements</a>
    </div>
</div>
