<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item><span >{{ menuInfo.title }}</span></el-form-item>
                <el-form-item>
                    <el-input v-model="filters.name" placeholder="菜单名称"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getPageLists(true, menuInfo)">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleEdit(0, null)" v-if="authorizatioList['admin-menus-add']">新增</el-button>
                    <el-button type="primary" @click="getPageLists(true, { id: menuInfo.pid, pid: 0 })" v-if="menuInfo.id">返回上一级</el-button>
                </el-form-item>
            </el-form>
        </el-col>

        <!--列表-->
        <el-table :data="lists" highlight-current-row v-loading="listLoading" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" label="#" sortable>
            </el-table-column>
            <el-table-column prop="id" label="编号" sortable>
            </el-table-column>
            <el-table-column prop="name" label="菜单名称" sortable>
            </el-table-column>
            <el-table-column prop="menu_type" label="菜单类型"  sortable :formatter="formatMenuType" >
            </el-table-column>
            <el-table-column prop="hidden" label="是否隐藏"  sortable :formatter="formatHidden">
            </el-table-column>
            <el-table-column prop="component" label="组建名称"  sortable>
            </el-table-column>
            <el-table-column prop="icon" label="图标样式"  sortable>
            </el-table-column>
            <el-table-column prop="url" label="菜单地址"  sortable>
            </el-table-column>
            <el-table-column prop="slug" label="对应权限"  sortable>
            </el-table-column>
            <el-table-column label="操作" width="240">
                <template slot-scope="scope">
                    <el-button size="small" @click="getPageLists(true, scope.row)">查看子菜单</el-button>
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)" v-if="authorizatioList['admin-menus-edit']">编辑</el-button>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)" v-if="authorizatioList['admin-menus-remove']">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!--工具条-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0" v-if="authorizatioList['admin-menus-remove']">批量删除</el-button>
            <el-pagination layout="total, prev, pager, next" @current-change="handleCurrentChange" :page-size="pageSize" :total="total" style="float:right;">
            </el-pagination>
        </el-col>

        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="菜单名称" prop="name">
                    <el-input type="text" v-model="editForm.name" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="菜单类型" prop="menu_type">
                    <el-radio-group v-model="editForm.menu_type">
                        <el-radio class="radio" :label="1">导航菜单</el-radio>
                        <el-radio class="radio" :label="2">普通按钮</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="是否隐藏" prop="hidden">
                    <!--<el-radio class="radio" v-model="editForm.hidden" label="1">是</el-radio>
                    <el-radio class="radio" v-model="editForm.hidden" label="0">否</el-radio>-->
                    <el-switch v-model="editForm.hidden" on-color="#13ce66" off-color="#ff4949" on-text="是" off-text="否"></el-switch>
                </el-form-item>


                <el-form-item label="组建名称" prop="component">
                    <el-input type="text" v-model="editForm.component" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="图标样式" prop="icon">
                    <el-input type="text" v-model="editForm.icon" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="菜单地址" prop="url">
                    <el-input type="text" v-model="editForm.url" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="权限对应名" prop="slug">
                    <el-input type="text" v-model="editForm.slug" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="排序" prop="sort">
                    <el-input type="text" v-model="editForm.sort" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="菜单描述" prop="description">
                    <el-input type="text" v-model="editForm.description" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit()" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
    </section>
</template>

