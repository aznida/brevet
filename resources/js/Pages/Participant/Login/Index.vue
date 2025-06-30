<template>
    <Head>
        <title>Login Partisipan - Aplikasi Ujian Online</title>
    </Head>
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                <div class="text-center text-md-center mt-md-0">
                <img src="/assets/images/favicon.png" alt="Brevetisasi DEFA Logo" class="brand-logo mb-2" style="height: 60px;">
                <h4 class="mt-2" style="margin:0px">Hello, Welcome Back 👋!</h4>
                <span class="text-muted">Let’s Empower Your Skills!</span>
            </div>
                <div v-if="errors.message" class="alert alert-danger mt-2">
                    {{ errors.message }}
                </div> 
                <div v-if="$page.props.session.error" class="alert alert-danger mt-2">
                    {{ $page.props.session.error }}
                </div>
                <form @submit.prevent="submit" class="mt-4">
                     @csrf
                    <div class="form-group mb-4">
                        <label for="email">Nik</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa fa-key"></i>
                            </span>
                            <input type="number" class="form-control" v-model="form.nik" placeholder="NIK">
                        </div>
                        <div v-if="errors.nik" class="alert alert-danger mt-2">
                            {{ errors.nik }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-group mb-4">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <input :type="showPassword ? 'text' : 'password'" placeholder="Password" class="form-control"
                                    v-model="form.password">
                                <span class="input-group-text" @click="showPassword = !showPassword" style="cursor: pointer;">
                                    <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                </span>
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
                            <div class="ms-auto">
                                <a 
                                    href="#"
                                    class="small text-right"
                                    @click.prevent="router.get('/participant/forgot-password')"
                                    >
                                    Forgot Password?
                                </a>
                            </div>
                        </div>

                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-gray-800">LOGIN</button>
                    </div>
                    <div v-if="!isBrempiApp" class="d-flex justify-content-center mt-4">
                        <div class="text-center">
                            <p class="text-muted mb-1">Download Aplikasi Mobile:</p>
                            <div class="d-flex justify-content-center">
                                <a href="/assets/app/brempi.1.0.apk" class="text-decoration-none">
                                    <img src="/assets/images/android.png" alt="Get it on Android" height="50">
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutParticipant from '../../../Layouts/Participant.vue';

    //import Head from Inertia
    import {
        Head,
        router,
    } from '@inertiajs/vue3';

    //import reactive
    import {
        reactive,
        ref,
        onMounted
    } from 'vue';

    export default {

        //layout
        layout: LayoutParticipant,

        //register component
        components: {
            Head
        },

        //props
        props: {
            errors: Object,
        },

        //inisialisasi composition API
        setup() {

            //define form state
            const form = reactive({
                nik: '',
                password: '',
            });

            // State untuk toggle password visibility
            const showPassword = ref(false);

            // State to check if the device is Android
            const isAndroid = ref(false);
            const isWebView = ref(false);
            const isBrempiApp = ref(false);

            // Check user agent on mounted
            onMounted(() => {
                const userAgent = navigator.userAgent || navigator.vendor || window.opera;
                isAndroid.value = /android/i.test(userAgent);
                isWebView.value = /wv|WebView/i.test(userAgent);
                isBrempiApp.value = isWebView.value || /brempi/i.test(userAgent);
            });

            //submit method
            const submit = () => {

                //send data to server
                router.post('/participants/login', {

                    //data
                    nik: form.nik,
                    password: form.password,
                });
            }

            //return
            return {
                form,
                submit,
                router,
                isAndroid,
                isWebView,
                isBrempiApp,
                showPassword // Tambahkan showPassword ke return values
            }
        }

    }

</script>

<style>
.gap-2 {
    gap: 0.5rem !important;
}
</style>