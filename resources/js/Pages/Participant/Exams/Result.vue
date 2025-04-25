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
</template>

<script>
    //import layout participant
    import LayoutParticipant from '../../../Layouts/Participant.vue';

    //import Head and Link from Inertia
    import {
        Head,
        Link
    } from '@inertiajs/vue3';

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
    }

</script>

<style>

</style>