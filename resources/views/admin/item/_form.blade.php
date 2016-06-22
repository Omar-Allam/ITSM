<div class="row">
    <div class="col-md-6">

        @if (!empty($subcategory_id))
            {{Form::hidden('subcategory_id', $subcategory_id)}}
        @else
            <div class="form-group {{$errors->has('subcategory_id')? 'has-error' : ''}}">
                {{Form::label('subcategory_id', 'Subcategory', ['class' => 'control-label'])}}
                {{Form::select('subcategory_id', App\Subcategory::selection('Select Subcategory'), null, ['class' => 'form-control'])}}
                @if ($errors->has('subcategory_id'))
                    <div class="error-message">{{$errors->first('category_id')}}</div>
                @endif
            </div>
        @endif

        <div class="form-group {{$errors->has('name')? 'has-error' : ''}}">
            {{Form::label('name', 'Name', ['class' => 'control-label'])}}
            {{Form::text('name', null, ['class' => 'form-control'])}}
            @if ($errors->has('name'))
                <div class="error-message">{{$errors->first('name')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('description')? 'has-error' : ''}}">
            {{Form::label('description', 'Description', ['class' => 'control-label'])}}
            {{Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5])}}
            @if ($errors->has('description'))
                <div class="error-message">{{$errors->first('description')}}</div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check-circle"></i> Submit</button>
        </div>
    </div>
</div>
