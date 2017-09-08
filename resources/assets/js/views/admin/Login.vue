<template>
    <el-form :model="ruleForm2" :rules="rules2" ref="ruleForm2" label-position="left" label-width="0px" class="demo-ruleForm login-container">
        <h3 class="title">系统登录</h3>
        <el-form-item prop="email">
            <el-input type="email" v-model="ruleForm2.email" auto-complete="off" placeholder="邮箱账号"></el-input>
        </el-form-item>
        <el-form-item prop="password">
            <el-input type="password" v-model="ruleForm2.password" auto-complete="off" placeholder="密码"></el-input>
        </el-form-item>
        <el-checkbox v-model="checked" checked class="remember">记住密码</el-checkbox>
        <el-form-item style="width:100%;">
            <el-button type="primary" style="width:100%;" @click.native.prevent="handleSubmit2" :loading="logining">登录</el-button>
            <!--<el-button @click.native.prevent="handleReset2">重置</el-button>-->
        </el-form-item>
    </el-form>
</template>

<script>
    import { requestLogin } from '../../api/api';
    //import NProgress from 'nprogress'
    export default {
        data() {
            return {
                logining: false,
                ruleForm2: {
                    email: 'fengyan@mail.com',
                    password: '123456'
                },
                rules2: {
                    email: [
                        { required: true, message: '请输入登录邮箱账号', trigger: 'blur' },
                        //{ validator: validaePass }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' },
                        //{ validator: validaePass2 }
                    ]
                },
                checked: true
            };
        },
        methods: {
            handleReset2() {
                this.$refs.ruleForm2.resetFields();
            },
            handleSubmit2(ev) {
                var _this = this;
                this.$refs.ruleForm2.validate((valid) => {
                    if (valid) {
                        //_this.$router.replace('/table');
                        this.logining = true;
                        //NProgress.start();
                        var loginParams = { email: this.ruleForm2.email, password: this.ruleForm2.password };
                        requestLogin(loginParams).then(result => {
                            this.logining = false;
                            //NProgress.done();
                            let { code, msg,  data } = result;
                            if (code !== 0) {
                                this.$message({
                                    message: msg,
                                    type: 'error'
                                });
                            } else {
                                sessionStorage.setItem('user', JSON.stringify(data.userInfo));
                                this.$router.push({ path: '/main' });
                            }
                        });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        }
    }

</script>
