<div id="SearchForm" class="{{ !Session::has('ticket.filter') ? 'collapse' : '' }}">
    {{Form::open(['route' => 'ticket.filter'])}}

    <criteria :criterions="{{json_encode(session('ticket.filter'))}}"></criteria>

    <div class="clearfix">
        <div class="btn-toolbar pull-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
            <a href="{{route('ticket.clear')}}" class="btn btn-default"><i class="fa fa-remove"></i> Clear</a>
        </div>
    </div>

    <hr>

    {{Form::close()}}
</div>


