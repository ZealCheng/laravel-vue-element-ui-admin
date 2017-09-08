<template>
    <el-row class="container">
        <el-col :span="24" class="header">
            <el-col :span="10" class="logo" :class="isCollapse?'logo-collapse-width':'logo-width'">
                {{isCollapse?'':sysName}}
            </el-col>
            <el-col :span="4">
                <div class="tools" @click.prevent="collapse">
                    <i class="fa fa-align-justify"></i>
                </div>
            </el-col>


            <el-col :span="4" class="userinfo">
                <el-dropdown trigger="hover">
                    <span class="el-dropdown-link userinfo-inner"><img :src="this.sysUserAvatar" /> {{sysUserName}}</span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>我的消息</el-dropdown-item>
                        <el-dropdown-item>设置</el-dropdown-item>
                        <el-dropdown-item divided @click.native="logout">退出登录</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </el-col>
        </el-col>
        <el-col :span="24" class="main">
                <!--导航菜单-->
            <el-menu :default-active="$route.path" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose" :collapse="isCollapse" :router="true" :unique-opened="true">
                <el-submenu :index="item.path" v-for="(item, key) in menuList" :key="item.id" v-if="item.children">
                    <template slot="title">
                        <i :class="item.iconCls"></i>
                        <span slot="title">{{item.name}}</span>
                    </template>
                    <el-menu-item-group v-if="item.children" v-for="(children, groupName) in item.children" :key="groupName">
                        <span slot="title">{{groupName}}</span>
                        <el-menu-item :index="child.path" v-for="(child, k, i) in children" :key="child.id">{{child.name}}</el-menu-item>
                    </el-menu-item-group>
                </el-submenu>

                <el-menu-item :index="item.path" v-else="item.children">
                    <i :class="item.iconCls"></i>
                    <span slot="title">{{item.name}}</span>
                </el-menu-item>
            </el-menu>
            <section class="content-container">
                <div class="grid-content bg-purple-light">
                    <el-col :span="24" class="breadcrumb-container">
                        <strong class="title">{{$route.name}}</strong>
                        <el-breadcrumb separator="/" class="breadcrumb-inner">
                            <el-breadcrumb-item v-for="item in $route.matched" :key="item.path">
                                {{ item.name }}
                            </el-breadcrumb-item>
                        </el-breadcrumb>
                    </el-col>
                    <el-col :span="24" class="content-wrapper">
                        <transition name="fade" mode="out-in">
                            <router-view v-on:refreshbizlines="checkRolePermissionByUser" :authorizatioList="authorizatioList"></router-view>
                        </transition>
                    </el-col>
                </div>
            </section>
        </el-col>
    </el-row>
</template>
<script>
    import {getMenuList, requestLogout, checkRolePermission} from '../../api/api';
    export default {
        data() {
            return {
                abc:'test',
                isCollapse: true,

                sysName:'Laravel-Vue-Admin',
                sysUserName: '',
                sysUserAvatar: '',

                form: {
                    name: '',
                    region: '',
                    date1: '',
                    date2: '',
                    delivery: false,
                    type: [],
                    resource: '',
                    desc: ''
                },

                menuList: [],

                authorizatioList: {}
            }
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            },
            //退出登录
            logout: function () {
                var _this = this;
                this.$confirm('确认退出吗?', '提示', {
                    //type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    requestLogout({}).then((result) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: result.msg,
                            type: result.type
                        });
                        if (result.code == 0) {
                            sessionStorage.removeItem('user');
                            _this.$router.push('/login');
                        }
                    });
                }).catch(() => {

                });
            },
            //折叠导航栏
            collapse:function(){
                this.isCollapse=!this.isCollapse;
            },
            showMenu(i,status){
                this.$refs.menuCollapsed.getElementsByClassName('submenu-hook-'+i)[0].style.display=status?'block':'none';
            },

            //  检测单个或多个按钮的权限验证
            checkRolePermissionByUser (permissionList) {
                var params = {permissionList: permissionList};
                checkRolePermission(params).then((result) => {
                    this.authorizatioList = result.data;
                });
            }
        },
        mounted() {
            var user = sessionStorage.getItem('user');
            if (user) {
                user = JSON.parse(user);
                this.sysUserName = user.name || '';
                this.sysUserAvatar = user.avatar || 'https://raw.githubusercontent.com/taylorchen709/markdown-images/master/vueadmin/user.png';
            }

            //  获取menuList
            getMenuList({}).then((result) => {
                this.menuList = result.data;
            });
        }
    }

</script>