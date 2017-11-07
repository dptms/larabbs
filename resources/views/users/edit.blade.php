@extends('layouts.app')

@section('title','编辑资料')

@section('content')
<div class="row">
    <div class="panel panel-default col-md-offset-1 col-md-10">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-edit"></i> 编辑个人资料</h4>
        </div>

        @include('common.error')

        <div class="panel-body">
            <form action="{{route('users.update',$user)}}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                {{method_field('PUT')}}
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name-field">用户名</label>
                    <input class="form-control" type="text" id="name-field" name="name" value="{{old('name',$user->name)}}">
                </div>

                <div class="form-group">
                    <label for="email-field">邮箱</label>
                    <input class="form-control" type="email" id="email-field" name="email" value="{{old('email',$user->email)}}">
                </div>

                <div class="form-group">
                    <label for="avatar-field">头像</label>
                    <input class="form-control" type="file" id="avatar-field" name="avatar">
                </div>

                <div class="form-group">
                    <label for="introduction-field">个人简介</label>
                    <textarea name="introduction" id="introduction-field" class="form-control" rows="4">{{old('introduction',$user->introduction)}}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">提交</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection