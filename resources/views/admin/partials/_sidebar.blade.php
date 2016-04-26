<div class="panel panel-default panel-nav">
    <div class="panel-heading">
        <h5 class="panel-title"><a href="#categoriesNavPanel" data-toggle="collapse">Categories</a></h5>
    </div>
    <div class="list-group collapse" id="categoriesNavPanel">
        <a href="{{route('admin.category.index')}}" class="list-group-item">Categories</a>
        <a href="{{route('admin.subcategory.index')}}" class="list-group-item">Subcategories</a>
        <a href="{{route('admin.item.index')}}" class="list-group-item">Items</a>
    </div>
</div>

<div class="panel panel-default panel-nav">
    <div class="panel-heading">
        <h5 class="panel-title"><a href="#locationsNavPanel" data-toggle="collapse">Locations</a></h5>
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
