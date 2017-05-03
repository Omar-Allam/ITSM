<div class="col-sm-3">
<section class="panel panel-primary" id="#admin-sidebar">
    <div class="panel-heading">
        <h5 class="panel-title">Navigation</h5>
    </div>

    <nav class="list-group">
        <p class="list-group-item text-center info"><i class="fa fa-fw fa-group"></i> <strong>Users</strong></p>
        <a href="{{route('admin.user.index')}}" class="user-link list-group-item"><i class="fa fa-fw fa-user"></i> Users</a>
        <a href="{{route('admin.group.index')}}" class="user-link list-group-item"><i class="fa fa-fw fa-group"></i> Groups</a>

        <p class="list-group-item text-center info"><strong><i class="fa fa-fw fa-map"></i> Places</strong></p>
        <a href="{{route('admin.region.index')}}" class="list-group-item"><i class="fa fa-fw fa-map"></i> Regions</a>
        <a href="{{route('admin.city.index')}}" class="list-group-item"><i class="fa fa-fw fa-map-signs"></i> Cities</a>
        <a href="{{route('admin.location.index')}}" class="list-group-item"><i class="fa fa-fw fa-map-marker"></i> Locations</a>

        <p class="list-group-item text-center info"><strong><i class="fa fa-fw fa-university"></i> Business</strong></p>
        <a href="{{route('admin.business-unit.index')}}" class="list-group-item"><i class="fa fa-fw fa-building"></i> Business units</a>
        <a href="{{route('admin.branch.index')}}" class="list-group-item"><i class="fa fa-fw fa-sitemap"></i> Branches</a>
        <a href="{{route('admin.department.index')}}" class="list-group-item"><i class="fa fa-fw fa-leaf"></i> Departments</a>

        <p class="list-group-item text-center info"><strong><i class="fa fa-fw fa-cogs"></i> Settings</strong></p>
        <a href="{{route('admin.category.index')}}" class="list-group-item"><i class="fa fa-fw fa-cubes"></i> Categories</a>
        {{--<a href="{{route('admin.status.index')}}" class="list-group-item">Status</a>--}}
        <a href="{{route('admin.impact.index')}}" class="list-group-item"><i class="fa fa-fw fa-bullseye"></i> Impact</a>
        <a href="{{route('admin.priority.index')}}" class="list-group-item"><i class="fa fa-fw fa-star"></i> Priority</a>
        <a href="{{route('admin.urgency.index')}}" class="list-group-item"><i class="fa fa-fw fa-hourglass-half"></i> Urgency</a>
        <a href="{{route('admin.business-rule.index')}}" class="list-group-item"><i class="fa fa-fw fa-magic"></i> Business Rules</a>
        <a href="{{route('admin.sla.index')}}" class="list-group-item"><i class="fa fa-fw fa-clock-o"></i> Service level agreements</a>
    </nav>

</section>
</div>