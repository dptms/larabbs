<div class="media">
    <div class="media-left avatar">
        <a href="{{route('users.show',$notification->data['user_id'])}}">
            <img class="media-object img-thumbnail" src="{{$notification->data['user_avatar']}}" alt="{{$notification->data['user_name']}}" style="width: 48px;height: 48px;">
        </a>
    </div>
    <div class="media-body infos">
        <div class="media-heading">
            <a href="{{route('users.show',$notification->data['user_id'])}}">
                {{$notification->data['user_name']}}
            </a>
            评论了
            <a href="{{$notification->data['topic_link']}}">
                {{$notification->data['topic_title']}}
            </a>
            <span class="pull-right">
                {{$notification->created_at->diffForHumans()}}
            </span>
        </div>
        <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
        </div>
    </div>
</div>