<template>
    <Head>
        <title>Edit Soal Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link :href="`/admin/exams/${exam.id}`" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-question-circle"></i> Edit Soal Ujian</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <!-- Question input always shown -->
                            <div class="mb-4">
                                <label>Soal</label>
                                <QuillEditor theme="snow" v-model:content="form.question" contentType="html" />
                            </div>

                            <!-- Multiple Choice Form -->
                            <div v-if="exam.exam_type === 'multiple_choice'" class="table-responsive mb-4">
                                <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                    <tbody>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Soal</td>
                                            <td>
                                                <QuillEditor theme="snow" v-model:content="form.option_1" contentType="html" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan A</td>
                                            <td>
                                                <QuillEditor theme="snow" v-model:content="form.option_2" contentType="html" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan C</td>
                                            <td>
                                                <QuillEditor theme="snow" v-model:content="form.option_3" contentType="html" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan D</td>
                                            <td>
                                                <QuillEditor theme="snow" v-model:content="form.option_4" contentType="html" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan E</td>
                                            <td>
                                                <QuillEditor theme="snow" v-model:content="form.option_5" contentType="html" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Jawaban Benar</td>
                                            <td>
                                                <select class="form-control" v-model="form.answer">
                                                    <option value="1">A</option>
                                                    <option value="2">B</option>
                                                    <option value="3">C</option>
                                                    <option value="4">D</option>
                                                    <option value="5">E</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Rating Scale Form -->
                            <div v-if="exam.exam_type === 'rating_scale'" class="mb-4">
                                <div class="alert alert-info">
                                    <p class="mb-0">Skala Penilaian:</p>
                                    <ul class="mb-0">
                                        <li>1 = Sangat Jarang</li>
                                        <li>2 = Jarang</li>
                                        <li>3 = Kadang-kadang</li>
                                        <li>4 = Sering</li>
                                        <li>5 = Sangat Sering</li>
                                        <li>6 = Selalu</li>
                                    </ul>
                                </div>
                                <input type="hidden" v-model="form.rating_scale" value="6">
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

    //import Quill
    import { QuillEditor } from '@vueup/vue-quill';
    import '@vueup/vue-quill/dist/vue-quill.snow.css';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link,
            QuillEditor,
        },

        //props
        props: {
            errors: Object,
            exam: Object,
            question: Object,
        },

        //inisialisasi composition API
        setup(props) {
            const form = reactive({
                question: props.question.question,
                question_type: props.exam.exam_type,
                option_1: props.question.option_1 || null,
                option_2: props.question.option_2 || null,
                option_3: props.question.option_3 || null,
                option_4: props.question.option_4 || null,
                option_5: props.question.option_5 || null,
                answer: props.question.answer || null,
                rating_scale: '6' // Fixed to 6-point scale
            });
        
            const submit = () => {
                const formData = {
                    question: form.question,
                    question_type: props.exam.exam_type, // Use exam type directly
                };
        
                if (props.exam.exam_type === 'multiple_choice') {
                    Object.assign(formData, {
                        option_1: form.option_1,
                        option_2: form.option_2,
                        option_3: form.option_3,
                        option_4: form.option_4,
                        option_5: form.option_5,
                        answer: form.answer,
                        rating_scale: null
                    });
                } else {
                    Object.assign(formData, {
                        option_1: null,
                        option_2: null,
                        option_3: null,
                        option_4: null,
                        option_5: null,
                        answer: null,
                        rating_scale: '6' // Fixed 6-point scale
                    });
                }
        
                router.put(`/admin/exams/${props.exam.id}/questions/${props.question.id}/update`, 
                    formData,
                    {
                        onSuccess: () => {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Soal Ujian Berhasil Diupdate!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                    }
                );
            }
        
            return {
                form,
                submit,
            }
        }
    }
</script>

<style>

</style>