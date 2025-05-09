<template>
    <Head>
        <title>History Ujian - Aplikasi Ujian Online</title>
    </Head>

    <div class="container-fluid mb-5 mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h5><i class="fa fa-history"></i> Riwayat Assessment</h5>
                    </div>
                </div>

                <!-- Card Layout untuk History -->
                <div class="row" v-if="filteredExams.length > 0">
                    <div class="col-md-4 mb-4" v-for="(data, index) in filteredExams" :key="index">
                        <div class="card border-0 shadow h-100">
                            <div class="card-header bg-light py-3">
                                <h6 class="mb-0 fw-bold">{{ data.exam_group.exam.title }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Sesi</small>
                                    <span class="fw-medium">{{ data.exam_group.exam_session.title }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Waktu Mulai</small>
                                    <span class="fw-medium">{{ data.exam_group.exam_session.start_time }}</span>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Waktu Selesai</small>
                                    <span class="fw-medium">{{ data.exam_group.exam_session.end_time }}</span>
                                </div>

                                <div class="mt-4 text-center">
                                    <span v-if="data.grade.end_time" 
                                          class="badge bg-success px-3 py-2">
                                        <i class="fa fa-check-circle me-1"></i> Sudah Dikerjakan
                                    </span>
                                    <span v-else 
                                          class="badge bg-danger px-3 py-2">
                                        <i class="fa fa-times-circle me-1"></i> Terlewat
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else>
                    <div class="alert alert-danger border-0 shadow">
                        <i class="fa fa-info-circle"></i> Tidak ada riwayat assessment
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutParticipant from '../../../Layouts/Participant.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

export default {
    layout: LayoutParticipant,
    components: {
        Head
    },
    props: {
        exam_groups: Array,
        auth: Object
    },
    setup(props) {
        const filteredExams = computed(() => {
            if (!props.exam_groups) return [];
            
            return props.exam_groups.filter(data => {
                if (!data.exam_group || !data.exam_group.exam_session) return false;
                
                const isCompleted = data.grade && data.grade.end_time !== null;
                const isExpired = new Date(data.exam_group.exam_session.end_time) < new Date();
                return isCompleted || isExpired;
            });
        });

        return {
            filteredExams
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

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.badge {
    font-size: 0.9rem;
}

.text-muted {
    font-size: 0.8rem;
}

.fw-medium {
    font-weight: 500;
}
</style>