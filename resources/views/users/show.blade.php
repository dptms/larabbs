@extends('layouts.app')

@section('title',$user->name.' 的个人中心')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
            {{--用户个人简介--}}
            <div class="panel panel-default user-info">
                <div class="panel-body">
                    <div class="media">
                        <div align="center">
                            <img class="thumbnail img-responsive" src="{{$user->avatar}}">
                        </div>
                        <div class="media-body">
                            <hr>
                            <h4><strong>个人简介</strong></h4>
                            <p>{{$user->introduction}}</p>
                            <hr>
                            <h4><strong>注册于</strong></h4>
                            <p>{{$user->created_at->diffForHumans()}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            {{--用户标题--}}
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1 class="panel-title" style="font-size: 30px">{{$user->name}}
                        <small>{{$user->email}}</small>
                    </h1>
                </div>
            </div>

            <hr>

            {{--发布的内容--}}
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#">Ta 的话题</a></li>
                        <li role="presentation"><a href="#">Ta 的回复</a></li>
                    </ul>
                    @include('users._topics',['topics'=>$user->topics()->recent()->paginate(5)])
                </div>
            </div>
        </div>
    </div>
@stop