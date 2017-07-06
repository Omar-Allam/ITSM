{{Form::model($ticket, ['route' => ['ticket.reassign', $ticket], 'class' => 'modal fade', 'id' => 'AssignForm'])}}
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{t('Assign Ticket')}}</h4>
        </div>

        <div class="modal-body" id="TicketForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{$errors->first('group_id', 'has-error')}}">
                        {{Form::label('group_id', t('Group'), ['class' => 'control-label'])}}
                        {{Form::select('group_id', App\Group::selection('Select Group'), null, ['class' => 'form-control','v-model'=>'group'])}}
                        {!! $errors->first('group_id', '<div class="help-block">:message</div>') !!}
                    </div>

                    <div class="form-group   {{$errors->has('technician')? 'has-error' : ''}}">
                        {{ Form::label('technician_id', t('Technician'), ['class' => 'control-label']) }}
                        <select class="form-control" name="technician_id" id="technician_id"  v-model="technicians">
                            <option value="">Select Technician</option>
                            <option v-for="(name, id) in technicians" :value="id"> @{{name}}</option>
                        </select>
                        @if ($errors->has('technician_id'))
                            <div class="error-message">{{$errors->first('technician_id')}}</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group   {{$errors->has('category_id')? 'has-error' : ''}}">
                        {{ Form::label('category_id', t('Category'), ['class' => 'control-label']) }}
                        {{ Form::select('category_id', App\Category::selection('Select Category'),null, ['class' => 'form-control',  'v-model' => 'category']) }}
                        @if ($errors->has('category_id'))
                            <div class="error-message">{{$errors->first('category_id')}}</div>
                        @endif
                    </div>

                    <div class="form-group   {{$errors->has('subcategory')? 'has-error' : ''}}">
                        {{ Form::label('subcategory_id', t('Subcategory'), ['class' => 'control-label']) }}

                        <select class="form-control" name="subcategory_id" id="subcategory_id" v-model="subcategory">
                            <option value="">Select Subcategory</option>
                            <option v-for="(name, id) in subcategories" :value="id"> @{{name}}</option>
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

                    <div id="CustomFields">
                        @include('custom-fields.render', [
                            'category' => App\Category::find(old('category_id')),
                            'subcategory' => App\Category::find(old('subcategory_id')),
                            'item' => App\Item::find(old('item_id'))
                        ])
                    </div>

                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-mail-forward"></i> {{t('Assign')}}</button>
        </div>
    </div>
</div>
{{Form::close()}}

@section('javascript')
    <script>
        var category = '{{Form::getValueAttribute('category_id') ?? $ticket->category_id}}';
        var subcategory = '{{Form::getValueAttribute('subcategory_id') ?? $ticket->subcategory_id}}';
        var item = '{{Form::getValueAttribute('item_id') ?? $ticket->item_id}}';
        var group = '{{Form::getValueAttribute('group_id') ?? $ticket->group_id}}'
    </script>
    <script src="{{asset('/js/ticket-form.js')}}"></script>
    <script src="{{asset('/js/tinymce/tinymce.min.js')}}"></script>
@append