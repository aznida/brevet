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
                            
                            <!-- Ganti QuillEditor dengan TinyMCE Editor -->
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
                                <div v-if="errors.question" class="alert alert-danger mt-2">
                                    {{ errors.question }}
                                </div>
                            </div>

                            <!-- Multiple Choice options -->
                            <div v-if="isMultipleChoice">
                                <div class="mb-4">
                                    <label>Pilihan A</label>
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
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan A (0~100)</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            v-model="form.option_1_weight" 
                                            min="0" 
                                            max="100"
                                            @input="validateInput($event, 'option_1_weight')"
                                        />
                                        <div v-if="weightErrors.option_1_weight" class="text-danger mt-1">
                                            {{ weightErrors.option_1_weight }}
                                        </div>
                                    </div>
                                    <div v-if="errors.option_1" class="alert alert-danger mt-2">{{ errors.option_1 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan B</label>
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
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan B (0~100)</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            v-model="form.option_2_weight" 
                                            min="0" 
                                            max="100"
                                            @input="validateInput($event, 'option_2_weight')"
                                        />
                                        <div v-if="weightErrors.option_2_weight" class="text-danger mt-1">
                                            {{ weightErrors.option_2_weight }}
                                        </div>
                                    </div>
                                    <div v-if="errors.option_2" class="alert alert-danger mt-2">{{ errors.option_2 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan C</label>
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
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan C (0~100)</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            v-model="form.option_3_weight" 
                                            min="0" 
                                            max="100"
                                            @input="validateInput($event, 'option_3_weight')"
                                        />
                                        <div v-if="weightErrors.option_3_weight" class="text-danger mt-1">
                                            {{ weightErrors.option_3_weight }}
                                        </div>
                                    </div>
                                    <div v-if="errors.option_3" class="alert alert-danger mt-2">{{ errors.option_3 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan D</label>
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
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan D (0~100)</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            v-model="form.option_4_weight" 
                                            min="0" 
                                            max="100"
                                            @input="validateInput($event, 'option_4_weight')"
                                        />
                                        <div v-if="weightErrors.option_4_weight" class="text-danger mt-1">
                                            {{ weightErrors.option_4_weight }}
                                        </div>
                                    </div>
                                    <div v-if="errors.option_4" class="alert alert-danger mt-2">{{ errors.option_4 }}</div>
                                </div>
                                <div class="mb-4">
                                    <label>Pilihan E</label>
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
                                    <div v-if="exam.title.toLowerCase().includes('attitude')|| exam.title.toLowerCase().includes('sikap') || exam.title.toLowerCase().includes('akhlak')" class="mt-2">
                                        <label>Bobot Pilihan E (0~100)</label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            v-model="form.option_5_weight" 
                                            min="0" 
                                            max="100"
                                            @input="validateInput($event, 'option_5_weight')"
                                        />
                                        <div v-if="weightErrors.option_5_weight" class="text-danger mt-1">
                                            {{ weightErrors.option_5_weight }}
                                        </div>
                                    </div>
                                    <div v-if="errors.option_5" class="alert alert-danger mt-2">{{ errors.option_5 }}</div>
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
// Ganti import QuillEditor
// import { QuillEditor } from '@vueup/vue-quill'
// import '@vueup/vue-quill/dist/vue-quill.snow.css'

// Tambahkan import TinyMCE
import Editor from '@tinymce/tinymce-vue';
import Swal from 'sweetalert2'

export default {
    layout: LayoutAdmin,
    components: {
        Head,
        Link,
        // QuillEditor, // Hapus ini
        Editor, // Tambahkan ini
    },
    props: {
        errors: Object,
        exam: Object,
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
    // In the setup function, add the weight fields to the form
    setup(props) {
        const examType = props.exam.exam_type;
        const weightErrors = reactive({
            option_1_weight: null,
            option_2_weight: null,
            option_3_weight: null,
            option_4_weight: null,
            option_5_weight: null
        });
        
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

        const validateWeight = (weight) => {
            // Mengubah validasi untuk mengizinkan nilai 0
            if (weight === null || weight === '') {
                return 'Bobot harus diisi';
            }
            // Menggunakan Number untuk memastikan perbandingan numerik yang benar
            const numWeight = Number(weight);
            if (isNaN(numWeight) || numWeight < 0 || numWeight > 100) {
                return 'Bobot harus antara 0 sampai 100';
            }
            return null;
        };

        const validateInput = (event, field) => {
            // Mengubah validasi untuk mengizinkan nilai 0
            const value = event.target.value;
            
            if (value === null || value === '') {
                weightErrors[field] = 'Bobot harus diisi';
                form[field] = null;
                return;
            }

            const numValue = Number(value);
            if (numValue > 100) {
                weightErrors[field] = 'Nilai tidak boleh lebih dari 100';
                event.target.value = 100;
                form[field] = 100;
            } else if (numValue < 0) {
                weightErrors[field] = 'Nilai tidak boleh kurang dari 0';
                event.target.value = 0;
                form[field] = 0;
            } else {
                weightErrors[field] = null;
                form[field] = numValue;
            }
        };

        const submit = () => {
            if (props.exam.title.toLowerCase().includes('attitude') || 
                props.exam.title.toLowerCase().includes('sikap') || 
                props.exam.title.toLowerCase().includes('akhlak')) {
                
                let emptyWeights = [];
                
                // Mengubah pengecekan untuk mengizinkan nilai 0
                if (form.option_1_weight === null || form.option_1_weight === '') emptyWeights.push('A');
                if (form.option_2_weight === null || form.option_2_weight === '') emptyWeights.push('B');
                if (form.option_3_weight === null || form.option_3_weight === '') emptyWeights.push('C');
                if (form.option_4_weight === null || form.option_4_weight === '') emptyWeights.push('D');
                if (form.option_5_weight === null || form.option_5_weight === '') emptyWeights.push('E');

                if (emptyWeights.length > 0) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: `Bobot untuk pilihan ${emptyWeights.join(', ')} belum diisi!`,
                        icon: 'warning',
                        showConfirmButton: true
                    });
                    return;
                }

                // Validasi nilai bobot
                const weightErrors = {
                    option_1_weight: validateWeight(form.option_1_weight),
                    option_2_weight: validateWeight(form.option_2_weight),
                    option_3_weight: validateWeight(form.option_3_weight),
                    option_4_weight: validateWeight(form.option_4_weight),
                    option_5_weight: validateWeight(form.option_5_weight)
                };

                const hasErrors = Object.values(weightErrors).some(error => error !== null);
                
                if (hasErrors) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Mohon periksa kembali bobot nilai yang dimasukkan',
                        icon: 'error',
                        showConfirmButton: true
                    });
                    return;
                }
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
            validateInput,
            weightErrors,
            isMultipleChoice: examType === 'multiple_choice',
            isRatingScale: examType === 'rating_scale'
        };
    }
}
</script>

<style>
/* Hapus style QuillEditor */
/* .ql-editor {
    min-height: 120px;
}

.ql-toolbar.ql-snow,
.ql-container.ql-snow {
    border: 1px solid #ced4da;
} */

/* Tambahkan style TinyMCE jika diperlukan */
.tox-tinymce {
    border-radius: 0.25rem;
    border: 1px solid #ced4da !important;
}

/* Style lainnya tetap sama */
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