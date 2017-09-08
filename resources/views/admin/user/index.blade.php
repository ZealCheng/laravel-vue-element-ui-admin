@extends('layouts.admin')

@section('content')
    <div class="row" id="content-list">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Bordered Table</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th style="width: 10px"><input type="checkbox" name="ids" value="0"></th>
                            <th>管理员编号</th>
                            <th>管理员姓名</th>
                            <th>管理员邮箱</th>
                            <th>创建时间</th>
                            <th style="width: 120px;">操作</th>
                        </tr>
                        <tr v-for="(item, key) in list">
                            <td><input type="checkbox" name="ids" v-bind:value="item.id"></td>
                            <td>@{{ item.id }}</td>
                            <td>@{{ item.name }}</td>
                            <td>@{{ item.email }}</td>
                            <td>@{{ item.created_at }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm">编辑</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix" v-if="list!=null">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li>
                            <a href="javascript:void(0)">第<span v-text="params.currentPage"></span>页/共
                                <span v-text="params.lastPage"></span>页 共计
                                <span v-text="params.total"></span>条</a>
                        </li>
                        <li><a href="javascript:void(0)" v-on:click="params.currentPage = 1, pageClick()" >首页</a></li>
                        <li v-if="params.currentPage > 1"><a href="javascript:void(0)" v-on:click="params.currentPage--, pageClick()" >«</a></li>
                        <li v-if="params.currentPage == 1"><a href="javascript:void(0)" class="btn-default disabled">«</a></li>

                        <li v-for="index in getPagesList"  v-bind:class="{ 'active': params.currentPage == index}">
                            <a href="javascript:void(0)" v-on:click="btnPageClick(index)">@{{ index }}</a>
                        </li>

                        <li v-if="params.currentPage != params.lastPage"><a href="javascript:void(0)" v-on:click="params.currentPage++, pageClick()">»</a></li>
                        <li v-if="params.currentPage == params.lastPage"><a href="javascript:void(0)" class="btn-default disabled">»</a></li>
                        <li><a href="javascript:void(0)" v-on:click="params.currentPage = params.lastPage, pageClick()" >尾页</a></li>
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        var vm = new Vue({
            el: '#content-list',
            data: {
                params: {
                    currentPage: "{!! $data->currentPage() !!}",
                    pageLimit: "{!! $data->perPage() !!}",
                    total: "{!! $data->total() !!}",
                    lastPage: "{!! $data->lastPage() !!}",
                    nextPageUrl: "{!! $data->nextPageUrl() !!}",
                    prevPageUrl: "{!! $data->previousPageUrl() !!}",
                },
                list: eval({!! json_encode($data->items()) !!}),
                title : "hello world ！"
            },
            watch: {
                //监听参数变化
                'params.currentPage': function () {
                    params = {page:this.params.currentPage};
                    this.getList("{{ get_admin_url('user') }}", params)
                },
            },
            methods: {
                //  页码点击事件
                btnPageClick: function(page){
                    if(page != this.params.currentPage){
                        this.params.currentPage = page
                    }
                },
                //
                pageClick: function(){
                    console.log('现在在'+this.params.currentPage+'页');
                },

                //  获取分页数据列表
                getList: function (url, params) {
                    var _self = this;
                    $.ajax({
                        type: 'get',
                        url: url,
                        data: params,
                        success: function(result) {
                            result = eval("(" + result +")");
                            _self.list = result.data;
                        }
                    });
                },
            },

            computed: {
                getPagesList: function(){
                    var left = 1;
                    var right = this.params.lastPage;
                    var pageList = [];
                    if(this.params.lastPage>= 5){
                        if(this.params.currentPage > 3 && this.params.currentPage < this.params.lastPage-2){
                            left = this.params.currentPage - 2
                            right = this.params.currentPage + 2
                        }else{
                            if(this.params.currentPage <= 3){
                                left = 1
                                right = 5
                            }else{
                                right = this.params.lastPage
                                left = this.params.lastPage -4
                            }
                        }
                    }
                    while (left <= right){
                        pageList.push(left)
                        left++
                    }
                    return pageList
                }
            }

        });
    </script>
@endsection