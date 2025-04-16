<template>
    <Head>
        <title>Dashboard Partisipan - Aplikasi Ujian Online</title>
    </Head>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success border-0 shadow">
                Selamat Datang <strong>{{ auth.participant.name }}</strong>
            </div>
        </div>
    </div>
    <div class="row" v-if="exam_groups.length > 0">
        <div class="col-md-6" v-for="(data, index) in exam_groups" :key="index">
            <div class="card border-0 shadow">
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
                    
                    <!-- cek waktu selesai -->
                    <div v-if="data.grade.end_time == null">

                        <!-- cek apakah ujian sudah dimulai, tapi waktu masih ada -->
                        <div v-if="examTimeRangeChecker(data.exam_group.exam_session.start_time, data.exam_group.exam_session.end_time)">

                            <div v-if="data.grade.start_time == null">
                                <button @click="openRecordingModal(data.exam_group.id)" class="btn btn-md btn-success border-0 shadow w-100 mt-2 text-white">Kerjakan</button>
                                
                                <!-- Recording Confirmation Modal -->
                                <div class="modal fade" :id="'recordingModal'+data.exam_group.id" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title fw-bold">⚠️ PERINGATAN UJIAN!</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="alert alert-warning">
                                                    <p class="mb-2"><b>⚠️ Perhatian!</b></p>
                                                    <ul class="mb-0">
                                                        <li>Dilarang keras bekerja sama dalam bentuk apapun selama ujian berlangsung</li>
                                                        <li>Dilarang membuka tab baru atau mencari jawaban di Google</li>
                                                        <li>Konsekuensi pelanggaran: <b>DIBERHENTIKAN KONTRAK!</b></li>
                                                        <li>Sistem akan merekam <b>Layar, Camera Device</b> dan <b>Suara</b> melalui mikrofon selama ujian berlangsung</li>
                                                        <li>Jawaban perserta akan <b>otomatis disimpan</b>, jika ada kendala dengan device / jaringan dapat dilanjutkan kembali sesuai waktu yang telah ditentukan.</li>
                                                    </ul>
                                                </div>
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" type="checkbox" v-model="recordingConsent" :id="'consent'+data.exam_group.id">
                                                    <label class="form-check-label" :for="'consent'+data.exam_group.id">
                                                        Saya memahami dan menyetujui semua ketentuan di atas
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <Link 
                                                    v-if="recordingConsent"
                                                    :href="`/participant/exam-confirmation/${data.exam_group.id}`" 
                                                    class="btn btn-primary"
                                                    @click="closeModal(data.exam_group.id)"
                                                >OK</Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else>
                                <Link 
                                    :href="data.exam_group.exam.exam_type === 'ujian_pratik' 
                                        ? `/participant/exam-praktik-start/${data.exam_group.id}/`
                                        : `/participant/exam/${data.exam_group.id}/1`" 
                                    class="btn btn-md btn-info border-0 shadow w-100 mt-2">
                                    Lanjut Kerjakan
                                </Link>
                            </div>

                        </div>

                        <div v-else>

                            <!-- ujian belum mulai-->
                            <div v-if="examTimeStartChecker(data.exam_group.exam_session.start_time)">
                                <button class="btn btn-md btn-gray-700 border-0 shadow w-100 mt-2" disabled>Belum Mulai</button>
                            </div>

                            <!-- ujian terlewat -->
                            <div v-if="examTimeEndChecker(data.exam_group.exam_session.end_time)">
                                <button class="btn btn-md btn-danger border-0 shadow w-100 mt-2" disabled>Waktu Terlewat</button>
                            </div>

                        </div>

                    </div>

                    <div v-else>
                        <button class="btn btn-md btn-danger border-0 shadow w-100 mt-2" disabled>Sudah Dikerjakan</button>
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
    import { ref } from 'vue';

    export default {
        layout: LayoutParticipant,
        components: {
            Link,
        },
        props: {
            exam_groups: Array,
            auth: Object
        },
        setup() {
            const recordingConsent = ref(false);

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

            return {
                recordingConsent,
                openRecordingModal,
                closeModal
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