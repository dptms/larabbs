@include('common.error')
<div class="reply-box">
    <form action="{{route('replies.store')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="topic_id" value="{{$topic->id}}">
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" placeholder="分享你的想法"></textarea>
        </div>
        <button class="btn btn-primary">发表</button>
    </form>
</div>
<hr>