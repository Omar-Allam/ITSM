{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group form-group-sm {{$errors->has('subject')? 'has-error' : ''}}">
                    {{ Form::label('subject', 'Subject', ['class' => 'control-label']) }}
                    {{ Form::text('subject', null, ['class' => 'form-control']) }}
                    @if ($errors->has('subject'))
                        <div class="error-message">{{$errors->first('subject')}}</div>
                    @endif
                </div>

                <div class="form-group form-group-sm {{$errors->has('description')? 'has-error' : ''}}">
                    {{ Form::label('description', 'Description', ['class' => 'control-label']) }}
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                    @if ($errors->has('description'))
                        <div class="error-message">{{$errors->first('description')}}</div>
                    @endif
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group form-group-sm {{$errors->has('category')? 'has-error' : ''}}">
                    {{ Form::label('category', 'Category', ['class' => 'control-label']) }}
                    {{ Form::select('category', App\Category::selection('Select Category'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('category'))
                        <div class="error-message">{{$errors->first('category')}}</div>
                    @endif
                </div>
                <div class="form-group form-group-sm {{$errors->has('subcategory')? 'has-error' : ''}}">
                    {{ Form::label('subcategory', 'Subcategory', ['class' => 'control-label']) }}
                    {{ Form::select('subcategory', ['Select Subcategory'], null, ['class' => 'form-control', 'disabled' => true, 'v-model' => 'subcategory', 'v-if' => 'subcategories.length']) }}
                    @if ($errors->has('subcategory'))
                        <div class="error-message">{{$errors->first('subcategory')}}</div>
                    @endif
                </div>
                <div class="form-group form-group-sm {{$errors->has('item')? 'has-error' : ''}}">
                    {{ Form::label('item', 'Item', ['class' => 'control-label']) }}
                    {{ Form::select('item', ['Select Item'], null, ['class' => 'form-control', 'disabled' => true, 'v-model' => 'item', 'v-if' => 'items.length']) }}
                    @if ($errors->has('item'))
                        <div class="error-message">{{$errors->first('item')}}</div>
                    @endif
                </div>
            </div>
        </div>


        <hr class="form-divider">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group form-group-sm {{$errors->has('urgency')? 'has-error' : ''}}">
                    {{ Form::label('urgency', 'Urgency', ['class' => 'control-label']) }}
                    {{ Form::select('urgency', App\Urgency::selection('Select Urgency'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('urgency'))
                        <div class="error-message">{{$errors->first('urgency')}}</div>
                    @endif
                </div>

                <div class="form-group form-group-sm {{$errors->has('impact')? 'has-error' : ''}}">
                    {{ Form::label('impact', 'Impact', ['class' => 'control-label']) }}
                    {{ Form::select('impact', App\Impact::selection('Select Impact'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('impact'))
                        <div class="error-message">{{$errors->first('impact')}}</div>
                    @endif
                </div>
                <div class="form-group form-group-sm {{$errors->has('priority')? 'has-error' : ''}}">
                    {{ Form::label('priority', 'Priority', ['class' => 'control-label']) }}
                    {{ Form::select('priority', App\Priority::selection('Select Priority'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('priority'))
                        <div class="error-message">{{$errors->first('priority')}}</div>
                    @endif
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group form-group-sm {{$errors->has('group')? 'has-error' : ''}}">
                    {{ Form::label('group', 'Group', ['class' => 'control-label']) }}
                    {{ Form::select('group', App\Group::support()->selection('Select Group'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('group'))
                        <div class="error-message">{{$errors->first('group')}}</div>
                    @endif
                </div>

                <div class="form-group form-group-sm {{$errors->has('technician_id')? 'has-error' : ''}}">
                    {{ Form::label('technician_id', 'Technician', ['class' => 'control-label']) }}
                    {{ Form::select('technician_id', App\User::technicians()->selection('Select Technician'), null, ['class' => 'form-control']) }}
                    @if ($errors->has('technician_id'))
                        <div class="error-message">{{$errors->first('technician')}}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
        </div>
    </div>
</div>

<script src="{{asset('/js/request-form')}}"></script>
