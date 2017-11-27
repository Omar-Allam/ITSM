@extends('layouts.app')

@section('header')
    <div class="display-flex">
        <h2 class="flex">Create Report</h2>

        <a href="{{route('reports.index')}}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
    </div>
@endsection

@section('body')
    <form action="{{route('reports.store')}}" method="post" class="col-sm-9">
        {{csrf_field()}}

        <div class="form-group {{$errors->first('title', 'has-error')}}">
            <label for="title" class="control-label">{{t('Title')}}</label>
            <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
            {!! $errors->first('title', '<div class="help-block>:message</div>') !!}
        </div>

        <section class="row">
            <article class="form-group col-sm-6 {{$errors->first('core_report_id', 'has-error')}}">
                <label for="core_report_id" class="control-label">{{t('Report Type')}}</label>
                <select name="core_report_id" id="core_report_id" class="form-control">
                    <option class="empty" value="">{{t("[Select Report Type]")}}</option>
                    @foreach($core_reports as $report)
                        <option value="{{$report->id}}" {{$report->id == old('core_report_id')? 'selected' : ''}}>{{$report->name}}</option>
                    @endforeach
                </select>

                {!! $errors->first('core_report_id', '<div class="help-block>:message</div>') !!}
            </article>

            <article class="form-group col-sm-6 {{$errors->first('folder_id', 'has-error')}}">
                <label for="folder_id" class="control-label">{{t('Folder')}}</label>
                <select name="folder_id" id="folder_id" class="form-control">
                    <option class="empty" value="">{{t("[Select Report Type]")}}</option>
                    @foreach($folders as $folder)
                        <option value="{{$folder->id}}" {{$folder->id == old('folder_id')? 'selected' : ''}}>{{$folder->name}}</option>
                    @endforeach
                </select>

                {!! $errors->first('folder_id', '<div class="help-block>:message</div>') !!}

                {{--<a href=""></a>--}}
            </article>
        </section>

        <section>
            <h3 class="section-header">Parameters</h3>

            <section class="row">
                <article class="form-group col-sm-6">
                    <label class="control-label" for="from_date">Due Date From</label>
                    <input type="date" name="parameters[start_date]" id="from_date" class="form-control" value="{{old('parameters.start_date')}}">
                </article>

                <article class="form-group col-sm-6">
                    <label for="to_date">To</label>
                    <input type="date" name="parameters[end_date]" id="to_date" class="form-control" value="{{old('parameters.end_date')}}">
                </article>
            </section>

            <section class="row">
                <article class="multi-select col-sm-6">
                    <label class="control-label" for="">{{t('Technicians')}}</label>
                    <a href="#" class="select-all">{{t('Select All')}}</a> / <a href="#" class="remove-all">{{t('Remove All')}}</a>

                    <ul class="multi-select-container list-unstyled">
                        <li>
                            <input type="search" class="form-control search" placeholder="{{t('Type to search')}}">
                        </li>
                        @foreach($technicians as $technician)
                            <li class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="parameters[technician][{{$technician->id}}]"
                                           id="technician_{{$technician->id}}]"
                                           value="{{$technician->id}}"
                                            {{old("parameters.technician.{$technician->id}")? 'checked' : '' }}>
                                    <span class="checkbox-label">{{$technician->name}}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </article>

                <article class="multi-select col-sm-6">
                    <label class="control-label">{{t('Categories')}}</label>
                    <a href="#" class="select-all">{{t('Select All')}}</a> / <a href="#" class="remove-all">{{t('Remove All')}}</a>

                    <ul class="multi-select-container list-unstyled">
                        <li>
                            <input type="search" class="form-control search" placeholder="{{t('Type to search')}}">
                        </li>
                        @foreach($categories as $category)
                            <li class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="parameters[category][{{$category->id}}]"
                                           id="category_{{$category->id}}]"
                                           value="{{$category->id}}"
                                            {{old("parameters.category.{$category->id}")? 'checked' : '' }}>

                                    <span class="checkbox-label">{{$category->name}}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </article>
            </section>

        </section>

        <div class="form-group">
            <button class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
            {{--<button>Preview</button>--}}
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        window.jQuery(function($) {

            $('.multi-select').on('click', '.select-all', e => {
                e.preventDefault();
                $(e.target).closest('.multi-select').find('input').prop('checked', 'checked');
            }).on('click', '.remove-all', e => {
                e.preventDefault();
                $(e.target).closest('.multi-select').find('input').prop('checked', false);
            }).on('keyup', '.search', e => {
                const $self = $(e.target);
                const term = $self.val().toLowerCase();
                if (term) {
                    $self.closest('.multi-select-container').find('.checkbox-label').each((idx, item) => {
                        const val = $(item).text().toLowerCase();

                        if (val.indexOf(term) >= 0) {
                            $(item).closest('li').show();
                        } else {
                            $(item).closest('li').hide();
                        }
                    });
                } else {
                    $self.closest('.multi-select-container').find('.checkbox').show();
                }

            });
        });
    </script>
@endsection