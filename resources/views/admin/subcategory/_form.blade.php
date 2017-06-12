<div class="row">
    <div class="col-md-6">

        @if (!empty($category_id))
            {{Form::hidden('category_id', $category_id)}}
        @else
            <div class="form-group {{$errors->has('category_id')? 'has-error' : ''}}">
                {{Form::label('category_id', 'Category', ['class' => 'control-label'])}}
                {{Form::select('category_id', App\Category::selection('Select Category'), null, ['class' => 'form-control'])}}
                @if ($errors->has('category_id'))
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
            <input type="checkbox" class="checkbox-tick"
                   id="service_request" name="service_request" @if(isset($subcategory->service_request) && $subcategory->service_request ) checked @endif >
            <label for="service_request">Is a service request ?</label>
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check-circle"></i> Submit</button>
        </div>
    </div>
</div>
