import NotFound from '../views/admin/404.vue';
import Home from '../views/admin/Home.vue';
import Login from '../views/admin/Login.vue';
import Main from '../views/admin/Index.vue';    //  主页
import AdminUser from '../views/admin/basic/AdminUser.vue';
import Menu from  '../views/admin/basic/Menu.vue';
import Role from '../views/admin/basic/Role.vue';
let AdminRouter = {
    'admin': [
        {
            path: '/404',
            component: NotFound,
            name: '',
            hidden: true
        },
        {
            path: '/login',
            component: Login,
            name: '登录',
            hidden: true
        },
        {
            path: '/',
            component: Home,
            name: '',
            iconCls: 'fa fa-laptop', //图标样式class
            leaf: true,//只有一个节点
            children: [
                { path: '/main', component: Main, name: '控制台' }
            ]
        },
        {
            path: '/',
            component: Home,
            name: '系统管理',
            iconCls: 'fa el-icon-setting', //图标样式class
            children: [
                { path: '/user', component: AdminUser, name: '后台用户管理', iconCls: 'el-icon-message'},
                { path: '/menu', component: Menu, name: '后台菜单管理', iconCls: 'el-icon-menu'},
                { path: '/role', component: Role, name: '后台角色管理', iconCls: 'el-icon-menu'},
            ]
        },
    ]
};

export default AdminRouter.admin;