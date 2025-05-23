<template>
    <Head>
        <title>Tambah Partisipan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/participants" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Tambah Partisipan</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">NIK</label>
                                        <input type="text" class="form-control" v-model="form.nik" placeholder="NIK Participant">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" v-model="form.name" placeholder="Nama Participant">
                                    </div>
                                    
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" v-model="form.tanggal_lahir" @change="calculateAge">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Email</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan Email Partisipan" v-model="form.email">
                                        <div v-if="errors.email" class="alert alert-danger mt-2">
                                            {{ errors.email }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Masa Kerja (Tahun)</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            v-model="form.masa_kerja" 
                                            placeholder="Contoh: 5"
                                            min="0"
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Usia</label>
                                        <input type="text" class="form-control" :value="usia + ' Tahun'" readonly>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Nomor Handphone</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan No. Hp Partisipan" v-model="form.hp">
                                        <div v-if="errors.hp" class="alert alert-danger mt-2">
                                            {{ errors.hp }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-select" v-model="form.gender">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <div v-if="errors.gender" class="alert alert-danger mt-2">
                                            {{ errors.gender }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>TREG - Area Ujian</label> 
                                        <select class="form-select" v-model="form.area_id">
                                            <option v-for="(area, index) in areas" :key="index" :value="area.id">{{ area.title }}</option>
                                        </select>
                                        <div v-if="errors.area_id" class="alert alert-danger mt-2">
                                            {{ errors.area_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Witel/Kota</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan Witel / Kota" v-model="form.witel">
                                        <div v-if="errors.witel" class="alert alert-danger mt-2">
                                            {{ errors.witel }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Job Role</label> 
                                        <select class="form-select" v-model="form.role">
                                            <option value="Teknisi">Teknisi</option>
                                            <option value="Supervisor">Supervisor</option>
                                        </select>
                                        <div v-if="errors.role" class="alert alert-danger mt-2">
                                            {{ errors.role }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Status</label> 
                                        <select class="form-select" v-model="form.status">
                                            <option value="Aktif">Aktif</option>
                                            <option value="Block">Block</option>
                                        </select>
                                        <div v-if="errors.status" class="alert alert-danger mt-2">
                                            {{ errors.status }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Password</label> 
                                        <input type="password" class="form-control" placeholder="Masukkan Password" v-model="form.password">
                                        <div v-if="errors.password" class="alert alert-danger mt-2">
                                            {{ errors.password }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Konfirmasi Password</label> 
                                        <input type="password" class="form-control" placeholder="Masukkan Konfirmasi Password" v-model="form.password_confirmation">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Simpan</button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import
import { router } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3';
import LayoutAdmin from '../../../Layouts/Admin.vue';

export default {
    //layout
    layout: LayoutAdmin,

    //components
    components: {
        Head,
        Link
    },

    //props
    props: {
        errors: Object,
        areas: Array,
    },

    //data function
    data() {
        return {
            form: {
                nik: '',
                name: '',
                masa_kerja: '',
                tanggal_lahir: '',  // Will automatically be in YYYY-MM-DD format from date input
                email: '',
                hp: '',
                witel: '',
                area_id: '',
                gender: '',
                role: '',
                status: '',
                password: '',
                password_confirmation: ''
            },
            usia: ''
        }
    },

    //methods
    methods: {
        calculateAge() {
            if (this.form.tanggal_lahir) {
                const birthDate = new Date(this.form.tanggal_lahir); // Date is already in YYYY-MM-DD format
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                
                this.usia = age;
            } else {
                this.usia = '';
            }
        },

        submit() {
            // The date will already be in YYYY-MM-DD format when submitted
            router.post('/admin/participants', {
                nik: this.form.nik,
                name: this.form.name,
                masa_kerja: this.form.masa_kerja,
                tanggal_lahir: this.form.tanggal_lahir,
                email: this.form.email,
                hp: this.form.hp,
                witel: this.form.witel,
                area_id: this.form.area_id,
                gender: this.form.gender,
                role: this.form.role,
                status: this.form.status,
                password: this.form.password,
                password_confirmation: this.form.password_confirmation
            }, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Partisipan Berhasil Disimpan.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });
        }
    }
}
</script>

<style>

</style>