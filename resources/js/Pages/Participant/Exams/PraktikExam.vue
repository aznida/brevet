<template>
    <Head>
        <title>Ujian Praktik - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5><i class="fa fa-edit"></i> Form Penilaian Praktik</h5>
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
                        <button type="button" @click="saveDraft" class="btn btn-secondary">Simpan Draft</button>
                        <button type="submit" class="btn btn-primary">Submit Nilai</button>
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