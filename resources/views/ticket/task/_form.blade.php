{{ csrf_field() }}
<div id="TicketForm">
    <div class="form-group form-group-sm {{$errors->has('subject')? 'has-error' : ''}}">
        {{ Form::label('subject', t('Subject'), ['class' => 'control-label']) }}
        {{ Form::text('subject', null, ['class' => 'form-control']) }}
        @if ($errors->has('subject'))
            <div class="error-message">{{$errors->first('subject')}}</div>
        @endif
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-group-sm {{$errors->has('description')? 'has-error' : ''}}">
                {{ Form::label('description', t('Description'), ['class' => 'control-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control richeditor']) }}
                @if ($errors->has('description'))
                    <div class="error-message">{{$errors->first('description')}}</div>
                @endif
            </div>
        </div>

            <div class="col-md-6">
                <div class="form-group {{$errors->first('group_id', 'has-error')}}">
                    {{Form::label('group_id', t('Group'), ['class' => 'control-label'])}}
                    {{Form::select('group_id', App\Group::selection('Select Group'),null, ['class' => 'form-control','v-model'=>'group'])}}
                    {!! $errors->first('group_id', '<div class="help-block">:message</div>') !!}
                </div>

                <div class="form-group ">
                    {{ Form::label('technician_id', t('Technician'), ['class' => 'control-label']) }}
                    <select  class="form-control" name="technician_id" id="technician_id" v-model="technician_id">
                        <option value="">Select Technician</option>
                        <option v-for="tech in technicians" :value="tech.id"> @{{tech.name}}</option>
                    </select>
                    @if ($errors->has('technician_id'))
                        <div class="error-message">{{$errors->first('technician_id')}}</div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{$errors->has('category_id')? 'has-error' : ''}}">
                    {{ Form::label('category_id', t('Category'), ['class' => 'control-label']) }}
                    {{ Form::select('category_id', App\Category::selection('Select Category'),null, ['class' => 'form-control',  'v-model' => 'category']) }}
                    @if ($errors->has('category_id'))
                        <div class="error-message">{{$errors->first('category_id')}}</div>
                    @endif
                </div>

                <div class="form-group {{$errors->first('subcategory', 'has-error')}}">
                    {{ Form::label('subcategory_id', t('Subcategory'), ['class' => 'control-label']) }}

                    <select class="form-control" name="subcategory_id" id="subcategory_id" v-model="subcategory">
                        <option value="">Select Subcategory</option>
                        <option v-for="subcat in subcategories" :value="subcat.id" v-text="subcat.name"></option>
                    </select>

                    @if ($errors->has('subcategory_id'))
                        <div class="error-message">{{$errors->first('subcategory_id')}}</div>
                    @endif
                </div>

                <div class="form-group  {{$errors->has('item_id')? 'has-error' : ''}}">
                    {{ Form::label('item_id', t('Item'), ['class' => 'control-label']) }}
                    <select class="form-control" name="item_id" id="item_id" v-model="item">
                        <option value="">Select Item</option>
                        <option v-for="(name, id) in items" :value="id" v-text="name"></option>
                    </select>
                    @if ($errors->has('item_id'))
                        <div class="error-message">{{$errors->first('item_id')}}</div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-success"><i class="fa fa-check"></i> {{t('Submit')}}</button>
    </div>
</div>

@section('javascript')
    <script>
        var category = '{{Form::getValueAttribute('category_id')}}';
        var subcategory = '{{Form::getValueAttribute('subcategory_id')}}';
        var item = '{{Form::getValueAttribute('item_id')}}';
    </script>
    <script src="{{asset('/js/tinymce/tinymce.min.js')}}"></script>
@append