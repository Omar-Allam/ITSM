<div id="SearchForm" class="{{ !Session::has('ticket.filter') ? 'collapse' : '' }}">
    {{Form::open(['route' => 'ticket.filter'])}}

    <criteria :criterions="{{json_encode(session('ticket.filter'))}}"></criteria>

    <div class="form-group clearfix">
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
    </div>

    {{Form::close()}}
</div>


