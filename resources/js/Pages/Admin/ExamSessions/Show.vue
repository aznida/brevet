<template>
    <Head>
        <title>Detail Sesi Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">

                <Link href="/admin/exam_sessions" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h5> <i class="fa fa-stopwatch"></i> Detail Sesi Ujian</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <tbody>
                                    <tr>
                                        <td style="width:30%" class="fw-bold">Nama Ujian</td>
                                        <td>{{ exam_session.exam.title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Kategori</td>
                                        <td>{{ exam_session.exam.category.title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Area</td>
                                        <td>{{ exam_session.exam.area.title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sesi</td>
                                        <td>{{ exam_session.title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Mulai</td>
                                        <td>{{ exam_session.start_time }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Selesai</td>
                                        <td>{{ exam_session.end_time }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>


                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5> <i class="fa fa-user-plus"></i> Enrolled Participant</h5>
                        <hr>
                        
                        <Link :href="`/admin/exam_sessions/${exam_session.id}/enrolled/create`" class="btn btn-md btn-primary border-0 shadow me-2" type="button"><i class="fa fa-user-plus"></i> Enrolled Participant</Link>
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Nama Partisipan</th>
                                        <th class="border-0">Area</th>
                                        <th class="border-0">Jenis Kelamin</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        
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
        Link
    } from '@inertiajs/vue3';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link,
        },

        //props
        props: {
            errors: Object,
            exam_session: Object,
        },

    }

</script>

<style>

</style>
