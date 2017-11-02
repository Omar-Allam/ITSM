<div class="col-sm-3">
    <div class="form-group">
        <a href="{{route('reports.create')}}" class="btn btn-success btn-block">
            <i class="fa fa-plus"></i> Create Report
        </a>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h4 class="panel-title">Folders</h4>
        </div>

        <section class="list-group">
            @foreach($folders as $folder)
                <a href="/reports?folder={{$folder->id}}" class="list-group-item {{request('folder') == $folder->id? 'active' : ''}}">
                    <i class="fa fa-fw fa-folder{{request('folder') == $folder->id? '-open' : ''}}"></i> {{$folder->name}}
                </a>
            @endforeach
        </section>
    </div>
</div>