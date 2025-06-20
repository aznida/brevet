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
                                <editor
                                    v-model="form.question"
                                    :init="{
                                        base_url: '/assets/tinymce/js/tinymce',
                                        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                        height: 200,
                                        menubar: true,
                                        branding: false,
                                        statusbar: false,
                                        skin: 'oxide',
                                        content_css: 'default'
                                    }"
                                    :cloud-channel="undefined"
                                />
                            </div>

                            <!-- Multiple Choice Form -->
                            <div v-if="exam.exam_type === 'multiple_choice'" class="table-responsive mb-4">
                                <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                    <tbody>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan A</td>
                                            <td>
                                                <editor
                                                    v-model="form.option_1"
                                                    :init="{
                                                        base_url: '/assets/tinymce/js/tinymce',
                                                        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                                        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                        height: 150,
                                                        menubar: false,
                                                        branding: false,
                                                        statusbar: false,
                                                        skin: 'oxide',
                                                        content_css: 'default'
                                                    }"
                                                    :cloud-channel="undefined"
                                                />
                                                <div v-if="exam.title.toLowerCase().includes('attitude') || exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                                    <label>Bobot Pilihan A</label>
                                                    <input type="number" class="form-control" v-model="form.option_1_weight" min="0" max="100" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan B</td>
                                            <td>
                                               <editor
                                                    v-model="form.option_2"
                                                    :init="{
                                                        base_url: '/assets/tinymce/js/tinymce',
                                                        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                                        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                        height: 150,
                                                        menubar: false,
                                                        branding: false,
                                                        statusbar: false,
                                                        skin: 'oxide',
                                                        content_css: 'default'
                                                    }"
                                                    :cloud-channel="undefined"
                                                />
                                                <div v-if="exam.title.toLowerCase().includes('attitude') || exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                                    <label>Bobot Pilihan B</label>
                                                    <input type="number" class="form-control" v-model="form.option_2_weight" min="0" max="100" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan C</td>
                                            <td>
                                                <editor
                                                    v-model="form.option_3"
                                                    :init="{
                                                        base_url: '/assets/tinymce/js/tinymce',
                                                        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                                        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                        height: 150,
                                                        menubar: false,
                                                        branding: false,
                                                        statusbar: false,
                                                        skin: 'oxide',
                                                        content_css: 'default'
                                                    }"
                                                    :cloud-channel="undefined"
                                                />
                                                <div v-if="exam.title.toLowerCase().includes('attitude') || exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                                    <label>Bobot Pilihan C</label>
                                                    <input type="number" class="form-control" v-model="form.option_3_weight" min="0" max="100" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan D</td>
                                            <td>
                                                <editor
                                                    v-model="form.option_4"
                                                    :init="{
                                                        base_url: '/assets/tinymce/js/tinymce',
                                                        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                                        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                        height: 150,
                                                        menubar: false,
                                                        branding: false,
                                                        statusbar: false,
                                                        skin: 'oxide',
                                                        content_css: 'default'
                                                    }"
                                                    :cloud-channel="undefined"
                                                />
                                                <div v-if="exam.title.toLowerCase().includes('attitude') || exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                                    <label>Bobot Pilihan D</label>
                                                    <input type="number" class="form-control" v-model="form.option_4_weight" min="0" max="100" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan E</td>
                                            <td>
                                                <editor
                                                    v-model="form.option_5"
                                                    :init="{
                                                        base_url: '/assets/tinymce/js/tinymce',
                                                        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
                                                        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                        height: 150,
                                                        menubar: false,
                                                        branding: false,
                                                        statusbar: false,
                                                        skin: 'oxide',
                                                        content_css: 'default'
                                                    }"
                                                    :cloud-channel="undefined"
                                                />
                                                <div v-if="exam.title.toLowerCase().includes('attitude') || exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                                    <label>Bobot Pilihan E</label>
                                                    <input type="number" class="form-control" v-model="form.option_5_weight" min="0" max="100" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="!exam.title.toLowerCase().includes('attitude') && !exam.title.toLowerCase().includes('sikap') && !exam.title.toLowerCase().includes('akhlak')">
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
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Level Soal</td>
                                            <td>
                                                <select class="form-control" v-model="form.level">
                                                    <option value="Basic">Basic 🥉</option>
                                                    <option value="Intermediate">Intermediate 🥈</option>
                                                    <option value="Advanced">Advanced 🥇</option>
                                                    <option value="Expert">Expert 💎</option>
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
    import { reactive, computed, onMounted } from 'vue';

    //import sweet alert2
    import Swal from 'sweetalert2';

    //import TinyMCE
    import Editor from '@tinymce/tinymce-vue';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link,
            Editor,
        },

        //props
        props: {
            errors: Object,
            exam: Object,
            question: Object,
        },
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
                option_1_weight: props.question.option_1_weight || null,
                option_2_weight: props.question.option_2_weight || null,
                option_3_weight: props.question.option_3_weight || null,
                option_4_weight: props.question.option_4_weight || null,
                option_5_weight: props.question.option_5_weight || null,
                answer: props.question.answer || null,
                level: props.question.level || null,
                rating_scale: '6'
            });
            
            // Add computed property for total weight
            const totalWeight = computed(() => {
                if (props.exam.title.toLowerCase().includes('attitude') || 
                    props.exam.title.toLowerCase().includes('sikap') || 
                    props.exam.title.toLowerCase().includes('akhlak')) {
                    return Number(form.option_1_weight || 0) +
                           Number(form.option_2_weight || 0) +
                           Number(form.option_3_weight || 0) +
                           Number(form.option_4_weight || 0) +
                           Number(form.option_5_weight || 0);
                }
                return 0;
            });
        
            const submit = () => {
                const formData = {
                    question: form.question,
                    question_type: props.exam.exam_type,
                };
        
                if (props.exam.exam_type === 'multiple_choice') {
                    Object.assign(formData, {
                        option_1: form.option_1,
                        option_2: form.option_2,
                        option_3: form.option_3,
                        option_4: form.option_4,
                        option_5: form.option_5,
                        option_1_weight: props.exam.title.toLowerCase().includes('attitude') || props.exam.title.toLowerCase().includes('sikap') || props.exam.title.toLowerCase().includes('akhlak') ? form.option_1_weight : null,
                        option_2_weight: props.exam.title.toLowerCase().includes('attitude') || props.exam.title.toLowerCase().includes('sikap') || props.exam.title.toLowerCase().includes('akhlak') ? form.option_2_weight : null,
                        option_3_weight: props.exam.title.toLowerCase().includes('attitude') || props.exam.title.toLowerCase().includes('sikap') || props.exam.title.toLowerCase().includes('akhlak') ? form.option_3_weight : null,
                        option_4_weight: props.exam.title.toLowerCase().includes('attitude') || props.exam.title.toLowerCase().includes('sikap') || props.exam.title.toLowerCase().includes('akhlak') ? form.option_4_weight : null,
                        option_5_weight: props.exam.title.toLowerCase().includes('attitude') || props.exam.title.toLowerCase().includes('sikap') || props.exam.title.toLowerCase().includes('akhlak') ? form.option_5_weight : null,
                        answer: form.answer,
                        level: form.level,
                        rating_scale: null
                    });
                }
                else {
                    Object.assign(formData, {
                        option_1: null,
                        option_2: null,
                        option_3: null,
                        option_4: null,
                        option_5: null,
                        answer: null,
                        level: null, // Remove level from formData if not needed for rating_scale di
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
                totalWeight
            }
        }
    }
</script>

<style>

</style>