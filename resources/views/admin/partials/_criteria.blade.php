<div class="panel panel-sm panel-info" id="Criteria">
    <div class="panel-heading clearfix">
        <h4 class="panel-title">Criteria</h4>
        <div class="pull-right panel-form">
            <label for="criteria_type_and">
                {{Form::radio('criteria.type', 'and', null, ['id' => 'criteria_type_and'])}} Match all rules
            </label>
            <label for="criteria_type_or">
                {{Form::radio('criteria.type', 'or', null, ['id' => 'criteria_type_or'])}} Match any of rules
            </label>
        </div>
    </div>
    <criteria :criterions="{{json_encode(Form::getValueAttribute('criterions'))}}"></criteria>
    @if ($errors->has('criteria'))
        <div class="panel-body">
            <div class="error-message">{{$errors->first('criteria')}}</div>
        </div>
    @endif
</div>
