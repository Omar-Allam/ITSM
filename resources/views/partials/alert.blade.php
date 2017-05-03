<div id="flash-alert" class="col-sm-8 col-sm-offset-2">
    <div class="alert alert-{{$type}}">
        @if($type == 'success')
            <i class="fa fa-check"></i>
        @elseif($type == 'warning')
            <i class="fa fa-exclamation-triangle"></i>
        @elseif($type == 'info')
            <i class="fa fa-info-circle"></i>
        @else
            <i class="fa fa-exclamation-circle"></i>
        @endif

        {{$message}}
    </div>
</div>