{{--$paginator Must be an instance of \Illuminate\Contracts\Pagination\LengthAwarePaginator--}}
@if ($items->lastPage() > 1)
    <?php
    $mod = 8;
    /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $items */
    $page = $items->currentPage();

    if ($items->lastPage() < $mod) {
        $start = 1;
        $last = $items->lastPage();
    } elseif ($page < $mod) {
        $start = 1;
        $last = $mod;
    } elseif ($page > $items->lastPage() - $mod) {
        $start = $items->lastPage() - $mod + 1;
        $last = $items->lastPage();
    } else {
        $start = $page - $mod / 2 + 1;
        $last = $page + $mod / 2;
    }
    ?>

    <div class="text-center">
        <ul class="pagination">
            @if ($page > 1)
                <li>
                    <a href="?page={{$page - 1}}"><i class="fa fa-chevron-left fa-fw"></i></a>
                </li>
            @endif
            @for ($i = $start; $i <= $last; ++$i)
                <li @if($page == $i)class="active"@endif>
                    <a href="?page={{$i}}">{{$i}}</a>
                </li>
            @endfor
            @if ($page < $items->lastPage())
                <li>
                    <a href="?page={{$page + 1}}"><i class="fa fa-chevron-right fa-fw"></i></a>
                </li>
            @endif
        </ul>
    </div>
@endif