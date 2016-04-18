<div class="row">
    <div class="col-md-6">
        {{csrf_field()}}

        <div class="form-group {{$errors->has('name')? 'has-error' : ''}}">
            {{Form::label('name', 'Name', ['class' => 'control-label'])}}
            {{Form::text('name', null, ['class' => 'form-control'])}}
            @if ($errors->has('name'))
                <div class="error-message">{{$errors->first('name')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('description')? 'has-error' : ''}}">
            {{Form::label('description', 'Description', ['class' => 'control-label'])}}
            {{Form::textarea('description', null, ['class' => 'form-control'])}}
            @if ($errors->has('description'))
                <div class="error-message">{{$errors->first('description')}}</div>
            @endif
        </div>

        <category :items="{{$categories}}" error="{{$errors->first('parent_id')}}"></category>

        <div class="form-group {{$errors->has('parent_id')? 'has-error' : ''}}">
            {{Form::label('parent_id', 'Category', ['class' => 'control-label'])}}
            {{Form::select('parent_id', \App\Category::selection('Select Category'), null, ['class' => 'form-control'])}}
            @if ($errors->has('parent_id'))
                <div class="error-message">{{$errors->first('parent_id')}}</div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check-circle"></i> Submit</button>
        </div>
    </div>
</div>