@extends('layouts.app')

@section('title',isset($category)?$category->name:'话题列表')

@section('content')
    <div class="row">
        {{--话题内容--}}
        <div class="col-md-9 col-lg-9 topic-list">
            @if(isset($category))
                {{--话题头--}}
                <div class="alert alert-info" role="alert">
                    <strong>{{$category->name}} ：</strong>{{$category->description}}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="{{active_class(!if_query('order','recent'))}}"><a
                                    href="{{Request::url()}}?order=default">最后回复</a></li>
                        <li role="presentation" class="{{active_class(if_query('order','recent'))}}"><a
                                    href="{{Request::url()}}?order=recent">最新发布</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    {{--话题列表--}}
                    @include('topics._topic_list')
                </div>
                <div class="panel-footer page-panel">
                    {!! $topics->render() !!}
                </div>
            </div>
        </div>

        {{--边栏导航--}}
        <div class="col-md-3 col-lg-3 sidebar">
            @include('topics._sidebar')
        </div>
    </div>
@stop