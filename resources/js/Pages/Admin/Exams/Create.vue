<template>
    <Head>
        <title>Tambah Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/exams" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-edit"></i> Tambah Ujian</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="mb-4">
                                <label>Nama Ujian</label> 
                                <input type="text" class="form-control" placeholder="Masukkan Nama Ujian" v-model="form.title">
                                <div v-if="errors.title" class="alert alert-danger mt-2">
                                    {{ errors.title }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Kategori Ujian</label> 
                                        <select class="form-select" v-model="form.category_id">
                                            <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.title }}</option>
                                        </select>
                                        <div v-if="errors.category_id" class="alert alert-danger mt-2">
                                            {{ errors.category_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Area</label> 
                                        <select class="form-select" v-model="form.area_id">
                                            <option v-for="(area, index) in areas" :key="index" :value="area.id">{{ area.title }}</option>
                                        </select>
                                        <div v-if="errors.area_id" class="alert alert-danger mt-2">
                                            {{ errors.area_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Deskripsi</label> 
                                <QuillEditor
                                    v-model:content="form.description"
                                    contentType="html"
                                    theme="snow"
                                    toolbar="full"
                                />
                                <div v-if="errors.description" class="alert alert-danger mt-2">
                                    {{ errors.description }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Acak Soal</label> 
                                        <select class="form-select" v-model="form.random_question">
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>
                                        <div v-if="errors.random_question" class="alert alert-danger mt-2">
                                            {{ errors.random_question }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Acak Jawaban</label> 
                                        <select class="form-select" v-model="form.random_answer">
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>
                                        <div v-if="errors.random_answer" class="alert alert-danger mt-2">
                                            {{ errors.random_answer }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Tampilkan Hasil</label> 
                                        <select class="form-select" v-model="form.show_answer">
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>
                                        <div v-if="errors.show_answer" class="alert alert-danger mt-2">
                                            {{ errors.show_answer }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Tipe Ujian</label> 
                                        <select class="form-select" v-model="form.exam_type">
                                            <option value="multiple_choice">Pilihan Ganda</option>
                                            <option value="rating_scale">Skala Penilaian</option>
                                        </select>
                                        <div v-if="errors.exam_type" class="alert alert-danger mt-2">
                                            {{ errors.exam_type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Durasi (Menit)</label> 
                                        <input type="number" min="1" class="form-control" placeholder="Masukkan Durasi Ujian (Menit)" v-model="form.duration">
                                        <div v-if="errors.duration" class="alert alert-danger mt-2">
                                            {{ errors.duration }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jumlah Soal yang ditampilkan</label> 
                                        <input type="number" min="1" class="form-control" placeholder="Masukkan Jumlah Soal yang ditampilkan" v-model="form.showqty">
                                        <div v-if="errors.showqty" class="alert alert-danger mt-2">
                                            {{ errors.showqty }}
                                        </div>
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
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import { reactive } from 'vue';
    import Swal from 'sweetalert2';
    
    //import Quill
    import { QuillEditor } from '@vueup/vue-quill'
    import '@vueup/vue-quill/dist/vue-quill.snow.css'

    export default {
        layout: LayoutAdmin,
        components: {
            Head,
            Link,
            QuillEditor
        },
        
        //props
        props: {
            errors: Object,
            categories: Array,
            areas: Array,
        },

        setup() {
            const form = reactive({
                title: '',
                category_id: '',
                area_id: '',
                duration: '',
                showqty: '',
                description: '',
                random_question: '',
                random_answer: '',
                show_answer: '',
                exam_type: 'multiple_choice', // Add this line
            });

            const submit = () => {
                router.post('/admin/exams', {
                    ...form // Spread operator to include all form fields
                }, {
                    onSuccess: () => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Ujian Berhasil Disimpan!.',
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