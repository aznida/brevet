<template>
    <Head>
        <title>Hasil Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5> <i class="fa fa-check-circle"></i> Ujian Selesai</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead>
                                <tr>
                                    <td class="fw-bold">NIK</td>
                                    <td>{{ exam_group.participant.nik }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Nama Lengkap</td>
                                    <td>{{ exam_group.participant.name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Area</td>
                                    <td>{{ exam_group.participant.area.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Witel</td>
                                    <td>{{ exam_group.participant.witel }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Job Role</td>
                                    <td>{{ exam_group.participant.role }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Ujian</td>
                                    <td>{{ exam_group.exam.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kategori</td>
                                    <td>{{ exam_group.exam.category.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Mulai Mengerjakan</td>
                                    <td>{{ grade.start_time }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Selesai Mengerjakan</td>
                                    <td>{{  grade.end_time  }}</td>
                                </tr>
                            </thead>
                            <tbody v-if="exam_group.exam.show_answer == 'Y'">
                                <tr v-if="!exam_group.exam.category.title.toLowerCase().includes('attitude') && 
                                        !exam_group.exam.category.title.toLowerCase().includes('sikap') && 
                                        !exam_group.exam.category.title.toLowerCase().includes('akhlak')">
                                    <td class="fw-bold">Jumlah Benar</td>
                                    <td>{{ grade.total_correct }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Nilai</td>
                                    <td>{{ grade.grade }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div>
            <div class="text-center mt-3">
                <Link 
                    href="/participant/dashboard" 
                    class="btn btn-md btn-primary shadow-sm"
                >
                    <i class="fa fa-arrow-left me-2"></i> Kembali ke Dashboard
                </Link>
            </div>
        </div>
    </div>

    <!-- Modal Feedback Kuesioner -->
    <div class="modal fade" id="feedbackModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="feedbackModalLabel">Feedback Aplikasi</h5>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-4">Terima kasih telah menyelesaikan penilaian sikap. Mohon berikan feedback Anda:</p>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">1. Seberapa puas Anda menggunakan aplikasi?</label>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tidak Puas</span>
                            <span>Sangat Puas</span>
                        </div>
                        <div class="rating-container d-flex justify-content-between">
                            <div v-for="n in 5" :key="n" class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    :id="'satisfaction-'+n" 
                                    :value="n" 
                                    v-model="feedback.satisfaction_rating"
                                    name="satisfaction"
                                >
                                <label class="form-check-label" :for="'satisfaction-'+n">{{ n }}</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">2. Seberapa sesuai soal yang Anda kerjakan dengan pekerjaan saat ini?</label>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tidak Sesuai</span>
                            <span>Sangat Sesuai</span>
                        </div>
                        <div class="rating-container d-flex justify-content-between">
                            <div v-for="n in 5" :key="n" class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    :id="'relevance-'+n" 
                                    :value="n" 
                                    v-model="feedback.relevance_rating"
                                    name="relevance"
                                >
                                <label class="form-check-label" :for="'relevance-'+n">{{ n }}</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="comments" class="form-label fw-bold">3. Berikan feedback Anda terhadap aplikasi ini:</label>
                        <textarea 
                            class="form-control" 
                            id="comments" 
                            v-model="feedback.comments" 
                            rows="3"
                            placeholder="Tulis feedback Anda di sini..."
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        @click="submitFeedback"
                        :disabled="!isFormValid"
                    >
                        Kirim Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout participant
    import LayoutParticipant from '../../../Layouts/Participant.vue';

    //import Head and Link from Inertia
    import {
        Head,
        Link,
        useForm
    } from '@inertiajs/vue3';
    
    //import axios
    // import axios from 'axios'; // Remove this line
    
    //import reactive, ref, onMounted
    import { reactive, ref, computed, onMounted } from 'vue';
    import Swal from 'sweetalert2'; // Add this line to import SweetAlert2

    export default {
        //layout
        layout: LayoutParticipant,

        //register components
        components: {
            Head,
            Link
        },

        //props
        props: {
            exam_group: Object,
            grade: Object
        },
        
        setup(props) {
            // Feedback form data
            const feedback = useForm({
                exam_session_id: props.exam_group.exam_session.id,
                participant_id: props.exam_group.participant.id,
                satisfaction_rating: null,
                relevance_rating: null,
                comments: ''
            });
            
            // Check if form is valid
            // Update the isFormValid computed property to match the form field names
            const isFormValid = computed(() => {
                return feedback.satisfaction_rating !== null && 
                       feedback.relevance_rating !== null && 
                       feedback.comments.trim() !== '';
            });
            
            // Check if this is an attitude assessment
            const isAttitudeAssessment = computed(() => {
                const categoryTitle = props.exam_group?.exam?.category?.title?.toLowerCase() || '';
                return categoryTitle.includes('attitude') || 
                       categoryTitle.includes('sikap') || 
                       categoryTitle.includes('akhlak');
            });
            
            // Submit feedback
            const submitFeedback = async () => {
                try {
                    feedback.post('/participant/feedback', {
                        onSuccess: () => {
                            // Close modal
                            const modal = document.getElementById('feedbackModal');
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            modalInstance.hide();
                            
                            // Set a flag in localStorage to indicate feedback has been submitted
                            localStorage.setItem(`feedback_submitted_${props.exam_group.exam_session.id}_${props.exam_group.participant.id}`, 'true');

                            // Show success message with Swal
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Terima kasih atas feedback Anda!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        },
                        onError: (errors) => {
                            console.error('Error submitting feedback:', errors);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.',
                            });
                        }
                    });
                    
                } catch (error) {
                    console.error('Error submitting feedback:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.',
                    });
                }
            };
            
            // Show modal on mount if this is an attitude assessment
            onMounted(() => {
                const feedbackSubmitted = localStorage.getItem(`feedback_submitted_${props.exam_group.exam_session.id}_${props.exam_group.participant.id}`);

                if (isAttitudeAssessment.value && !feedbackSubmitted) {
                    // Tunggu notifikasi "Ujian Selesai" hilang (4000ms + 500ms buffer)
                    setTimeout(() => {
                        const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
                        modal.show();
                    }, 4200); // 4.5 detik
                }
            });
            
            return {
                feedback,
                isFormValid,
                submitFeedback,
                isAttitudeAssessment
            };
        }
    }
</script>

<style>
.rating-container {
    width: 100%;
}

.form-check {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-check-input[type="radio"] {
    margin-left: 0;
    margin-right: 0;
}
</style>