<script>
    import util from '../../../common/js/util'
    //import NProgress from 'nprogress'
    import { getMenuListPage, removeMenu, editMenu, addMenu } from '../../../api/api';
    import ElButton from "../../../../../node_modules/element-ui/packages/button/src/button.vue";

    export default {
        components: {ElButton},

        data() {
            return {
                //  搜索字段
                filters: {
                    name: ''
                },

                //  分页属性
                pageSize: 20,
                lists: [],
                total: 0,
                page: 1,

                //  加载状态
                listLoading: false,
                sels: [],//列表选中列


                //  编辑界面    弹框展示
                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                    name: [
                        { required: true, message: '请输入菜单名称', trigger: 'blur' }
                    ],
                    /*component: [
                        { required: true, message: '请输入主件名称', trigger: 'blur' }
                    ],
                    url: [
                        { required: true, message: '请输入菜单地址', trigger: 'blur' }
                    ]*/
                },
                editForm: {
                    id: 0,
                    name: '',
                    menu_type: 1,
                    hidden: 0,
                    component: '',
                    icon: '',
                    url: '/',
                    slug: '',
                    sort: 0,
                    description: ''
                },

                //  当前父级菜单信息
                menuInfo: {
                    id: 0,
                    pid: 0,
                    title: []
                }
            }
        },
        methods: {
            formatHidden: function (row, column) {
                return row.hidden == 1 ? '是' : row.hidden == 0 ? '否' : '否';
            },
            formatMenuType: function (row, column) {
                return row.menu_type == 1 ? '导航菜单' : row.menu_type == 2 ? '普通按钮' : '未知';
            },
            //  分页事件
            handleCurrentChange(val) {
                this.page = val;
                this.getPageLists(true, this.menuInfo);
            },
            //  获取用户列表
            getPageLists(isNotice, row) {
                var id;
                if (!row.id) {
                    id = 0;
                    this.menuInfo = {
                        id: 0,
                        pid: 0,
                    }
                } else {
                    id = row.id;
                    this.menuInfo = {
                        id: row.id,
                        pid: row.pid,
                    }
                }
                let params = {
                    page: this.page,
                    pageSize: this.pageSize,
                    pid: id,
                    filters: this.filters
                };
                this.listLoading = true;
                //NProgress.start();
                getMenuListPage(params).then((result) => {
                    if (isNotice != 'undefined' && isNotice) {
                        this.$message({
                            message: result.data.msg,
                            type: result.data.type
                        });
                    }

                    if (result.data.code == 0) {
                        let res = result.data;
                        this.total = res.data.total;
                        this.lists = res.data.data;
                        this.page  = res.data.current_page;
                        this.listLoading = false;
                    }
                    //NProgress.done();
                });
            },

            //显示编辑界面
            handleEdit: function (index, row) {

                if (row) {
                    this.editFormVisible = true;
                    this.editForm = Object.assign({}, row);
                } else {
                    this.editFormVisible = true;
                    this.editForm = {
                        id: 0,
                        pid: this.menuInfo.id,
                        name: '',
                        menu_type: 1,
                        hidden: 0,
                        component: '',
                        icon: '',
                        url: '/',
                        slug: '',
                        sort: 0,
                        description: ''
                    };
                }

            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            //NProgress.start();
                            let params = Object.assign({}, this.editForm);
                            let obj;
                            if (params.id != 0) {
                                obj = editMenu(params);
                            } else  {
                                obj = addMenu(params);
                            }
                            obj.then((result) => {
                                this.editLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: result.data.msg,
                                    type: result.data.type
                                });

                                if (result.data.code == 0) {
                                    this.$refs['editForm'].resetFields();
                                    this.editFormVisible = false;
                                    this.getPageLists(false, this.menuInfo);
                                }

                            });
                        });
                    }
                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

            //删除
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let params = { ids: row.id };
                    removeMenu(params).then((result) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: result.data.msg,
                            type: result.data.type
                        });
                        if (result.data.code == 0) {
                            this.getPageLists(false, this.menuInfo);
                        }

                    });
                }).catch(() => {

                });
            },

            //批量删除
            batchRemove: function () {
                var ids = this.sels.map(item => item.id).toString();
                this.$confirm('确认删除选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let params = { ids: ids };
                    removeMenu(params).then((result) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: result.data.msg,
                            type: result.data.type
                        });
                        if (result.data.code == 0) {
                            this.getPageLists(false, this.menuInfo);
                        }
                    });
                }).catch(() => {

                });
            }
        },

        props: ['authorizatioList'],
        mounted() {
            this.getPageLists(true, this.menuInfo);

            /**
             * 单个按钮权限验证
             * props: ['authorizatioList'],
             * authorizatioList 接收父组建属性 , v-if="authorizatioList['menu-add']" 判断按钮权限
             */
            this.$emit('refreshbizlines', ['admin-menus-add','admin-menus-edit','admin-menus-remove']);
        }
    }

</script>