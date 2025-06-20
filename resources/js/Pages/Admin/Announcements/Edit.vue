<template>
    <Head>
        <title>Edit Pengumuman - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/announcements" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-bell"></i> Edit Pengumuman</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Pengumuman</label>
                                        <input type="text" class="form-control" v-model="form.title" placeholder="Judul Pengumuman">
                                        <div v-if="errors.title" class="alert alert-danger mt-2">
                                            {{ errors.title }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Isi Pengumuman</label>
                                        <editor
                                            v-model="form.content"
                                            :init="{
                                                // Ubah base_url menjadi path yang benar ke tinymce
                                                base_url: '/assets/tinymce/js/tinymce',
                                                plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                height: 400,
                                                menubar: true,
                                                branding: false,
                                                statusbar: false,
                                                // Tambahkan konfigurasi skin jika diperlukan
                                                skin: 'oxide',
                                                content_css: 'default'
                                            }"
                                            :cloud-channel="undefined"
                                        />
                                        <div v-if="errors.content" class="alert alert-danger mt-2">
                                            {{ errors.content }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" v-model="form.is_active">
                                            <option :value="true">Aktif</option>
                                            <option :value="false">Tidak Aktif</option>
                                        </select>
                                        <div v-if="errors.is_active" class="alert alert-danger mt-2">
                                            {{ errors.is_active }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2"><i class="fa fa-save"></i> Update</button>
                                    <button type="reset" class="btn btn-md btn-warning border-0 shadow"><i class="fa fa-redo"></i> Reset</button>
                                </div>
                            </div>
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
import { Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
// Import TinyMCE Vue Component
import Editor from '@tinymce/tinymce-vue';
import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutAdmin,

    //components
    components: {
        Head,
        Link,
        Editor
    },

    //props
    props: {
        errors: Object,
        announcement: Object
    },

    //data function
    data() {
        return {
            form: {
                title: this.announcement.title,
                content: this.announcement.content,
                is_active: this.announcement.is_active
            }
        }
    },

    //methods
    mounted() {
        // Pastikan TinyMCE dimuat dengan benar
        if (window.tinymce) {
            console.log("TinyMCE tersedia");
        } else {
            console.error("TinyMCE tidak tersedia");
            // Muat ulang script TinyMCE jika diperlukan
            const script = document.createElement('script');
            script.src = '/assets/tinymce/js/tinymce/tinymce.min.js';
            script.onload = () => {
                console.log("TinyMCE berhasil dimuat ulang");
            };
            document.head.appendChild(script);
        }
    },
    methods: {
        submit() {
            router.put(`/admin/announcements/${this.announcement.id}`, this.form, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Pengumuman Berhasil Diupdate!',
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
.ql-container {
    min-height: 200px;
}
</style>