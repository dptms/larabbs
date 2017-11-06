@extends('layouts.app')

@section('title',$user->name.' 的个人中心')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
            {{--用户个人简介--}}
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div align="center">
                            <img class="thumbnail img-responsive"
                                 src="https://fsdhubcdn.phphub.org/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600">
                        </div>
                        <div class="media-body">
                            <hr>
                            <h4><strong>个人简介</strong></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium ea earum est maiores molestiae nam officiis, quos reprehenderit ullam vitae? Aliquid expedita ipsa quibusdam? Accusantium earum incidunt laborum molestiae nulla.</p>
                            <hr>
                            <h4><strong>注册于</strong></h4>
                            <p>2014-02-03</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            {{--用户标题--}}
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1 class="panel-title" style="font-size: 30px">{{$user->name}} <small>{{$user->email}}</small></h1>
                </div>
            </div>

            <hr>

            {{--发布的内容--}}
            <div class="panel panel-default">
                <div class="panel-body">
                    暂无数据~
                </div>
            </div>
        </div>
    </div>
@stop