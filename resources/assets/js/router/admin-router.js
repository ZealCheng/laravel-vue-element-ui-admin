import NotFound from '../views/admin/404.vue'
import Home from '../views/admin/Home.vue'
import Login from '../views/admin/Login.vue'
let AdminRouter = [
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
        name: '控制台',
        iconCls: 'el-icon-message', //图标样式class
    },
    {
        path: '*',
        hidden: true,
        redirect: { path: '/404' }
    }
];

export default AdminRouter;