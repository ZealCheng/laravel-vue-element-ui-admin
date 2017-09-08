<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.name" placeholder="菜单名称"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getPageLists(true)">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleEdit(0, null)" v-if="authorizatioList['admin-roles-add']">新增</el-button>
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
            <el-table-column prop="name" label="角色名称"  sortable>
            </el-table-column>
            <el-table-column prop="display_name" label="显示名称"  sortable>
            </el-table-column>
            <el-table-column prop="description" label="描述"  sortable>
            </el-table-column>
            <el-table-column prop="created_at" label="创建时间"  sortable>
            </el-table-column>
            <el-table-column prop="updated_at" label="更新时间"  sortable>
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)" v-if="authorizatioList['admin-roles-edit']">编辑</el-button>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)" v-if="authorizatioList['admin-roles-remove']">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!--工具条-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0" v-if="authorizatioList['admin-roles-remove']">批量删除</el-button>
            <el-pagination layout="total, prev, pager, next" @current-change="handleCurrentChange" :page-size="pageSize" :total="total" style="float:right;">
            </el-pagination>
        </el-col>

        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="角色名称" prop="name">
                    <el-input type="text" v-model="editForm.name" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="显示名称" prop="display_name">
                    <el-input type="text" v-model="editForm.display_name" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="角色描述" prop="description">
                    <el-input type="text" v-model="editForm.description" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="选者权限" prop="permission">
                    <el-tree
                            :data="permissionList"
                            show-checkbox
                            default-expand-all
                            node-key="name"
                            ref="tree"
                            highlight-current
                            :check-strictly="true"
                            :props="defaultProps">
                    </el-tree>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editClose">取消</el-button>
                <el-button type="primary" @click.native="editSubmit()" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
    </section>
</template>

<script>
    import util from '../../../common/js/util'
    //import NProgress from 'nprogress'
    import { getRoleListPage, removeRole, editRole, addRole, getMenuPermissionList, getMenuPermissionListByRoleId } from '../../../api/api';

    export default {
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
                        { required: true, message: '请输入角色名称', trigger: 'blur' }
                    ]
                },
                editForm: {
                    id: 0,
                    name: '',
                    display_name: 1,
                    description: ''
                },

                permissionList: [],
                defaultProps: {
                    children: 'children',
                    label: 'display_name'
                }
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
                getRoleListPage(params).then((result) => {
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
                //  初始化权限列表
                this.getPermissionList();
                if (row) {
                    this.editFormVisible = true;
                    this.editForm = Object.assign({}, row);
                    //  绑定权限节点已选中
                    getMenuPermissionListByRoleId({roleId: row.id}).then((result) => {
                        this.$refs.tree.setCheckedNodes(result.data);
                    });
                } else {
                    this.editFormVisible = true;
                    this.editForm = {
                        id: 0,
                        name: '',
                        display_name: '',
                        description: ''
                    };
                }
            },
            editClose: function () {
                this.editFormVisible = false;
                this.$refs.tree.setCheckedKeys([]);
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

                            params.permissionList = this.$refs.tree.getCheckedKeys();

                            if (params.id != 0) {
                                obj = editRole(params);
                            } else  {
                                obj = addRole(params);
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
                                    this.getPageLists();
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
                    removeRole(params).then((result) => {
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
                    removeRole(params).then((result) => {
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
            //  获取权限列表
            getPermissionList: function () {
                getMenuPermissionList().then((result) => {
                    this.permissionList = result.data;
                });
            },
        },
        props: ['authorizatioList'],
        mounted() {
            this.getPageLists(true);

            //  初始化权限列表
            this.getPermissionList();

            /**
             * 单个按钮权限验证
             * props: ['permissionList'],
             * permissionList 接收父组建属性 , v-if="authorizatioList['menu-add']" 判断按钮权限
             */
            this.$emit('refreshbizlines', ['admin-roles-add','admin-roles-edit','admin-roles-remove']);
        }
    }

</script>