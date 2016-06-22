{{'@'}}extends('layouts.app')

{{'@'}}section('header')
    <h4 class="pull-left">{{$humanUp}}</h4>
    <a href="{{'{{'}} route('{{$viewPrefix}}.create') }} " class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i></a>
{{'@'}}stop

{{'@'}}section('body')
    {{'@'}}if (${{$plural}}->total())
        <table class="listing-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                {{'@'}}foreach(${{$plural}} as ${{$single}})
                    <tr>
                        <td class="col-md-5"><a href="{{'{{'}} route('{{$viewPrefix}}.edit', ${{$single}}) }}">{{'{{'}} ${{$single}}->name }}</a></td>
                        <td class="col-md-3">
                            <form action="{{'{{'}} route('{{$viewPrefix}}.destroy', ${{$single}}) }}" method="post">
                                @{{csrf_field()}} @{{method_field('delete')}}
                                <a class="btn btn-sm btn-primary" href="{{'{{'}} route('{{$viewPrefix}}.edit', ${{$single}}) }} "><i class="fa fa-edit"></i> Edit</a>
                                <button class="btn btn-sm btn-warning"><i class="fa fa-trash-o"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                {{'@'}}endforeach
            </tbody>
        </table>

        {{'@'}}include('partials._pagination', ['items' => ${{$plural}}])
    {{'@'}}else
        <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <strong>No {{$humanLow}} found</strong></div>
    {{'@'}}endif
{{'@'}}stop
