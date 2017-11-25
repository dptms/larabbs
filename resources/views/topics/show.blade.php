@extends('layouts.app')

@section('title',$topic->title)
@section('description',$topic->excerpt)

@section('content')

    <div class="container">
        <div class="col-md-3 col-lg-3 hidden-sm hidden-xs author-info">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">作者</div>
                    <hr>
                    <div class="media">
                        <div class="center">
                            <a href="{{route('users.show',$topic->user)}}">
                                <img src="{{$topic->user->avatar}}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 topic-content">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1 class="text-center">{{$topic->title}}</h1>

                    <div class="text-center article-meta">
                        {{$topic->created_at->diffForHumans()}}
                        ·
                        <span class="glyphicon glyphicon-comment"></span>
                        {{$topic->reply_count}}
                    </div>

                    <div class="topic-body">
                        {!! $topic->body !!}
                    </div>

                    @can('update',$topic)
                        <div class="operate">
                            <hr>
                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-default pull-left"
                               role="button">
                                <i class="glyphicon glyphicon-edit"></i> 编辑
                            </a>
                            <form action="{{route('topics.destroy',$topic)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-danger" style="margin-left: 5px">
                                    <i class="glyphicon glyphicon-trash"></i> 删除
                                </button>
                            </form>

                        </div>
                    @endcan
                </div>
            </div>

            <div class="panel panel-default topic-reply">
                <div class="panel-body">
                    @includeWhen(Auth::check(),'topics._reply_box',['topic'=>$topic])
                    @include('topics._reply_list',['replies'=>$topic->replies()->with('user')->recent()->get()])
                </div>
            </div>
        </div>
    </div>

@endsection
