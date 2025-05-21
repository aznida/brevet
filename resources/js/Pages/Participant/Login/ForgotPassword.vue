<template>
    <Head>
        <title>Forgot Password - Aplikasi Ujian Online</title>
    </Head>
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                <div class="text-center text-md-center mb-4 mt-md-0">
                    <img src="/assets/images/favicon.png" alt="Brevetisasi DEFA Logo" class="brand-logo mb-2" style="height: 60px;">
                    <h4 class="mt-2" style="margin:0px">Reset Password</h4>
                    <span class="text-muted">Enter your NIK or Email</span>
                </div>

                <div v-if="status" class="alert alert-success mt-2">
                    {{ status }}
                </div>

                <div v-if="errors.identifier" class="alert alert-danger mt-2">
                    {{ errors.identifier }}
                </div>

                <form @submit.prevent="submit" class="mt-4">
                    <div class="form-group mb-4">
                        <label>NIK atau Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                            <input 
                                type="text" 
                                class="form-control" 
                                v-model="form.identifier"
                                placeholder="Masukkan NIK atau Email"
                            >
                        </div>
                    </div>

                    <div class="d-grid">
                        <button 
                            type="submit" 
                            class="btn btn-gray-800"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'PROCESSING...' : 'SEND RESET LINK' }}
                        </button>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <a 
                            href="#"
                            class="small"
                            @click.prevent="router.get('/')"
                        >
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutParticipant from '../../../Layouts/Participant.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

export default {
    layout: LayoutParticipant,
    components: {
        Head
    },
    props: {
        errors: Object,
        status: String
    },
    setup() {
        const form = reactive({
            identifier: '',
            processing: false
        });

        const submit = () => {
            form.processing = true;
            router.post('/participant/forgot-password', {
                identifier: form.identifier
            }, {
                onFinish: () => form.processing = false
            });
        };

        return {
            form,
            submit,
            router // Add this line to expose router
        };
    }
};
</script>