<template>
    <Head>
        <title>Ujian Praktik - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/technology/teh005.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M20.0381 4V10C20.0381 10.6 19.6381 11 19.0381 11H17.0381C16.4381 11 16.0381 10.6 16.0381 10V4C16.0381 2.9 16.9381 2 18.0381 2C19.1381 2 20.0381 2.9 20.0381 4ZM9.73808 18.9C10.7381 18.5 11.2381 17.3 10.8381 16.3L5.83808 3.29999C5.43808 2.29999 4.23808 1.80001 3.23808 2.20001C2.23808 2.60001 1.73809 3.79999 2.13809 4.79999L7.13809 17.8C7.43809 18.6 8.23808 19.1 9.03808 19.1C9.23808 19 9.53808 19 9.73808 18.9ZM19.0381 18H17.0381V20H19.0381V18Z" fill="currentColor"/>
                        <path d="M18.0381 6H4.03809C2.93809 6 2.03809 5.1 2.03809 4C2.03809 2.9 2.93809 2 4.03809 2H18.0381C19.1381 2 20.0381 2.9 20.0381 4C20.0381 5.1 19.1381 6 18.0381 6ZM4.03809 3C3.43809 3 3.03809 3.4 3.03809 4C3.03809 4.6 3.43809 5 4.03809 5C4.63809 5 5.03809 4.6 5.03809 4C5.03809 3.4 4.63809 3 4.03809 3ZM18.0381 3C17.4381 3 17.0381 3.4 17.0381 4C17.0381 4.6 17.4381 5 18.0381 5C18.6381 5 19.0381 4.6 19.0381 4C19.0381 3.4 18.6381 3 18.0381 3ZM12.0381 17V22H6.03809V17C6.03809 15.3 7.33809 14 9.03809 14C10.7381 14 12.0381 15.3 12.0381 17ZM9.03809 15.5C8.23809 15.5 7.53809 16.2 7.53809 17C7.53809 17.8 8.23809 18.5 9.03809 18.5C9.83809 18.5 10.5381 17.8 10.5381 17C10.5381 16.2 9.83809 15.5 9.03809 15.5ZM15.0381 15H17.0381V13H16.0381V8L14.0381 10V14C14.0381 14.6 14.4381 15 15.0381 15ZM19.0381 15H21.0381C21.6381 15 22.0381 14.6 22.0381 14V10L20.0381 8V13H19.0381V15ZM21.0381 20H15.0381V22H21.0381V20Z" fill="currentColor"/>
                        </svg>
                        </span>
                        <!--end::Svg Icon--> Form Penilaian Praktik</h5>
                    <div>
                        <VueCountdown :time="duration" @progress="handleChangeDuration" @end="showModalEndTimeExam = true" v-slot="{ days, hours, minutes, seconds }">
                            <span class="badge bg-info p-2">
                                <i class="fa fa-clock"></i> {{ days }} hari, {{ hours }} jam, {{ minutes }} menit, {{ seconds }} detik.
                            </span>
                        </VueCountdown>
                    </div>
                </div>
                <hr>
                <form @submit.prevent="submit">
                    <div class="table-responsive">
                        <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-dark">
                                <tr class="border-0">
                                    <th class="border-0" style="width: 5%">No.</th>
                                    <!-- <th class="border-0">id</th> -->
                                    <th class="border-0">Nama</th>
                                    <th class="border-0">TREG</th>
                                    <th class="border-0">Witel</th>
                                    <th class="border-0">Job Role</th>
                                    <th class="border-0">Nilai Praktik</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(participant, index) in filteredParticipants" :key="index">
                                    <tr>
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <!-- <td>{{ getGradeId(participant.id) }}</td> -->
                                        <td>{{ participant.name }}</td>
                                        <td>{{ participant.area.title }}</td>
                                        <td>{{ participant.witel }}</td>
                                        <td>{{ participant.role }}</td>
                                        <td>
                                            <template v-if="participant.role === 'Supervisor'">
                                                <span class="text-muted">Tidak diinput</span>
                                            </template>
                                            <template v-else>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    v-model="form.grades[participant.id]"
                                                    min="0"
                                                    max="100"
                                                    step="0.01"
                                                    required
                                                >
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="https://telkominfraco-my.sharepoint.com/:f:/g/personal/eko_wahyudi_tif_co_id/Eq_JZuwbnq1Nq683m-bTVU4BLIuAun6yzU8BYQYAYxRigw?e=zLvefU" class="btn btn-success btn-sm text-white p-2" target="_blank">
                            <!-- begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/files/fil013.svg-->
                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="21" height="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor"/>
                                <path d="M10.4 3.60001L12 6H21C21.6 6 22 6.4 22 7V19C22 19.6 21.6 20 21 20H3C2.4 20 2 19.6 2 19V4C2 3.4 2.4 3 3 3H9.2C9.7 3 10.2 3.20001 10.4 3.60001ZM16 12H13V9C13 8.4 12.6 8 12 8C11.4 8 11 8.4 11 9V12H8C7.4 12 7 12.4 7 13C7 13.6 7.4 14 8 14H11V17C11 17.6 11.4 18 12 18C12.6 18 13 17.6 13 17V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor"/>
                                <path opacity="0.3" d="M11 14H8C7.4 14 7 13.6 7 13C7 12.4 7.4 12 8 12H11V14ZM16 12H13V14H16C16.6 14 17 13.6 17 13C17 12.4 16.6 12 16 12Z" fill="currentColor"/>
                                </svg>
                                </span>
                                <!--end::Svg Icon -->
                            Upload Eviden</a>
                            <div class="ms-auto"><!-- Menambahkan margin-left:auto untuk mendorong tombol ke kanan -->
                            <button type="button" @click="saveDraft" class="btn btn-secondary">
                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen005.svg-->
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor"/>
                                    <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor"/>
                                    <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor"/>
                                    <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor"/>
                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                                    </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                Simpan Draft</button>
                            <button type="submit" class="btn btn-primary" style="margin-left:6px">
                                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen016.svg-->
                                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="currentColor"/>
                                <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="currentColor"/>
                                </svg>
                                </span>
                                <!--end::Svg Icon-->
                                Submit Nilai</button>
                            </div>
                    </div>
                    <div class="mt-3">
                        <div class="alert alert-warning">
                            <i class="fa fa-info-circle"></i> <strong>Catatan:</strong>
                            <ul>
                                <li>Nilai Praktik hanya dapat diinput oleh Supervisor.</li>
                                <li>Nilai Praktik tidak dapat diubah setelah disubmit.</li>
                                <li>Nilai Praktik tidak dapat dihapus setelah disubmit.</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add modal for exam end time -->
    <div v-if="showModalEndTimeExam" class="modal fade" :class="{ 'show': showModalEndTimeExam }" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="display:block;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Waktu Habis !</h5>
                </div>
                <div class="modal-body">
                    Waktu ujian sudah berakhir!. Klik <strong class="fw-bold">Ya</strong> untuk mengakhiri ujian.
                </div>
                <div class="modal-footer">
                    <button @click.prevent="endExam" type="button" class="btn btn-primary">Ya</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutParticipant from '../../../Layouts/Participant.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';
