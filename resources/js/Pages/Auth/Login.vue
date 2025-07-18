<template>

    <Head>
        <title>Login Administrator - Aplikasi Ujian Online</title>
    </Head>
    
    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
        <div class="text-center text-md-center mb-5 mt-md-0">
            <img src="/assets/images/favicon.png" alt="Brevetisasi DEFA Logo" class="brand-logo mb-2" style="height: 60px;">
            <h4 class="mt-2" style="margin:0px">Hello, Welcome Back!</h4>
            <span class="text-muted">Let's Empower Your Skills</span>
        </div>
        <form @submit.prevent="submit" class="mt-4">
            <!-- Tambahkan CSRF Token di sini -->
            <input type="hidden" name="_token" :value="$page.props.csrf_token">
            
            <div class="form-group mb-4">
                <label for="email">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <input type="email" class="form-control" v-model="form.email" placeholder="Email Address">
                </div>
                <div v-if="errors.email" class="alert alert-danger mt-2">
                    {{ errors.email }}
                </div>
            </div>

            <div class="form-group">
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input type="password" placeholder="Password" class="form-control" v-model="form.password">
                    </div>
                    <div v-if="errors.password" class="alert alert-danger mt-2">
                        {{ errors.password }}
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-top mb-4">
                    <div>
                        <input class="form-check-input" type="checkbox" value="" id="remember">
                        <label class="form-check-label mb-0" style="margin-left: 8px;" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>

            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-gray-800">LOGIN</button>
            </div>
        </form>
    </div>
</template>

<script>
    //import layout
    import LayoutAuth from '../../Layouts/Auth.vue';

    //import Inertia
    import {
        Head,
        router
    } from '@inertiajs/vue3';

    //import reactive
    import {
        reactive
    } from 'vue';

    export default {

        //layout
        layout: LayoutAuth,

        //register component
        components: {
            Head
        },

        //props
        props: {
            errors: Object,
            session: Object
        },

        //define composition API
        setup() {

            //define form state
            const form = reactive({
                email: '',
                password: '',
            });

            //submit method
            const submit = () => {

                //send data to server
                router.post('/login', {

                    //data
                    email: form.email,
                    password: form.password,
                    // Remove the _token line below, Inertia handles this automatically
                    // _token: document.querySelector('input[name="_token"]')?.value
                });
            }

            //return form state and submit method
            return {
                form,
                submit,
            };

        }
    }
</script>