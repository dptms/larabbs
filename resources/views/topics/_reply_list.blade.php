<div class="reply-list">
    @foreach($replies as $reply)
        <div class="media" id="reply{{$reply->id}}">
            <div class="media-left">
                <a href="{{route('users.show',$reply->user)}}">
                    <img class="media-object img-thumbnail" src="{{$reply->user->avatar}}" alt="{{$reply->user->name}}"
                         style="width: 48px;height: 48px;">
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <a href="{{route('users.show',$reply->user)}}">
                        {{$reply->user->name}}
                    </a>
                    <span> · </span>
                    <span class="meta" title="{{$reply->created_at}}">{{$reply->created_at->diffForHumans()}}</span>
                    {{--删除按钮--}}
                    @can('destroy',$reply)
                        <span class="pull-right">
                        <form action="{{route('replies.destroy',$reply)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <button class="btn btn-xs" type="submit">
                                <span class="glyphicon glyphicon-trash "></span>
                            </button>
                        </form>
                    </span>
                    @endcan
                </div>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>
            </div>
        </div>
        <hr>
    @endforeach
</div>