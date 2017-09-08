import axios from 'axios';

let base = 'http://admin.ladmin.me';

export const requestLogin = params => { return axios.post(`${base}/login`, params).then(res => res.data); };