<div class="row">
    <div class="col-md-6">
        <div class="form-group {{$errors->has('name')? 'has-error' : ''}}">
            {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
            @if ($errors->has('name'))
            <div class="error-message">{{$errors->first('name')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('email')? 'has-error' : ''}}">
            {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
            {{ Form::email('email', null, ['class' => 'form-control', 'rows' => 3]) }}
            @if ($errors->has('email'))
                <div class="error-message">{{$errors->first('email')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('login')? 'has-error' : ''}}">
            {{ Form::label('login', 'Login name', ['class' => 'control-label']) }}
            {{ Form::text('login', null, ['class' => 'form-control']) }}
            @if ($errors->has('login'))
                <div class="error-message">{{$errors->first('login')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('job')? 'has-error' : ''}}">
            {{ Form::label('job', 'Job Title', ['class' => 'control-label']) }}
            {{ Form::text('job', null, ['class' => 'form-control']) }}
            @if ($errors->has('job'))
                <div class="error-message">{{$errors->first('job')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('business_unit_id')? 'has-error' : ''}}">
            {{ Form::label('business_unit_id', 'Business Unit', ['class' => 'control-label']) }}
            {{ Form::select('business_unit_id', App\BusinessUnit::selection('Select Business Unit'), null, ['class' => 'form-control']) }}
            @if ($errors->has('business_unit_id'))
                <div class="error-message">{{$errors->first('business_unit_id')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('department_id')? 'has-error' : ''}}">
            {{ Form::label('department_id', 'Department', ['class' => 'control-label']) }}
            {{ Form::select('department_id', App\Department::selection('Select Department'), null, ['class' => 'form-control']) }}
            @if ($errors->has('department_id'))
                <div class="error-message">{{$errors->first('department_id')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('location_id')? 'has-error' : ''}}">
            {{ Form::label('location_id', 'Location', ['class' => 'control-label']) }}
            {{ Form::select('location_id', App\Location::selection('Select Location'), null, ['class' => 'form-control']) }}
            @if ($errors->has('location_id'))
                <div class="error-message">{{$errors->first('location_id')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('manager_id')? 'has-error' : ''}}">
            {{ Form::label('manager_id', 'Direct Manager', ['class' => 'control-label']) }}
            {{ Form::select('manager_id', App\User::selection('Select Manager'), null, ['class' => 'form-control']) }}
            @if ($errors->has('manager_id'))
                <div class="error-message">{{$errors->first('manager_id')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('phone')? 'has-error' : ''}}">
            {{ Form::label('phone', 'Phone', ['class' => 'control-label']) }}
            {{ Form::text('phone', null, ['class' => 'form-control']) }}
            @if ($errors->has('phone'))
                <div class="error-message">{{$errors->first('phone')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('mobile1')? 'has-error' : ''}}">
            {{ Form::label('mobile1', 'Mobile #1', ['class' => 'control-label']) }}
            {{ Form::text('mobile1', null, ['class' => 'form-control']) }}
            @if ($errors->has('mobile1'))
                <div class="error-message">{{$errors->first('mobile1')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('mobile2')? 'has-error' : ''}}">
            {{ Form::label('mobile2', 'Mobile #2', ['class' => 'control-label']) }}
            {{ Form::text('mobile2', null, ['class' => 'form-control']) }}
            @if ($errors->has('mobile2'))
                <div class="error-message">{{$errors->first('mobile2')}}</div>
            @endif
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label class="control-label" for="vip">
                    {{Form::hidden('vip', 0)}}
                    {{Form::checkbox('vip', 1, null, ['id' => 'vip'])}}
                    VIP User
                </label>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check-circle"></i> Submit</button>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{$errors->has('password')? 'has-error' : ''}}">
            {{ Form::label('password', 'Password', ['class' => 'control-label']) }}
            {{ Form::password('password', ['class' => 'form-control']) }}
            @if ($errors->has('password'))
                <div class="error-message">{{$errors->first('password')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('password')? 'has-error' : ''}}">
            {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) }}
            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
            @if ($errors->has('password_confirmation'))
                <div class="error-message">{{$errors->first('password_confirmation')}}</div>
            @endif
        </div>
    </div>
</div>
