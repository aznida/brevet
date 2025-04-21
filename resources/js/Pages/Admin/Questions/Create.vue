<template>
    <Head>
        <title>Tambah Soal Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link :href="`/admin/exams/${exam.id}`" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-question-circle"></i> Tambah Soal Ujian</h5>
                        <div>
                            <span class="badge bg-primary me-2">
                                {{ exam.category?.title }} | {{ exam.title }}
                            </span>
                            <span class="badge bg-secondary">
                                {{ exam.exam_type }}
                            </span>
                        </div>
                        <hr>
                        <form @submit.prevent="submit">
                            <!-- Question input -->
                            
                            <div class="mb-4">
                                <label>Soal</label>
                                <QuillEditor
                                    v-model:content="form.question"
                                    contentType="html"
                                    theme="snow"
                                    :toolbar="[
                                        ['bold', 'italic', 'underline'],
                                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                        ['link', 'image'],
                                    ]"
                                />
                                <div v-if="errors.question" class="alert alert-danger mt-2">
                                    {{ errors.question }}
                                </div>
                            </div>

                            <!-- Multiple Choice options -->
                            <div v-if="isMultipleChoice">
                                <div class="mb-4">
                                    <label>Pilihan A</label>
                                    <QuillEditor
                                        v-model:content="form.option_1"
                                        contentType="html"
                                        theme="snow"
                                        :toolbar="[['bold', 'italic', 'underline'], ['link', 'image']]"
                                    />
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan A</label>
                                        <input type="number" class="form-control" v-model="form.option_1_weight" min="0" max="100" />
                                    </div>
                                    <div v-if="errors.option_1" class="alert alert-danger mt-2">{{ errors.option_1 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan B</label>
                                    <QuillEditor
                                        v-model:content="form.option_2"
                                        contentType="html"
                                        theme="snow"
                                        :toolbar="[['bold', 'italic', 'underline'], ['link', 'image']]"
                                    />
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan B</label>
                                        <input type="number" class="form-control" v-model="form.option_2_weight" min="0" max="100" />
                                    </div>
                                    <div v-if="errors.option_2" class="alert alert-danger mt-2">{{ errors.option_2 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan C</label>
                                    <QuillEditor v-model:content="form.option_3" contentType="html" theme="snow" :toolbar="[['bold', 'italic', 'underline'], ['link', 'image']]" />
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan C</label>
                                        <input type="number" class="form-control" v-model="form.option_3_weight" min="0" max="100" />
                                    </div>
                                    <div v-if="errors.option_3" class="alert alert-danger mt-2">{{ errors.option_3 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan D</label>
                                    <QuillEditor v-model:content="form.option_4" contentType="html" theme="snow" :toolbar="[['bold', 'italic', 'underline'], ['link', 'image']]" />
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan D</label>
                                        <input type="number" class="form-control" v-model="form.option_4_weight" min="0" max="100" />
                                    </div>
                                    <div v-if="errors.option_4" class="alert alert-danger mt-2">{{ errors.option_4 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan E</label>
                                    <QuillEditor v-model:content="form.option_5" contentType="html" theme="snow" :toolbar="[['bold', 'italic', 'underline'], ['link', 'image']]" />
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan E</label>
                                        <input type="number" class="form-control" v-model="form.option_5_weight" min="0" max="100" />
                                    </div>
                                    <div v-if="errors.option_5" class="alert alert-danger mt-2">{{ errors.option_5 }}</div>
                                </div>
                                <!-- Add weight validation warning -->
                                <div v-if="exam.title.toLowerCase().includes('attitude') || exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" 
                                    class="alert" :class="totalWeight === 100 ? 'alert-success' : 'alert-danger'" role="alert">
                                    Total Bobot: {{ totalWeight }}
                                    <div v-if="totalWeight !== 100">
                                        Total bobot harus sama dengan 100!
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" v-if="!exam.title.toLowerCase().includes('attitude') && !exam.title.toLowerCase().includes('sikap') && !exam.title.toLowerCase().includes('akhlak')">
                                        <div class="mb-4">
                                            <label>Jawaban Benar</label>
                                            <select class="form-select" v-model="form.answer">
                                                <option value="">-- Pilih Jawaban Benar --</option>
                                                <option value="1">A</option>
                                                <option value="2">B</option>
                                                <option value="3">C</option>
                                                <option value="4">D</option>
                                                <option value="5">E</option>
                                            </select>
                                            <div v-if="errors.answer" class="alert alert-danger mt-2">{{ errors.answer }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label>Level Soal Ujian</label>
                                            <select class="form-select" v-model="form.level">
                                                <option value="">-- Pilih level soal --</option>
                                                <option value="Basic">Basic 🥉</option>
                                                <option value="Intermediate">Intermediate 🥈</option>
                                                <option value="Advanced">Advanced 🥇</option>
                                                <option value="Expert">Expert 💎</option>
                                            </select>
                                            <div v-if="errors.level" class="alert alert-danger mt-2">{{ errors.level }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rating Scale options -->
                            <div v-if="isRatingScale">
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

                            <button type="submit" class="btn btn-primary shadow-sm rounded-3 mt-3">SIMPAN</button>
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

//import components
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive, onMounted, ref, computed } from 'vue'  // Added computed here
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import Swal from 'sweetalert2'

export default {
    layout: LayoutAdmin,
    components: {
        Head,
        Link,
        QuillEditor,
    },
    props: {
        errors: Object,
        exam: Object,
    },

    // In the setup function, add the weight fields to the form
    setup(props) {
        const examType = props.exam.exam_type;
        
        const form = reactive({
            question: '',
            question_type: examType,
            option_1: null,
            option_2: null,
            option_3: null,
            option_4: null,
            option_5: null,
            option_1_weight: null,
            option_2_weight: null,
            option_3_weight: null,
            option_4_weight: null,
            option_5_weight: null,
            answer: null,
            level: null,
            rating_scale: examType === 'rating_scale' ? '6' : null
        });
    
        // Update submit function to include weights
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
            // Add weight validation before submit
            if ((props.exam.title.toLowerCase().includes('attitude') || 
                 props.exam.title.toLowerCase().includes('sikap') || 
                 props.exam.title.toLowerCase().includes('akhlak')) && 
                totalWeight.value !== 100) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Total bobot harus sama dengan 100!',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return;
            }

            const formData = {
                question: form.question,
                question_type: examType,
            };
    
            if (examType === 'multiple_choice') {
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
            } else {
                Object.assign(formData, {
                    option_1: null,
                    option_2: null,
                    option_3: null,
                    option_4: null,
                    option_5: null,
                    answer: null,
                    level: null,
                    rating_scale: '6'
                });
            }
    
            router.post(`/admin/exams/${props.exam.id}/questions/store`, formData, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Soal Ujian Berhasil Disimpan!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });
        };

        return {
            form,
            submit,
            isMultipleChoice: examType === 'multiple_choice',
            isRatingScale: examType === 'rating_scale',
            totalWeight
        };
    }
}
</script>

<style>
.ql-editor {
    min-height: 120px;
}

.ql-toolbar.ql-snow,
.ql-container.ql-snow {
    border: 1px solid #ced4da;
}

.rating-legend {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    margin-top: 10px;
}

.scale-description {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.scale-item {
    padding: 5px 10px;
    background-color: #f8f9fa;
    border-radius: 4px;
    font-size: 0.9rem;
}
</style>