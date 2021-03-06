@extends('layouts.app')

@section('title', '添加/管理记录')

@section('style')
    @parent
    <link href="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.css" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('/style/js/flatpickr.js') }}"></script>
@endsection

@section('breadcrumb')
    <li navValue="nav_0"><a href="#">添加/管理记录</a></li>
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
                添加/管理记录
            </header>
            <div class="panel-body">
                <form id="form" class="form-horizontal adminex-form" method="post" action="{{ $url }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="train" class="col-sm-2 col-sm-2 control-label">车次</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="train" name="train" value="{{ $old_input['train'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="track" class="col-sm-2 col-sm-2 control-label">股道</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="track" name="track" value="{{ $old_input['track'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="arrival_time" class="col-sm-2 col-sm-2 control-label">到达时间</label>
                        <div class="col-sm-3">
                            <input type="hidden" name="arrival_time" value="date">
                            <input type="text" class="form-control" id="arrival_time" name="arrival_time"  value="{{$old_input['arrival_time']}}" placeholder="选择时间.." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="locomotive" class="col-sm-2 col-sm-2 control-label">机车</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="locomotive" name="locomotive" value="{{ $old_input['locomotive'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="departure_time" class="col-sm-2 col-sm-2 control-label">出发时间</label>
                        <div class="col-sm-3">
                            <input type="hidden" name="departure_time" value="date">
                            <input type="text" class="form-control" id="departure_time" name="departure_time"  value="{{$old_input['departure_time']}}" placeholder="选择时间.." required>
                        </div>
                    </div>

                    {{--预留一--}}
                    <div class="form-group">
                        <label for="reserve_1" class="col-sm-2 col-sm-2 control-label">预留字段1</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="reserve_1" name="reserve_1" value="{{ $old_input['reserve_1'] }}">
                        </div>
                    </div>

                    {{--预留二--}}
                    <div class="form-group">
                        <label for="reserve_2" class="col-sm-2 col-sm-2 control-label">预留字段2</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="reserve_2" name="reserve_2" value="{{ $old_input['reserve_2'] }}">
                        </div>
                    </div>

                    {{--预留三--}}
                    <div class="form-group">
                        <label for="reserve_3" class="col-sm-2 col-sm-2 control-label">预留字段3</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="reserve_3" name="reserve_3" value="{{ $old_input['reserve_3'] }}">
                        </div>
                    </div>

                    {{--预留四--}}
                    <div class="form-group">
                        <label for="reserve_4" class="col-sm-2 col-sm-2 control-label">预留字段4</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="reserve_4" name="reserve_4" value="{{ $old_input['reserve_4'] }}">
                        </div>
                    </div>

                    {{--预留五--}}
                    <div class="form-group">
                        <label for="reserve_5" class="col-sm-2 col-sm-2 control-label">预留字段5</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="reserve_5" name="reserve_5" value="{{ $old_input['reserve_5'] }}">
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
        window.onload = function () {
            flatpickr("#arrival_time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });

            flatpickr("#departure_time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });
        }
    </script>
@endsection
