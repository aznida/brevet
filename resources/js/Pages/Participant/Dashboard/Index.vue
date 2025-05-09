<template>
    <Head>
        <title>Dashboard Partisipan - Aplikasi Ujian Online</title>
    </Head>

    <!-- Alert Success dengan auto-hide -->
    <div v-if="showAlert" class="alert alert-primary alert-dismissible fade show border-0 shadow mb-3" role="alert">
        Persetujuan Perlindungan Data Pribadi (PDP) berhasil disimpan
        <button type="button" class="btn-close" @click="closeAlert" aria-label="Close"></button>
    </div>

    <!-- Modal Persetujuan Data -->
    <div class="modal fade" id="privacyModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">Persetujuan Penggunaan Data</h5>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning">
                        <p class="mb-2"><b>⚠️ Perhatian!</b></p>
                        <p>Sesuai dengan penerapan Persetujuan Pengguna berdasarkan UU PDP No. 27 Tahun 2022, semua pengolahan data peserta harus memiliki persetujuan aktif dari peserta yang disampaikan secara elektronik maupun non elektronik.</p>
                    </div>
                    <div class="mt-4">
                        <h6 class="fw-bold">Kebijakan Privasi:</h6>
                        <ul>
                            <li>Data Anda seperti <b><i>Nama lengkap, No.HP, Email, Gender, Tgl Lahir dan NIK</i></b> akan digunakan untuk keperluan pelaksanaan ujian</li>
                            <li>Data akan disimpan secara aman dan tidak akan dibagikan kepada pihak ketiga</li>
                            <li>Anda memiliki hak untuk mengakses dan memperbarui data Anda</li>
                        </ul>
                    </div>
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" v-model="privacyConsent" id="privacyCheck">
                        <label class="form-check-label" for="privacyCheck">
                            Saya <i><b>{{ auth.participant.name }}</b></i> menyetujui penggunaan data pribadi saya sesuai dengan ketentuan di atas
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        class="btn btn-primary" 
                        :disabled="!privacyConsent"
                        @click="acceptPrivacyPolicy"
                    >
                        Setuju dan Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success border-0 shadow">
                Selamat Datang <strong>{{ auth.participant.name }} 👋</strong>
            </div>
        </div>
    </div>
    <div class="row" v-if="filteredExams.length > 0">
        <div class="col-md-6" v-for="(data, index) in filteredExams" :key="index">
            <div class="card border-0 shadow mb-3">
                <div class="card-body">
                    <h5>{{ data.exam_group.exam.title }}</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead>
                                <tr>
                                    <td class="fw-bold">Kategori</td>
                                    <td>{{ data.exam_group.exam.category.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Area</td>
                                    <td>{{ data.exam_group.participant.area.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Sesi</td>
                                    <td>{{ data.exam_group.exam_session.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Mulai</td>
                                    <td>{{ data.exam_group.exam_session.start_time }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Selesai</td>
                                    <td>{{ data.exam_group.exam_session.end_time }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                    <!-- Tampilkan tombol berdasarkan status -->
                    <div v-if="data.grade.end_time == null">
                        <!-- Lanjut Kerjakan -->
                        <div v-if="examTimeRangeChecker(data.exam_group.exam_session.start_time, data.exam_group.exam_session.end_time) && data.grade.start_time">
                            <Link 
                                :href="data.exam_group.exam.exam_type === 'ujian_pratik' 
                                    ? `/participant/exam-praktik-start/${data.exam_group.id}/`
                                    : `/participant/exam/${data.exam_group.id}/1`" 
                                class="btn btn-md btn-info border-0 shadow w-100 mt-2">
                                Lanjut Kerjakan
                            </Link>
                        </div>

                        <!-- Belum Mulai -->
                        <div v-if="examTimeStartChecker(data.exam_group.exam_session.start_time)">
                            <button class="btn btn-md btn-gray-700 border-0 shadow w-100 mt-2" disabled>Belum Mulai</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-md-12">
            <div class="alert alert-danger border-0 shadow">
                <i class="fa fa-info-circle"></i> Tidak ada ujian yang tersedia
            </div>
        </div>
    </div>
</template>

<script>
    //import layout participant
    import LayoutParticipant from '../../../Layouts/Participant.vue';
    import { Link } from '@inertiajs/vue3';
    import { ref, computed, onMounted } from 'vue';
    import { router } from '@inertiajs/vue3';

    export default {
        layout: LayoutParticipant,
        components: {
            Link,
        },
        props: {
            exam_groups: Array,
            auth: Object
        },
        setup(props) {
            const recordingConsent = ref(false);
            const privacyConsent = ref(false);
            const showAlert = ref(false);

            const closeAlert = () => {
                showAlert.value = false;
            };

            const showAlertWithTimeout = () => {
                showAlert.value = true;
                setTimeout(() => {
                    showAlert.value = false;
                }, 7000); // 7 detik
            };

            onMounted(() => {
                // Cek status persetujuan dari database
                if (!props.auth?.participant?.PDP || props.auth.participant.PDP === 'false') {
                    setTimeout(() => {
                        const modalElement = document.getElementById('privacyModal');
                        if (modalElement) {
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();
                        } else {
                            console.error('Modal element tidak ditemukan');
                        }
                    }, 500);
                }
            });

            const acceptPrivacyPolicy = () => {
                router.post('/participant/accept-privacy', {}, {
                    onSuccess: () => {
                        const modalElement = document.getElementById('privacyModal');
                        if (modalElement) {
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            if (modal) {
                                modal.hide();
                                document.body.classList.remove('modal-open');
                                const backdrop = document.querySelector('.modal-backdrop');
                                if (backdrop) {
                                    backdrop.remove();
                                }
                                showAlertWithTimeout(); // Menggunakan fungsi baru
                                window.location.reload();
                            }
                        }
                    },
                    onError: (errors) => {
                        alert('Terjadi kesalahan saat menyimpan persetujuan. Silakan coba lagi.');
                        console.error('Error saat menyimpan:', errors);
                    }
                });
            };

            const openRecordingModal = (examGroupId) => {
                const modal = new bootstrap.Modal(document.getElementById('recordingModal' + examGroupId));
                modal.show();
            };

            const closeModal = (examGroupId) => {
                const modalElement = document.getElementById('recordingModal' + examGroupId);
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            };

            const filteredExams = computed(() => {
                if (!props.exam_groups) return [];
                
                return props.exam_groups.filter(data => {
                    if (!data.exam_group || !data.exam_group.exam_session) return false;
                    
                    const isNotCompleted = !data.grade.end_time;
                    const isBelumMulai = examTimeStartChecker(data.exam_group.exam_session.start_time);
                    const isLanjutKerjakan = examTimeRangeChecker(
                        data.exam_group.exam_session.start_time, 
                        data.exam_group.exam_session.end_time
                    ) && data.grade.start_time;
                    
                    return isNotCompleted && (isBelumMulai || isLanjutKerjakan);
                });
            });

            const examTimeStartChecker = (start_time) => {
                return new Date(start_time) > new Date();
            };

            const examTimeRangeChecker = (start_time, end_time) => {
                const now = new Date();
                const startDate = new Date(start_time);
                const endDate = new Date(end_time);
                return now >= startDate && now <= endDate;
            };

            return {
                recordingConsent,
                privacyConsent,
                openRecordingModal,
                closeModal,
                acceptPrivacyPolicy,
                showAlert,
                closeAlert,
                filteredExams,           // Add this line
                examTimeStartChecker,    // Add this line
                examTimeRangeChecker     // Add this line
            };
        }
    }
</script>

<style>
.modal-lg {
    max-width: 900px !important;
    width: 90% !important;
}

.modal-content {
    margin: 0 auto;
}
</style>