{{ csrf_field() }}
<div id="TicketForm">
    @if (!isset($ticket) && Auth::user()->isSupport())
        <div class="form-group form-group-sm {{$errors->has('requester_id')? 'has-error' : ''}}">
            {{ Form::label('requester_id', t('Requester'), ['class' => 'control-label']) }}
            {{ Form::select('requester_id', App\User::requesterList()->prepend('Create for me', ''), null, ['class' => 'form-control select2']) }}
            {!! $errors->first('requester_id', '<div class="error-message">:message</div>') !!}
        </div>
    @endif

    <div class="form-group form-group-sm {{$errors->has('subject')? 'has-error' : ''}}">
        {{ Form::label('subject', t('Subject'), ['class' => 'control-label']) }}
        {{ Form::text('subject', null, ['class' => 'form-control']) }}
        @if ($errors->has('subject'))
            <div class="error-message">{{$errors->first('subject')}}</div>
        @endif
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="form-group form-group-sm {{$errors->has('description')? 'has-error' : ''}}">
                {{ Form::label('description', t('Description'), ['class' => 'control-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control richeditor']) }}
                @if ($errors->has('description'))
                    <div class="error-message">{{$errors->first('description')}}</div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-9">
                    <attachments limit="5"></attachments>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group form-group-sm {{$errors->has('category_id')? 'has-error' : ''}}">
                {{ Form::label('category_id', t('Category'), ['class' => 'control-label']) }}
                {{ Form::select('category_id', App\Category::selection('Select Category'), null, ['class' => 'form-control', 'v-model' => 'category']) }}
                @if ($errors->has('category_id'))
                    <div class="error-message">{{$errors->first('category_id')}}</div>
                @endif
            </div>

            <div class="form-group form-group-sm {{$errors->has('subcategory')? 'has-error' : ''}}">
                {{ Form::label('subcategory_id', t('Subcategory'), ['class' => 'control-label']) }}

                <select class="form-control" name="subcategory_id" id="subcategory_id" v-model="subcategory">
                    <option value="">Select Subcategory</option>
                    <option v-for="(name, id) in subcategories" :value="id">@{{name}}</option>
                </select>
                @if ($errors->has('subcategory_id'))
                    <div class="error-message">{{$errors->first('subcategory_id')}}</div>
                @endif
            </div>

            <div class="form-group form-group-sm {{$errors->has('item_id')? 'has-error' : ''}}">
                {{ Form::label('item_id', t('Item'), ['class' => 'control-label']) }}
                <select class="form-control" name="item_id" id="item_id" v-model="item">
                    <option value="">Select Item</option>
                    <option v-for="(name, id) in items" :value="id" v-text="name"></option>
                </select>
                @if ($errors->has('item_id'))
                    <div class="error-message">{{$errors->first('item_id')}}</div>
                @endif
            </div>

            <div id="CustomFields">
                @include('custom-fields.render', [
                    'category' => App\Category::find(old('category_id')),
                    'subcategory' => App\Category::find(old('subcategory_id')),
                    'item' => App\Item::find(old('item_id'))
                ])
            </div>
        </div>
    </div>


    <hr class="form-divider">

    <div class="row">
        {{--<div class="col-sm-6">


            <div class="form-group form-group-sm {{$errors->has('impact_id')? 'has-error' : ''}}">
                {{ Form::label('impact_id', 'Impact', ['class' => 'control-label']) }}
                {{ Form::select('impact_id', App\Impact::selection('Select Impact'), null, ['class' => 'form-control']) }}
                @if ($errors->has('impact_id'))
                    <div class="error-message">{{$errors->first('impact_id')}}</div>
                @endif
            </div>
            <div class="form-group form-group-sm {{$errors->has('priority_id')? 'has-error' : ''}}">
                {{ Form::label('priority_id', 'Priority', ['class' => 'control-label']) }}
                {{ Form::select('priority_id', App\Priority::selection('Select Priority'), null, ['class' => 'form-control']) }}
                @if ($errors->has('priority_id'))
                    <div class="error-message">{{$errors->first('priority_id')}}</div>
                @endif
            </div>
        </div>--}}

        @if (Auth::user()->isSupport())
            <div class="col-sm-6">
                <div class="form-group form-group-sm {{$errors->has('group_id')? 'has-error' : ''}}">
                    {{ Form::label('group_id', t('Group'), ['class' => 'control-label']) }}
                    {{ Form::select('group_id', App\Group::support()->selection('Select Group'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('group_id'))
                        <div class="error-message">{{$errors->first('group')}}</div>
                    @endif
                </div>

                <div class="form-group form-group-sm {{$errors->has('technician_id')? 'has-error' : ''}}">
                    {{ Form::label('technician_id', t('Technician'), ['class' => 'control-label']) }}
                    {{ Form::select('technician_id', App\User::technicians()->selection('Select Technician'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('technician_id'))
                        <div class="error-message">{{$errors->first('technician_id')}}</div>
                    @endif
                </div>

                <div class="form-group form-group-sm {{$errors->has('urgency_id')? 'has-error' : ''}}">
                    {{ Form::label('urgency_id', t('Urgency'), ['class' => 'control-label']) }}
                    {{ Form::select('urgency_id', App\Urgency::selection('Select Urgency'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('urgency_id'))
                        <div class="error-message">{{$errors->first('urgency_id')}}</div>
                    @endif
                </div>
            </div>
        @endif
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
    <script src="{{asset('/js/ticket-form.js')}}"></script>
    <script src="{{asset('/js/tinymce/tinymce.min.js')}}"></script>
@append