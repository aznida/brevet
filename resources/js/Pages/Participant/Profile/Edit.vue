<template>
    <Head>
        <title>Edit Profile - Aplikasi Ujian Online</title>
    </Head>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5 class="card-title mb-4">Edit Profil</h5>
                    
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                v-model="form.name"
                                :class="{ 'is-invalid': errors.name }"
                            >
                            <div class="invalid-feedback" v-if="errors.name">
                                {{ errors.name }}
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                v-model="form.email"
                                :class="{ 'is-invalid': errors.email }"
                            >
                            <div class="invalid-feedback" v-if="errors.email">
                                {{ errors.email }}
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="hp" class="form-label">No. HP</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="hp" 
                                v-model="form.hp"
                                :class="{ 'is-invalid': errors.hp }"
                            >
                            <div class="invalid-feedback" v-if="errors.hp">
                                {{ errors.hp }}
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h6 class="mb-3">Ubah Password (Opsional)</h6>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="current_password" 
                                v-model="form.current_password"
                                :class="{ 'is-invalid': errors.current_password }"
                            >
                            <div class="invalid-feedback" v-if="errors.current_password">
                                {{ errors.current_password }}
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                v-model="form.password"
                                :class="{ 'is-invalid': errors.password }"
                            >
                            <div class="invalid-feedback" v-if="errors.password">
                                {{ errors.password }}
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                v-model="form.password_confirmation"
                            >
                        </div>
                        
                        <div class="profile-actions mt-4">
                            <Link 
                                href="/participant/profile" 
                                class="action-button back-button"
                            >
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </Link>
                            
                            <button 
                                type="submit" 
                                class="action-button save-button"
                                :disabled="processing"
                            >
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutParticipant from '../../../Layouts/Participant.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    layout: LayoutParticipant,
    components: {
        Head,
        Link
    },
    props: {
        auth: Object,
        participant: Object,
        errors: Object
    },
    setup(props) {
        const form = useForm({
            name: props.auth.participant.name,
            email: props.auth.participant.email,
            hp: props.auth.participant.hp,
            current_password: '',
            password: '',
            password_confirmation: ''
        });

        function submit() {
            form.put('/participant/profile/update');
        }

        return { form, submit };
    }
}
</script>

<style scoped>
.profile-actions {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.75rem;
}

.action-button {
    padding: 0.6rem 0;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.back-button {
    background-color: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.back-button:hover {
    background-color: #e2e8f0;
}

.save-button {
    background-color: #1a2234;
    color: white;
}

.save-button:hover {
    background-color: #111827;
}

.save-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Responsive styles */
@media (min-width: 640px) {
    .profile-actions {
        grid-template-columns: 1fr 1fr;
    }
    
    .action-button {
        padding: 0.75rem 0;
    }
}
</style>