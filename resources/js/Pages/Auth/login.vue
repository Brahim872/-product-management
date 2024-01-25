<template>
    <div id="main">
        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user">
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user"
                                                       id="exampleInputEmail" v-model="email"
                                                       aria-describedby="emailHelp"
                                                       placeholder="Enter Email Address...">
                                                <small v-if="errorEmail" class="text-danger" id="errorEmail"> {{errorEmail }}</small>

                                            </div>
                                            <div class="form-group">
                                                <input type="password" v-model="password"
                                                       class="form-control form-control-user"
                                                       id="exampleInputPassword" placeholder="Password">
                                                <small v-if="errorPassword" class="text-danger" id="errorPassword"> {{errorPassword }}</small>

                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <a href="#" @click="Login()" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </a>
                                        </form>
                                        <hr>
                                        <div class="text-center">

                                            <a class="small" href="/auth/forgot-password">Forgot Password?</a>
                                        </div>
                                        <!--                                        <div class="text-center">-->
                                        <!--                                            <a class="small" href="/auth/register">Create an Account!</a>-->
                                        <!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</template>


<script setup>

    import {ref} from 'vue';

    const email = ref('');
    const password = ref('');
    const errors = ref('');
    const errorPassword = ref('');
    const errorEmail = ref('');

    function Login() {
        if (email.value == '' || password.value == '') {
            errorPassword.value = "this field required"
            errorEmail.value = "this field required"
            return false;
        }
        axios.post('/api/login', {

            email: email.value,
            password: password.value,

        }).then((res) => {
            console.log(res.data)
            localStorage.setItem('token', res.data.token)
            localStorage.setItem('user_name', res.data.user.name)
            localStorage.setItem('user_email', res.data.user.email)
             window.location.href = "/";
        }).catch((err) => {
            if (err.response.data.error){
                $.notify(err.response.data.error,'error')
            }
            const error = err.response.data.errors;
            errorPassword.value = error.password?error.password[0]:'';
            errorEmail.value = error.email?error.email[0]:'';
        })
    }

</script>


