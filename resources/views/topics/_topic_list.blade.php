@if(count($topics))
    <ul class="media-list">
        @foreach($topics as $topic)
            <li class="media">
                <div class="media-left">
                    <a href="{{route('users.show',$topic->user)}}">
                        <img src="{{$topic->user->avatar}}" alt="" class="media-object img-thumbnail img-responsive"
                             width="52" height="52">
                    </a>
                </div>

                <div class="media-body">
                    <div class="media-heading">
                        <a href="{{$topic->links()}}">
                            {{$topic->title}}
                        </a>
                        <a href="#" class="pull-right">
                            <span class="badge" aria-hidden="true"> {{$topic->reply_count}} </span>
                        </a>
                    </div>

                    <div class="media-body meta">
                        <a href="{{route('categories.show',$topic->category)}}" title="{{$topic->category->name}}">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            &nbsp;{{$topic->category->name}}
                        </a>
                        <span> · </span>
                        <a href="{{route('users.show',$topic->user)}}" title="{{$topic->user->name}}">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            &nbsp;{{$topic->user->name}}
                        </a>
                        <span> · </span>
                        <a href="#">
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            &nbsp;{{$topic->created_at->diffForHumans()}}
                        </a>
                    </div>
                </div>

                @if(!$loop->last)
                    <hr>
                @endif
            </li>
        @endforeach
    </ul>
@else
    <div class="empty-block">暂无数据</div>
@endif