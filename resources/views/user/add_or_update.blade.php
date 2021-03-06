@extends('layouts.app')

@section('title', '会员管理')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <li navValue="nav_2"><a href="#">商户/会员管理</a></li>
    <li navValue="nav_2_2"><a href="#">商户/会员管理</a></li>
@endsection

@section('body')
    <div class="col-md-12">

        <!--错误输出-->
        <div class="form-group">
            <div class="alert alert-danger fade in @if(!count($errors) > 0) hidden @endif" id="alert_error">
                <a href="#" class="close" data-dismiss="alert">×</a>
                <span>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </span>
            </div>
        </div>

        <section class="panel">
            <header class="panel-heading">
                职员资料管理
            </header>
            <div class="panel-body">
                <form id="form" class="form-horizontal adminex-form" enctype="multipart/form-data" method="post" action="{{ $url }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 col-sm-2 control-label">登录账号</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="name" placeholder="填写登录账号" name="name" value="{{ $old_input['name'] }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 col-sm-2 control-label">密码</label>
                        <div class="col-sm-3">
                            {{--避免自动填充--}}
                            <input type="password" id="old_password" name="password" class="hidden" disabled>
                            {{--有输入时才填入name--}}
                            <input type="password" class="form-control" id="password" autoComplete="off" placeholder="更新时放空则不做修改">
                        </div>
                    </div>
                    <div class="form-group">
                        <div  class="col-sm-2 col-sm-2 control-label">
                            <button class="btn btn-success" type="submit"><i class="fa fa-cloud-upload"></i> 确认提交</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    @parent
    <script>
        $(document).ready(function () {
            $('#password').bind('input propertychange', function() {
                $(this).attr('name', 'password')
            })
        })
    </script>
@endsection