import VueCountdown from '@chenfengyuan/vue-countdown';
import axios from 'axios';

export default {
    layout: LayoutParticipant,
    
    components: {
        Head,
        VueCountdown
    },

    props: {
        exam_group: Object,
        grade: Object,
        participants: Array,
        grades: Array,
        draft_values: Object,
        duration: Object
    },

    setup(props) {
        const duration = ref(props.duration.duration);
        const showModalEndTimeExam = ref(false);
        const counter = ref(0);

        const handleChangeDuration = () => {
            if (duration.value <= 0) {
                showModalEndTimeExam.value = true;
                return;
            }

            duration.value = duration.value - 1000;
            counter.value = counter.value + 1;

            if (duration.value > 0 && counter.value % 10 == 1) {
                axios.put(`/participant/exam-praktik-duration/update/${props.duration.id}`, {
                    duration: duration.value
                });
            }
        };

        const endExam = () => {
            router.post('/participant/exam-end', {
                exam_group_id: props.exam_group.id,
                exam_id: props.exam_group.exam.id,
                exam_session_id: props.exam_group.exam_session.id,
            });

            Swal.fire({
                title: 'Success!',
                text: 'Ujian Selesai!.',
                icon: 'success',
                showConfirmButton: false,
                timer: 4000
            });
        };

        return {
            duration,
            handleChangeDuration,
            showModalEndTimeExam,
            endExam
        };
    },

    data() {
        return {
            form: {
                grades: {}
            }
        }
    },

    mounted() {
        if (this.participants) {
            this.participants.forEach(participant => {
                // Check for draft values first
                if (this.draft_values && this.draft_values[participant.id]) {
                    this.form.grades[participant.id] = this.draft_values[participant.id];
                } else {
                    // If no draft, check for submitted grades
                    const existingGrade = this.grades?.find(grade => 
                        grade.participant_id === participant.id && 
                        grade.exam_id === this.exam_group.exam_id &&
                        grade.exam_session_id === this.exam_group.exam_session_id
                    );
                    if (existingGrade) {
                        this.form.grades[participant.id] = existingGrade.grade;
                    }
                }
            });
        }
    },

    methods: {
        getGradeId(participantId) {
            const grade = this.grades?.find(grade => 
                grade.participant_id === participantId && 
                grade.exam_id === this.exam_group.exam_id &&
                grade.exam_session_id === this.exam_group.exam_session_id
            );
            return grade ? grade.id : '-';
        },
        saveDraft() {
            router.post(`/participant/exam-praktik-submit/${this.exam_group.id}`, {
                grades: this.form.grades,
                exam_type: 'ujian_pratik',
                is_draft: true
            }, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Draft nilai berhasil disimpan!',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        },

        submit() {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Nilai yang sudah disubmit tidak dapat diubah kembali!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Submit!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get grade ID for the logged-in user
                    const gradeId = this.getGradeId(this.exam_group.participant_id);

                    router.post(`/participant/exam-praktik-submit/${this.exam_group.id}`, {
                        grades: this.form.grades,
                        exam_type: 'ujian_pratik',
                        is_draft: false,
                        grade_id_to_delete: gradeId !== '-' ? gradeId : null
                    }, {
                        onSuccess: () => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Nilai berhasil disubmit!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        }
    },
    computed: {
        filteredParticipants() {
            const filtered = this.participants?.filter(p => 
                p.witel === this.exam_group?.participant?.witel
            ) || [];

            return filtered.sort((a, b) => {
                if (a.role === 'Supervisor') return -1;
                if (b.role === 'Supervisor') return 1;
                return 0;
            });
        }
    },
}
</script>