<template>
    <Head>
        <title>Edit Partisipan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/participants" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Edit Participant</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>NIK</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan NIK Partisipan" v-model="form.nik">
                                        <div v-if="errors.nik" class="alert alert-danger mt-2">
                                            {{ errors.nik }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Nama Lengkap</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Partisipan" v-model="form.name">
                                        <div v-if="errors.name" class="alert alert-danger mt-2">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Email</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan Email Partisipan" v-model="form.email">
                                        <div v-if="errors.email" class="alert alert-danger mt-2">
                                            {{ errors.email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Nomor Handphone</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan No. Hp Partisipan" v-model="form.hp">
                                        <div v-if="errors.hp" class="alert alert-danger mt-2">
                                            {{ errors.hp }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>TREG - Area</label> 
                                        <select class="form-select" v-model="form.area_id">
                                            <option v-for="(area, index) in areas" :key="index" :value="area.id">{{ area.title }}</option>
                                        </select>
                                        <div v-if="errors.area_id" class="alert alert-danger mt-2">
                                            {{ errors.area_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Witel / Kota</label> 
                                        <input type="text" class="form-control" placeholder="Masukkan Witel/Kota Partisipan" v-model="form.witel">
                                        <div v-if="errors.witel" class="alert alert-danger mt-2">
                                            {{ errors.witel }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jenis Kelamin</label> 
                                        <select class="form-select" v-model="form.gender">
                                            <option value="L">Laki - Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <div v-if="errors.gender" class="alert alert-danger mt-2">
                                            {{ errors.gender }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Password</label> 
                                        <input type="password" class="form-control" placeholder="Masukkan Password" v-model="form.password">
                                        <div v-if="errors.password" class="alert alert-danger mt-2">
                                            {{ errors.password }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Konfirmasi Password</label> 
                                        <input type="password" class="form-control" placeholder="Masukkan Konfirmasi Password" v-model="form.password_confirmation">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Update</button>
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

    //import Heade and Link from Inertia
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
            areas: Array,
            participant: Object
        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                nik: props.participant.nik,
                name: props.participant.name,
                email: props.participant.email,
                hp: props.participant.hp,
                witel: props.participant.witel,
                area_id: props.participant.area_id,
                gender: props.participant.gender,
                password: '',
                password_confirmation: ''
            });

            //method "submit"
            const submit = () => {

                //send data to server
                router.put(`/admin/participants/${props.participant.id}`, {
                    //data
                    nik: form.nik,
                    name: form.name,
                    email: form.email,
                    hp: form.hp,
                    witel: form.witel,
                    area_id: form.area_id,
                    gender: form.gender,
                    password: form.password,
                    password_confirmation: form.password_confirmation
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Partisipan Berhasil Diupdate!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });

            }

            return {
                form,
                submit,
            };

        }

    }

</script>

<style>

</style>