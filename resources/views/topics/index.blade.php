@extends('layouts.app')

@section('title','话题')

@section('content')
    <div class="row">
        {{--话题内容--}}
        <div class="col-md-9 col-lg-9 topic-list">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="active"><a href="#">最后回复</a></li>
                        <li role="presentation"><a href="#">最新发布</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    @include('topics._topic_list')
                </div>
            </div>
        </div>

        {{--边栏导航--}}
        <div class="col-md-3 col-lg-3 sidebar">
            @include('topics._sidebar')
        </div>
    </div>
@stop