<template>
    <Head>
        <title>Tambah User - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/users" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Tambah User</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label>Nama</label> 
                                <input type="text" class="form-control" placeholder="Masukkan Nama" v-model="form.name">
                                <div v-if="errors.name" class="alert alert-danger mt-2">
                                    {{ errors.name }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Email</label> 
                                <input type="email" class="form-control" placeholder="Masukkan Email" v-model="form.email">
                                <div v-if="errors.email" class="alert alert-danger mt-2">
                                    {{ errors.email }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Password</label> 
                                <input type="password" class="form-control" placeholder="Masukkan Password" v-model="form.password">
                                <div v-if="errors.password" class="alert alert-danger mt-2">
                                    {{ errors.password }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Role</label> 
                                <select class="form-select" v-model="form.role">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="super admin">Super Admin</option>
                                    <option value="local admin">Local Admin</option>
                                    <option value="local admin">Mitra</option>
                                </select>
                                <div v-if="errors.role" class="alert alert-danger mt-2">
                                    {{ errors.role }}
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
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import Head and Link from Inertia
    import {
        Head,
        Link,
        router
    } from '@inertiajs/vue3';

    //import reactive from vue
    import { reactive } from 'vue';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {
        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
        },

        //inisialisasi composition API
        setup() {
            //define state form with reactive
            const form = reactive({
                name: '',
                email: '',
                password: '',
                role: '',
            });

            //method "submit"
            const submit = () => {
                //send data to server
                router.post('/admin/users', {
                    //data
                    name: form.name,
                    email: form.email,
                    password: form.password,
                    role: form.role,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'User Baru Berhasil Disimpan!',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            }

            //return
            return {
                form,
                submit,
            }
        }
    }
</script>