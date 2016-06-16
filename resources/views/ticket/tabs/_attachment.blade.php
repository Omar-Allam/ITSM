<table class="listing-table">
    <thead>
    <tr>
        <th>File</th>
        <th>Uploaded By</th>
        <th>At</th>
        <th>&nbsp;</th>
    </tr>
    </thead>

    @foreach($ticket->files as $file)
    <tr>
        <td>{{link_to($file->path, $file->display_name, ['target' => '_blank'])}}</td>
        <td>{{$file->uploaded_by}}</td>
        <td>{{$file->created_at->format('d/m/Y H:i')}}</td>
        <th><a href="{{url($file->path)}}" class="btn btn-xs btn-info"><i class="fa fa-download"></i></a></th>
    </tr>
    @endforeach
</table>

