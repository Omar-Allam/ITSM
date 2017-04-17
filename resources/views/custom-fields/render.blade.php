@if ($category)
    @foreach($category->custom_fields as $field)
        @include('custom-fields.' . $field['type'], compact('field'))
    @endforeach
@endif

@if ($subcategory)
    @foreach($subcategory->custom_fields as $field)
        @include('custom-fields.' . $field['type'], compact('field'))
    @endforeach
@endif

@if ($item)
    @foreach($item->custom_fields as $field)
        @include('custom-fields.' . $field['type'], compact('field'))
    @endforeach
@endif