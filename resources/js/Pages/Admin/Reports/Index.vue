<template>
    <Head>
        <title>Laporan Hasil Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h5><i class="fa fa-filter"></i> Filter Hasil Assement Online</h5>
                        <hr>
                        <form @submit.prevent="filter">
                            
                            <div class="row">
                                <div class="col-md-9">
                                    <label class="control-label" for="name">Assesment</label>
                                    <select class="form-select" v-model="form.exam_id">
                                        <option v-for="(exam, index) in exams" :key="index" :value="exam.id">{{ exam.title }} — Area : {{ exam.area.title }} — Kategori : {{ exam.category.title }}</option>
                                    </select>
                                    <div v-if="errors.exam_id" class="alert alert-danger mt-2">
                                        {{ errors.exam_id }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-white">*</label>
                                    <button type="submit" class="btn btn-md btn-primary border-0 shadow w-100"> <i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <div v-if="grades.length > 0" class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <h5 class="mt-2"><i class="fa fa-chart-line"></i> Laporan Hasil Assement Online</h5>
                            </div>
                            <div class="col-md-3 col-12">
                                <a :href="`/admin/reports/export?exam_id=${form.exam_id}`" target="_blank" class="btn btn-success btn-md border-0 shadow w-100 text-white"><i class="fa fa-file-excel"></i> DOWNLOAD EXCEL</a>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Nama Partisipan</th>
                                        <th class="border-0">Witel</th>
                                        <th class="border-0">Ujian</th>
                                        <th class="border-0">Sesi</th>
                                        <th class="border-0">Area Ujian</th>
                                        <!-- <th class="border-0">Kategori</th> -->
                                        <th class="border-0">Hasil</th>
                                        <th class="border-0">Level Stream</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(grade, index) in filteredGrades" :key="grade.id">
                                        <td class="fw-bold text-center">
                                            {{ index + 1 }}
                                        </td>
                                        <td>{{ grade.participant.name }}</td>
                                        <td>{{ grade.participant.witel }}</td>
                                        <td>{{ grade.exam.title }}</td>
                                        <td>{{ grade.exam_session.title }}</td>
                                        <td class="text-center">{{ grade.exam.area.title }}</td>
                                        <!-- <td>{{ grade.exam.category.title }}</td> -->
                                        <td class="fw-bold text-center">{{ grade.grade }}</td>
                                        <td class="fw-bold text-center">
                                            <span v-if="grade.grade >= 0 && grade.grade <= 30">Starter 🌱</span>
                                            <span v-else-if="grade.grade >= 31 && grade.grade <= 60">Basic 🥉</span>
                                            <span v-else-if="grade.grade >= 61 && grade.grade <= 70">Intermediate 🥈</span>
                                            <span v-else-if="grade.grade >= 71 && grade.grade <= 90">Advanced 🥇</span>
                                            <span v-else-if="grade.grade >= 91 && grade.grade <= 100">Expert 💎</span>
                                        </td>
                                    </tr>
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
    //import layout Admin
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import Head from Inertia
    import {
        Head,
        router
    } from '@inertiajs/vue3';

    //import reactive from vue
    import { reactive } from 'vue';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
        },

        //props
        props: {
            errors: Object,
            exams: Array,
            grades: Array,
        },

        computed: {
            filteredGrades() {
                return this.grades.filter(grade => {
                    // For practical exam type
                    if (grade.exam.category.title === 'Assesment Praktik') {
                        return grade.grade > 0;
                    }
                    // For other exam types
                    return true;
                });
            }
        },

        //inisialisasi composition API
        setup() {

            //define state
            const form = reactive({
                'exam_id': '' || (new URL(document.location)).searchParams.get('exam_id'),
            });

             //define methods filter
            const filter = () => {

                //HTTP request
                router.get('/admin/reports/filter', {

                    //send data to server
                    exam_id: form.exam_id,
                });

            }

            //return
            return {
                form,
                filter
            }

        }

    }

</script>

<style>

</style>