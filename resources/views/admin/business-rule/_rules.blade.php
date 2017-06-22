<div class="panel panel-sm panel-warning" id="Rules">
    <div class="panel-heading clearfix">
        <h4 class="panel-title pull-left">Actions</h4>
    </div>


    <business-rules :rules="{{json_encode(Form::getValueAttribute('rules'))}}"></business-rules>

    @if ($errors->has('rules'))
        <div class="panel-body">
            <div class="error-message">{{$errors->first('rules')}}</div>
        </div>
    @endif
</div>
