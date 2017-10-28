@extends('layouts.app')

@section('title', '会员管理')

@section('style')
    @parent
@endsection

@section('breadcrumb')
    <li navValue="nav_2"><a href="#">职员管理</a></li>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12">
		<section class="panel">
            <div class="panel-body">
                <form class="form-inline" id="search_form">
                    <div class="form-group">
                        <label class="sr-only" for="search"></label>
                        <input type="text" class="form-control" id="search" name="keyword"
                               value="{{ Request::get('keyword') }}" placeholder="输入账号" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="salesman_search">搜索</button>
                    <button type="button" class="btn btn-success"
                            onclick="location='{{ route('user_add') }}'">
                        添加职员
                    </button>
                </form>
            <header class="panel-heading">
                职员列表
            </header>
            	<table class="table table-striped table-hover">
		            <thead>
		                <tr>
		                    <th>ID</th>
		                    <th>账号</th>
                            <th>修改时间</th>
                            <th>添加时间</th>
							<th>操作</th>
		                </tr>
		            </thead>

		            <tbody id="target">
                        @foreach($lists as $list)
                        <tr>
                            <td>{{ $list['id'] }}</td>
                            <td>{{ $list['name'] }}</td>
                            <td>{{ $list['updated_at'] }}</td>
                            <td>{{ $list['created_at'] }}</td>
                            <td>
                                <button class="btn btn-info" type="button" onclick="location='{{ route('user_update', ['id' => $list['id'] ]) }}'">编辑</button>
                                <button class="btn btn-danger" type="button" onclick="javascript:if(confirm('确实要删除吗?'))location='{{ route('user_destroy', ['id' => $list['id'] ]) }}'">删除</button>
                            </td>
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

                window.location = '{{ route('user_search', ['keyword' => '']) }}/' + stripscript(keyword);

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
@endsection
