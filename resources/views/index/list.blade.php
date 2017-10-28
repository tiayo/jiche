@extends('layouts.app')

@section('title', '首页')

@section('style')
    @parent
    <link href="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.css" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('/style/js/flatpickr.js') }}"></script>
@endsection

@section('breadcrumb')

@endsection

@section('body')
<div class="row">
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
            <div class="panel-body">
                <form class="form-inline" role="form" action="{{ route('search') }}" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" id="start_time" name="start_time"
                               placeholder="起始日期">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="end_time" name="end_time"
                               placeholder="结束日期">
                    </div>
                    <button type="submit" class="btn btn-primary">查询</button>

                    <button type="button" class="btn btn-success"
                            onclick="location='{{ route('add') }}'">
                        添加记录
                    </button>
                </form>
            <header class="panel-heading">
                记录列表
            </header>
            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>车次</th>
		                    <th>股道</th>
		                    <th>到达时间</th>
                            <th>机车</th>
                            <th>出发时间</th>
                            {{--<th>预留字段1</th>--}}
                            {{--<th>预留字段2</th>--}}
                            {{--<th>预留字段3</th>--}}
                            {{--<th>预留字段4</th>--}}
                            {{--<th>预留字段5</th>--}}
                            <th>修改时间</th>
                            @if (can('admin'))
							    <th>操作</th>
                            @endif
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($lists as $list)
                        <tr>
                            <td>{{ $list['id'] }}</td>
                            <td>{{ $list['train'] }}</td>
                            <td>{{ $list['track'] }}</td>
                            <td>{{ $list['arrival_time'] }}</td>
                            <td>{{ $list['locomotive'] }}</td>
                            <td>{{ $list['departure_time'] }}</td>
                            {{--<td>{{ $list['reserve_1'] }}</td>--}}
                            {{--<td>{{ $list['reserve_2'] }}</td>--}}
                            {{--<td>{{ $list['reserve_3'] }}</td>--}}
                            {{--<td>{{ $list['reserve_4'] }}</td>--}}
                            {{--<td>{{ $list['reserve_5'] }}</td>--}}
                            <td>{{ $list['updated_at'] }}</td>
                            @if (can('admin'))
                                <td>
                                    <button class="btn btn-info" type="button" onclick="location='{{ route('update', ['id' => $list['id'] ]) }}'">编辑</button>
                                    <button class="btn btn-danger" type="button" onclick="javascript:if(confirm('确实要删除吗?'))location='{{ route('destroy', ['id' => $list['id'] ]) }}'">删除</button>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
		        </table>

               {{ $lists->links() }}
            </div>
    	</section>
    </div>
</div>
@endsection

@section('script')
    @parent
    {{--转换搜索链接--}}
    <script type="text/javascript">
        $(document).ready(function () {

            $('#search_form').submit(function () {

                var keyword = $('#search').val();

                if (stripscript(keyword) == '') {
                    $('#search').val('');
                    return false;
                }

                window.location = '{{ route('search', ['keyword' => '']) }}/' + stripscript(keyword);

                return false;
            });

        });

        function stripscript(s)
        {
            var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");
            var rs = "";
            for (var i = 0; i < s.length; i++) {
                rs = rs+s.substr(i, 1).replace(pattern, '');
            }
            return rs;
        }
    </script>
    <script>
        window.onload = function () {
            flatpickr("#start_time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });

            flatpickr("#end_time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });
        }
    </script>
@endsection
