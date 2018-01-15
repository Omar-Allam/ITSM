@if ($ticket->replies->count() || $ticket->approvals->count())
    <section class="replies">

        <div class="form-group clearfix">
            <a href="#ReplyForm" class="btn btn-primary pull-right"><i class="fa fa-commenting"></i> {{t('Add reply')}}
            </a>
        </div>

        <div class="conversation-replies">
            @foreach($ticket->replies()->latest()->get() as $reply)
                <div class="panel panel-sm panel-{{$reply->class}}">
                    <div class="panel-heading">
                        <h5 class="panel-title"><a href="#reply{{$reply->id}}" data-toggle="collapse">{{t('By')}}
                                : {{$reply->user->name}} On {{$reply->created_at->format('d/m/Y H:i A')}}</a></h5>
                    </div>
                    <div class="panel-body collapse" id="reply{{$reply->id}}">
                        <div class="reply">
                            {!! tidy_repair_string($reply->content, [], 'utf8') !!}
                        </div>
                        <br>
                        <span class="label label-default">Status: {{t($reply->status->name)}}</span>
                        @if($reply->attachments->count())
                            <br><br>
                            <p><strong>Attachments</strong></p>
                            @foreach($reply->attachments as $attachment)
                                <ul class="list-unstyled">
                                    <li><a href="{{$attachment->url}}" target="_blank" >{{$attachment->display_name}}</a>
                                    </li>
                                </ul>
                            @endforeach
                        @endif
                    </div>
                </div>


            @endforeach
        </div>

        @can('show_approvals',$ticket)
            @include('ticket.partials._ticket_approvals')
        @endcan

    </section>
@endif

<div id="ReplyForm">
    {{Form::open(['route' => ['ticket.reply', $ticket], 'files' => true])}}
    {{csrf_field()}}

    <div class="form-group {{$errors->has('reply.content')? 'has-errors' : ''}}">
        {{Form::label('reply[content]', t('Description'), ['class' => 'control-label'])}}
        {{Form::textarea('reply[content]', null, ['class' => 'form-control richeditor', 'rows' => 5])}}
        @if ($errors->has('reply.content'))
            <div class="error-message">{{$errors->first('reply.content')}}</div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group {{$errors->has('reply.status_id')? 'has-error' : ''}}">
                {{Form::label('reply[status_id]', t('Change status from') .' ( '. t($ticket->status->name) . ' ) '.t('to'), ['class' => 'control-label'])}}
                {{Form::select('reply[status_id]', t(App\Status::reply($ticket)->selection('Select Status')), 5, ['class' => 'form-control'])}}
                @if ($errors->has('reply.status_id'))
                    <div class="error-message">{{$errors->first('status_id')}}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <table class="listing-table table-condensed">
                <thead>
                <tr>
                    <th>Attachments</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-md-10">
                        <input type="file" class="form-control input-xs" name="attachments[]" multiple>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> {{t('Send')}}</button>
    </div>
    {{Form::close()}}
</div>
