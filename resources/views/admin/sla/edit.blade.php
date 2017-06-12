@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Edit Service Level Agreement</h4>

    <form action="{{ route('admin.sla.destroy', $sla)}}" class="pull-right" method="post">
        {{csrf_field()}} {{method_field('delete')}}
        <a href="{{ route('admin.sla.index')}}" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i></a>
        <button class="btn btn-sm btn-warning" type="submit"><i class="fa fa-trash-o"></i></button>
    </form>
@stop

@section('sidebar')
    @include('admin.partials._sidebar')
@stop

@section('body')
    {{ Form::model($sla, ['route' => ['admin.sla.update', $sla], 'class' => 'col-sm-9']) }}

    {{ method_field('patch') }}

    @include('admin.sla._form')

    {{ Form::close() }}
@stop
@section('javascript')
    <script>
        let selectedItems = [];
        let selectedId = [];
        var clickedButton;
        let modalTech = jQuery('#techModal');

        jQuery('button[data-close=chooseTech]').click(function (e) {
            clickedButton = e;
        })

        jQuery('#chooseTech').click(function (e) {
            jQuery('#technicians :selected').each(function (index, item) {
                selectedItems[index] = jQuery(item).text();
                selectedId[index] = jQuery(item).val();
            })

            jQuery(clickedButton.target).parents('tr').find('input[type=text]').val(selectedItems)
            modalTech.modal('hide');
        })

    </script>
    {{--<input type='hidden' name='tech"+selectedId[i]+"' value='"+selectedId[i]+"'>--}}
@endsection