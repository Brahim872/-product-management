<template>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">


                    <div class="card-body p-0">

                        <!-- Nested Row within Card Body -->
                        <div class="row">

                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">

                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <div class="user" v-if="loading">
                                        <div class="form-group">
                                            Waiting ...
                                        </div>
                                    </div>
                                    <form class="user" v-if="!loading">
                                        <div class="form-group">
                                            <input type="email" v-model="email" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address...">
                                            <small v-if="errorEmail" class="text-danger" id="errorEmail"> {{ errorEmail
                                                }}</small>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" v-model="password"
                                                   class="form-control form-control-user"
                                                   @input="validatePassword"
                                                   id="exampleInputPassword" placeholder="Password">
                                            <small v-if="errorPassword" class="text-danger" id="errorPassword">
                                                {{errorPassword }}</small>

                                        </div>

                                        <div class="form-group">
                                            <input type="password" v-model="confirm_password"
                                                   class="form-control form-control-user"
                                                   @input="validateConfirmPassword"
                                                   id="confirm_password" placeholder="confirm password">
                                            <small v-if="errorPasswordConfirmPassword" class="text-danger"
                                                   id="errorPasswordConfirmPassword"> {{errorPasswordConfirmPassword
                                                }}</small>

                                        </div>

                                        <a href="#" @click="sendEmailReset()"
                                           class="btn btn-primary btn-user btn-block">
                                            confirm
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="/auth/register">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/auth/login">Already have an account? Login!</a>
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
    import {onMounted, ref} from 'vue'

    const email = ref('');
    const password = ref('');
    const token = ref('');
    const confirm_password = ref('');
    const send = ref(false);
    const loading = ref(false);
    const errorEmail = ref('');
    const errorPassword = ref('');
    const errorPasswordConfirmPassword = ref('');


    const validatePassword = () => {
        if (password.value.length < 8) {
            errorPassword.value = 'Password must be at least 6 characters long.';
            return false;
        } else {
            errorPassword.value = '';
        }
    };
    const validateConfirmPassword = () => {
        if (password.value !== confirm_password.value) {
            errorPasswordConfirmPassword.value = 'The password field confirmation does not match.';
            return false;
        } else {
            errorPasswordConfirmPassword.value = '';
        }
    };


    const sendEmailReset = () => {
        console.log(errorPassword.value==='' || errorPasswordConfirmPassword.value==='')
        if (errorPassword.value==='' || errorPasswordConfirmPassword.value==='') {


            loading.value = true;
            axios.post('/api/reset-password', {
                email: email.value,
                password: password.value,
                token: token.value,
                password_confirmation: confirm_password.value,
            }).then((res) => {
                if (res.data.status === 200) {
                    loading.value = false;
                    send.value = true;
                    $.notify(res.data.message, 'success');
                    window.location.href = "/auth/login"
                }
            })
                .catch((err) => {
                    loading.value = false;
                    send.value = false;
                    errorEmail.value = err.response.data.errors.email

                })
        }
    }
    onMounted(() => {
        const urlParams = new URLSearchParams(window.location.search);
        email.value = urlParams.get('email') || '';
        token.value = urlParams.get('token') || '';
    });

</script>
