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