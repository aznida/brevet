<template>
    <Head>
        <title>Import Soal Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="col-md-12">
            <Link :href="`/admin/exams/${exam.id}`" class="btn btn-md btn-primary border-0 shadow mb-3 me-3" type="button">
                <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
            </Link>
            
            <!-- Only show import option for multiple choice -->
            <template v-if="exam.exam_type === 'multiple_choice'">
                <a href="/assets/excel/Form_Questions_multiple.xls" target="_blank"
                    class="btn btn-md btn-success border-0 shadow mb-3 text-white me-2" type="button">
                    <i class="fa fa-file-excel me-2"></i> Format Multiple Test
                </a>
                <a href="/assets/excel/Form_Questions.xls" target="_blank"
                    class="btn btn-md btn-success border-0 shadow mb-3 text-white" type="button">
                    <i class="fa fa-file-excel me-2"></i> Format Atitude Test
                </a>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-question-circle"></i> Import Soal Pilihan Ganda</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label>File Excel</label>
                                <input type="file" class="form-control" @input="form.file = $event.target.files[0]">
                                <div v-if="errors.file" class="alert alert-danger mt-2">
                                    {{ errors.file }}
                                </div>
                                <div v-if="errors[0]" class="alert alert-danger mt-2">
                                    {{ errors[0] }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Upload</button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow">Reset</button>
                        </form>
                    </div>
                </div>
            </template>
            
            <!-- Show message for rating scale -->
            <template v-else>
                <div class="alert alert-warning">
                    Import soal hanya tersedia untuk tipe ujian Pilihan Ganda.
                </div>
            </template>
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
    import {
        reactive
    } from 'vue';

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
            exam: Object,
        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                file: '',
            });

            //method "submit"
            const submit = () => {
                // Check if it's an attitude test
                const isAttitudeExam = props.exam.title.toLowerCase().includes('attitude') || 
                                      props.exam.title.toLowerCase().includes('sikap') || 
                                      props.exam.title.toLowerCase().includes('akhlak');

                // If it's an attitude test, show a reminder about weights
                if (isAttitudeExam) {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Pastikan total bobot untuk setiap jawaban tidak melebihi 100 atau tidak diisi! Silakan periksa file Excel Anda terlebih dahulu.',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ya, Saya Sudah Cek',
                        cancelButtonText: 'Batal',
                        showCancelButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            uploadFile();
                        }
                    });
                } else {
                    uploadFile();
                }
            }

            // Extract the upload functionality to a separate method
            const uploadFile = () => {
                //send data to server
                router.post(`/admin/exams/${props.exam.id}/questions/import`, {
                    //data
                    file: form.file,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Import Soal Ujian Berhasil Disimpan!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            }

            return {
                form,
                submit
            };

        }

    }

</script>

<style>

</style>