<template>
    <section>
        <!--工具条-->
         <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.name" placeholder="姓名"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getPageLists(true)">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleAdd" v-if="authorizatioList['admin-users-add']">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>

        <!--列表-->
        <el-table :data="lists" highlight-current-row v-loading="listLoading" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" label="" width="60">
            </el-table-column>
            <el-table-column prop="id" label="编号" sortable>
            </el-table-column>
            <el-table-column prop="name" label="姓名"  sortable>
            </el-table-column>
            <el-table-column prop="email" label="邮箱"  sortable>
            </el-table-column>
            <el-table-column prop="created_at" label="创建时间"  sortable>
            </el-table-column>
            <el-table-column prop="updated_at" label="更新时间"  sortable>
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template slot-scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)" v-if="authorizatioList['admin-users-edit']">编辑</el-button>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)" v-if="authorizatioList['admin-users-remove']">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!--工具条-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0" v-if="authorizatioList['admin-users-remove']">批量删除</el-button>
            <el-pagination layout="total, prev, pager, next" @current-change="handleCurrentChange" :page-size="pageSize" :total="total" style="float:right;">
            </el-pagination>
        </el-col>

        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="80px" :rules="addFormRules" ref="addForm">
                <el-form-item label="姓名" prop="name">
                    <el-input type="text" v-model="addForm.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                    <el-input type="email" v-model="addForm.email" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="email">
                    <el-input type="password" v-model="addForm.password" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="重复密码" prop="email">
                    <el-input type="password" v-model="addForm.rePassword" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="用户角色" prop="role">
                    <el-checkbox-group
                            v-model="roleAdd"
                            :min="1"
                            :max="2">
                        <el-checkbox v-for="(item, id) in roleAddList" :label="item.id" :key="item.id" :checked="item.check">{{item.name}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="addFormVisible = false; addRole = [];">取消</el-button>
                <el-button type="primary" @click.native="addSubmit" :loading="addLoading">提交</el-button>
            </div>
        </el-dialog>

        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="姓名" prop="name">
                    <el-input type="text" v-model="editForm.name" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="邮箱" prop="email">
                    <el-input type="email" v-model="editForm.email" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="用户角色" prop="role">
                    <el-checkbox-group
                            v-model="roleEdit"
                            :min="1"
                            :max="2">
                        <el-checkbox v-for="(item, id) in roleEditList" :label="item.id" :key="item.id" :checked="item.check">{{item.name}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false; editRole = [];">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>

    </section>
</template>

<script>
    import util from '../../../common/js/util'
    //import NProgress from 'nprogress'
    import { getUserListPage, removeUser, editUser, addUser, getRoleListByUserId } from '../../../api/api';

    export default {
        data() {
            return {

                //  搜索字段
                filters: {
                    id: '',
                    name: '',
                    email: ''
                },

                //  分页属性
                pageSize: 20,
                lists: [],
                total: 0,
                page: 1,

                listLoading: false,
                sels: [],//列表选中列


                //  编辑界面    弹框展示
                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                    name: [
                        { required: true, message: '请输入姓名', trigger: 'blur' }
                    ]
                },
                editForm: {
                    id: 0,
                    name: '',
                    email: ''
                },

                //  新增界面    弹框展示
                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                addFormRules: {
                    name: [
                        { required: true, message: '请输入姓名', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' }
                    ],
                    rePassword: [
                        { required: true, message: '请输入重复密码', trigger: 'blur' }
                    ]
                },
                addForm: {
                    name: '',
                    email: '',
                    password: '',
                    rePassword: ''
                },

                //  角色列表
                roleAdd: [],
                roleEdit: [],
                roleAddList: [],
                roleEditList: []
            }
        },
        methods: {
            //  分页事件
            handleCurrentChange(val) {
                this.page = val;
                this.getPageLists(true);
            },

            //  获取用户列表
            getPageLists(isNotice) {
                let params = {
                    page: this.page,
                    pageSize: this.pageSize,
                    filters: this.filters
                };
                this.listLoading = true;
                //NProgress.start();
                getUserListPage(params).then((result) => {
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
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
                this.getRoleList(row.id);
            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            //NProgress.start();
                            let params = Object.assign({}, this.editForm);
                            params.role = this.roleEdit;
                            params.allRole = this.roleEditList;
                            editUser(params).then((result) => {
                                this.editLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: result.data.msg,
                                    type: result.data.type
                                });

                                if (result.data.code == 0) {
                                    this.$refs['editForm'].resetFields();
                                    this.editFormVisible = false;
                                    this.getPageLists();
                                    this.roleEditList = [];
                                    this.roleEdit = [];

                                }

                            });
                        });
                    }
                });
            },

            //显示新增界面
            handleAdd: function () {
                this.addFormVisible = true;
                this.addForm = {
                    name: '',
                    email: '',
                    password: '',
                    rePassword: ''
                };
            },
            //新增
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            //NProgress.start();
                            let params = Object.assign({}, this.addForm);
                            params.role = this.addRole;
                            params.allRole = this.roleAddList;
                            addUser(params).then((result) => {
                                this.addLoading = false;
                                //NProgress.done();

                                this.$message({
                                    message: result.data.msg,
                                    type: result.data.type
                                });
                                if (result.data.code == 0) {
                                    this.$refs['addForm'].resetFields();
                                    this.getPageLists();
                                    this.addRole = [];
                                    this.roleAddList = false;
                                }
                            });
                        });
                    }
                });
            },

            //删除
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let params = { ids: row.id };
                    removeUser(params).then((result) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: result.data.msg,
                            type: result.data.type
                        });
                        if (result.data.code == 0) {
                            this.getPageLists();
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
                    removeUser(params).then((result) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: result.data.msg,
                            type: result.data.type
                        });
                        if (result.data.code == 0) {
                            this.getPageLists();
                        }
                    });
                }).catch(() => {

                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },
            //  获取角色列表
            getRoleList: function (userId) {
//                var that = this;
                getRoleListByUserId({userId: userId}).then((result) => {
//                    that.roleList = result.data;
                    if (userId == 0) {
                        this.roleAddList = result.data;
                    } else  {
                        this.roleEditList = result.data;
                    }
                    console.log(result);
                });
            },
        },

        props: ['authorizatioList'],
        mounted() {
            this.getPageLists(true);

            //  获取角色列表
            this.getRoleList(0);

            /**
             * 单个按钮权限验证
             * props: ['authorizatioList'],
             * authorizatioList 接收父组建属性 , v-if="authorizatioList['menu-add']" 判断按钮权限
             */
            this.$emit('refreshbizlines', ['admin-users-add','admin-users-edit','admin-users-remove']);
        }
    }

</script>