import axios from 'axios';

// let base = 'http://admin.ladmin.me';
let base = '';
export const getMenuList = params => { return axios.get(`${base}/basic/getMenuList`, {params: params}).then(res => res.data); };

export const getMenusListForVueRouter = params => { return axios.get(`${base}/basic/getMenusListForVueRouter`, {params: params}).then(res => res.data); };

export const getMenuPermissionList = params => { return axios.get(`${base}/basic/getMenuPermissionList`, {params: params}).then(res => res.data); };

export const getMenuPermissionListByRoleId = params => { return axios.get(`${base}/basic/getMenuPermissionListByRoleId`, {params: params}).then(res => res.data); };

//  获取用户编号获取权限列表 编号为空则获取全部角色
export const getRoleListByUserId = params => { return axios.get(`${base}/basic/getRoleListByUserId`, {params: params}).then(res => res.data); };

//  检测权限
export const checkRolePermission = params => { return axios.post(`${base}/basic/checkRolePermission`, {params: params}).then(res => res.data); };

//  登录接口
export const requestLogin = params => { return axios.post(`${base}/login`, params).then(res => res.data); };

export const requestLogout = params => { return axios.get(`${base}/logout`, {params: params}).then(res => res.data); };
/**
 * 后台用户管理请求接口
 * @param params
 * @returns {AxiosPromise}
 */
export const getUserListPage = params => { return axios.get(`${base}/user`, { params: params }); };

export const removeUser = params => { return axios.post(`${base}/user/remove`, { params: params }); };

// export const batchRemoveUser = params => { return axios.post(`${base}/user/remove`, { params: params }); };

export const editUser = params => { return axios.post(`${base}/user/edit`, { params: params }); };

export const addUser = params => { return axios.post(`${base}/user/add`, { params: params }); };

/**
 * 菜单管理请求接口
 */
export const getMenuListPage = params => { return axios.get(`${base}/menu`, {params: params})};

export const removeMenu = params => { return axios.post(`${base}/menu/remove`, {params: params})};

export const editMenu = params => { return axios.post(`${base}/menu/edit`, {params: params})};

export const addMenu = params => { return axios.post(`${base}/menu/add`, {params: params})};

/**
 * 角色管理请求接口
 */
export const getRoleListPage = params => { return axios.get(`${base}/role`, {params: params})};

export const removeRole = params => { return axios.post(`${base}/role/remove`, {params: params})};

export const editRole = params => { return axios.post(`${base}/role/edit`, {params: params})};

export const addRole = params => { return axios.post(`${base}/role/add`, {params: params})};