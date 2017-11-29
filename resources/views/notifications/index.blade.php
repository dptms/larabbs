@extends('layouts.app')

@section('title','我的通知')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="text-center">
                        <span class="glyphicon glyphicon-bell"></span> 我的通知
                    </h3>
                    <hr>

                    @if($notifications->count())
                        @foreach($notifications as $notification)
                            @include('notifications.types._'.snake_case(class_basename($notification->type)))
                        @endforeach
                        {!! $notifications->render() !!}
                    @else
                        <div class="emptmm-block">
                            没有新的消息通知！
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop