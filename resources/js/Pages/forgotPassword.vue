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
                                            <input type="hidden" v-model="token"  >
                                            <input type="email" v-model="email" class="form-control form-control-user"
                                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="Enter Email Address...">
                                            <small v-if="errorEmail" class="text-danger" id="errorEmail">    {{ errorEmail }}</small>
                                        </div>
                                        <a href="#" @click="sendEmailReset()"
                                           class="btn btn-primary btn-user btn-block">
                                            Reset Password
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
    import {onMounted,ref} from 'vue'

    const email = ref('');
    const send = ref(false);
    const loading = ref(false);
    const errorEmail = ref('');
    const sendEmailReset = () => {

        loading.value = true;
        axios.post('/api/forgot-password', {
            email: email.value
        }).then((res) => {
            if(res.data.status === 200){
                loading.value = false;
                send.value = true;
                $.notify(res.data.message,'success');
            }
        })
            .catch((err) => {
                loading.value = false;
                send.value = false;
                errorEmail.value = err.response.data.errors.email

            })
    }
</script>
