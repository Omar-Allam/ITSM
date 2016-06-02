@extends('layouts.app')

@section('header')
    <h4 class="pull-left">Categories - {{$category->name}}</h4>

    <div class="pull-right">
        <a href="{{route('admin.category.edit', $category)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
        <a href="{{route('admin.category.index')}}" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>
    </div>
@endsection

@section('body')

@endsection