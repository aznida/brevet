<template>
    <Head>
        <title>Reset Password - Aplikasi Ujian Online</title>
    </Head>
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.status" class="alert alert-success mt-2">
                    {{ $page.props.flash.status }}
                </div>

                <!-- Error Messages -->
                <div v-if="Object.keys($page.props.errors).length > 0" class="alert alert-danger mt-2">
                    <ul class="mb-0">
                        <li v-for="(error, key) in $page.props.errors" :key="key">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <div class="text-center text-md-center mb-4 mt-md-0">
                    <img src="/assets/images/favicon.png" alt="Brevetisasi DEFA Logo" class="brand-logo mb-2" style="height: 60px;">
                    <h4 class="mt-2" style="margin:0px">Reset Password</h4>
                </div>

                <div v-if="errors.email" class="alert alert-danger mt-2">
                    {{ errors.email }}
                </div>

                <form @submit.prevent="submit" class="mt-4">
                    <div class="form-group mb-4">
                        <label>Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input 
                                type="email" 
                                class="form-control" 
                                v-model="form.email"
                                placeholder="Enter your email"
                            >
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                class="form-control" 
                                v-model="form.password"
                                placeholder="Enter new password"
                            >
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                class="form-control" 
                                v-model="form.password_confirmation"
                                placeholder="Confirm new password"
                            >
                        </div>
                    </div>

                    <div class="d-grid">
                        <button 
                            type="submit" 
                            class="btn btn-gray-800"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'PROCESSING...' : 'RESET PASSWORD' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutParticipant from '../../../Layouts/Participant.vue';
import { reactive, watch } from 'vue';
import { router, Head, usePage } from '@inertiajs/vue3';

export default {
    layout: LayoutParticipant,
    components: {
        Head
    },
    props: {
        errors: Object,
        token: String,
    },
    setup(props) {
        const page = usePage();
        
        const form = reactive({
            email: '',
            password: '',
            password_confirmation: '',
            token: props.token,
            processing: false
        });

        const submit = () => {
            form.processing = true;
            router.post('/participant/reset-password', form, {
                preserveScroll: true,
                onSuccess: () => {
                    // Change the redirect path to the root URL
                    router.visit('/', {
                        replace: true
                    });
                },
                onError: () => {
                    form.processing = false;
                },
                onFinish: () => {
                    form.processing = false;
                }
            });
        };

        return {
            form,
            submit,
            router,
            page
        };
    }
};
</script>