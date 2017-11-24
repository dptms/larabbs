@if(count($replies))
    <ul class="list-group">
        @foreach($replies as $reply)
            <li class="list-group-item">
                <a href="{{$reply->topic->links(['#reply'.$reply->id])}}">
                    {{$reply->topic->title}}
                </a>
                <div class="reply-content">
                    {{$reply->content}}
                </div>
                <div class="meta">
                    <span class="glyphicon glyphicon-time"></span>
                    <span> 回复于 </span>
                    <span>{{$reply->created_at->diffForHumans()}}</span>
                </div>
            </li>
        @endforeach
    </ul>
    {!! $replies->appends(Request::except('page'))->render() !!}
@else
    <div class="empty-block">
        暂无数据~
    </div>
@endif