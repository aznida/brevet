<template>
    <Head>
        <title>Detail Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">

                <Link href="/admin/exams" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h5> <i class="fa fa-edit"></i> Detail Ujian</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <tbody>
                                    <tr>
                                        <td style="width:30%" class="fw-bold">Nama Ujian</td>
                                        <td>{{ exam.title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Kategori Ujian</td>
                                        <td>{{ exam.category.title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Area</td>
                                        <td>{{ exam.area.title }}</td>
                                    </tr> 
                                    <tr>
                                        <td class="fw-bold">Tipe Ujian</td>
                                        <td>{{ 
                                            exam.exam_type === 'multiple_choice' ? 'Pilihan Ganda' : 
                                            exam.exam_type === 'rating_scale' ? 'Penilaian Skala' :
                                            exam.exam_type === 'ujian_pratik' ? 'Ujian Praktik' : ''
                                        }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Total Bank Soal</td>
                                        <td>{{ exam.questions.total }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jumlah soal ditampilkan</td>
                                        <td>{{ exam.showqty }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Durasi (Menit)</td>
                                        <td>{{ exam.duration }} Menit</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5> <i class="fa fa-question-circle"></i> Soal Ujian</h5>
                        <hr>
                        
                        <Link :href="`/admin/exams/${exam.id}/questions/create`" class="btn btn-md btn-primary border-0 shadow me-2" type="button"><i class="fa fa-plus-circle"></i> Tambah</Link>
                        <Link :href="`/admin/exams/${exam.id}/questions/import`" class="btn btn-md btn-success border-0 shadow text-white" type="button"><i class="fa fa-file-excel"></i> Import</Link>
                        
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Soal</th>
                                        <th class="border-0 rounded-end" style="width:10%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(question, index) in exam.questions.data" :key="index">
                                        <td class="fw-bold text-center">{{ ++index + (exam.questions.current_page - 1) * exam.questions.per_page }}</td>
                                        <td style="min-width: 200px; max-width: 70%; white-space: normal; word-wrap: break-word;">
                                            <div class="fw-bold" v-html="question.question"></div>
                                            <!-- Multiple Choice Options -->
                                            <template v-if="exam.exam_type === 'multiple_choice'">
                                                <hr>
                                                <ol type="A">
                                                    <li>
                                                        <span v-html="question.option_1" :class="{ 'text-success fw-bold fst-italic': isCorrectAnswer(question, 'A') || isHighestWeight(question, question.option_1_weight) }"></span>
                                                        <span v-if="isAttitudeExam(exam.title)" 
                                                            :class="{ 'text-success fw-bold fst-italic': isHighestWeight(question, question.option_1_weight) }" 
                                                            class="ms-2">
                                                            (Bobot: <b>{{ Math.floor(question.option_1_weight) }}</b>)
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span v-html="question.option_2" :class="{ 'text-success fw-bold fst-italic': isCorrectAnswer(question, 'B') || isHighestWeight(question, question.option_2_weight) }"></span>
                                                        <span v-if="isAttitudeExam(exam.title)" 
                                                            :class="{ 'text-success fw-bold fst-italic': isHighestWeight(question, question.option_2_weight) }" 
                                                            class="ms-2">
                                                            (Bobot: <b>{{ Math.floor(question.option_2_weight) }}</b>)
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span v-html="question.option_3" :class="{ 'text-success fw-bold fst-italic': isCorrectAnswer(question, 'C') || isHighestWeight(question, question.option_3_weight) }"></span>
                                                        <span v-if="isAttitudeExam(exam.title)" 
                                                            :class="{ 'text-success fw-bold fst-italic': isHighestWeight(question, question.option_3_weight) }" 
                                                            class="ms-2">
                                                            (Bobot: <b>{{ Math.floor(question.option_3_weight) }}</b>)
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span v-html="question.option_4" :class="{ 'text-success fw-bold fst-italic': isCorrectAnswer(question, 'D') || isHighestWeight(question, question.option_4_weight) }"></span>
                                                        <span v-if="isAttitudeExam(exam.title)" 
                                                            :class="{ 'text-success fw-bold fst-italic': isHighestWeight(question, question.option_4_weight) }" 
                                                            class="ms-2">
                                                            (Bobot: <b>{{ Math.floor(question.option_4_weight) }}</b>)
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span v-html="question.option_5" :class="{ 'text-success fw-bold fst-italic': isCorrectAnswer(question, 'E') || isHighestWeight(question, question.option_5_weight) }"></span>
                                                        <span v-if="isAttitudeExam(exam.title)" 
                                                            :class="{ 'text-success fw-bold fst-italic': isHighestWeight(question, question.option_5_weight) }" 
                                                            class="ms-2">
                                                            (Bobot: <b>{{ Math.floor(question.option_5_weight) }}</b>)
                                                        </span>
                                                    </li>
                                                </ol>
                                                <div class="mt-2">
                                                    <i><b style="font-size:14px">Level Soal : </b> 
                                                        <span v-if="question.level === 'Basic'" class="badge bg-info p-2">Basic 🔥</span>
                                                        <span v-else-if="question.level === 'Intermediate'" class="badge bg-warning p-2">Intermediate 🔥🔥</span>
                                                        <span v-else-if="question.level === 'Advanced'" class="badge bg-success p-2">Advanced 🔥🔥🔥</span>
                                                        <span v-else-if="question.level === 'Expert'" class="badge bg-danger p-2">Expert 💎</span>
                                                        <span v-else style="color:danger; font-size:14px"><b>Belum ada Level</b></span>
                                                    </i>
                                                </div>
                                                <div class="mt-2">
    <small>Debug - Answer: {{ question.answer }}</small>
</div>
                                            </template>
                                            <!-- Rating Scale Info -->
                                            <template v-else>
                                                <div class="mt-2 text-muted">
                                                    <small>(Skala 1-6)</small>
                                                </div>
                                            </template>
                                        </td>
                                        <td class="text-center">
                                            <Link :href="`/admin/exams/${exam.id}/questions/${question.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2"
                                                type="button"><i class="fa fa-pencil-alt"></i></Link>
                                            <button @click.prevent="destroy(exam.id, question.id)" class="btn btn-sm btn-danger border-0"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="exam.questions.links" align="end" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';
    import Pagination from '../../../Components/Pagination.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import Swal from 'sweetalert2';

    export default {
        layout: LayoutAdmin,
        
        components: {
            Head,
            Link,
            Pagination
        },

        props: {
            errors: Object,
            exam: Object,
        },

        setup() {
            const isAttitudeExam = (title) => {
                if (!title) return false;
                const lowerTitle = title.toLowerCase();
                return lowerTitle.includes('attitude') || 
                       lowerTitle.includes('sikap') || 
                       lowerTitle.includes('akhlak');
            };

            const getTotalWeight = (question) => {
                return Math.floor(
                    Number(question.option_1_weight || 0) +
                    Number(question.option_2_weight || 0) +
                    Number(question.option_3_weight || 0) +
                    Number(question.option_4_weight || 0) +
                    Number(question.option_5_weight || 0)
                );
            };

            const destroy = (exam_id, question_id) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        router.delete(`/admin/exams/${exam_id}/questions/${question_id}/destroy`);
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Soal Ujian Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                });
            };

            const isHighestWeight = (question, weight) => {
                if (!weight) return false;
                const weights = [
                    Number(question.option_1_weight || 0),
                    Number(question.option_2_weight || 0),
                    Number(question.option_3_weight || 0),
                    Number(question.option_4_weight || 0),
                    Number(question.option_5_weight || 0)
                ];
                return Number(weight) === Math.max(...weights);
            };

            const isCorrectAnswer = (question, optionLetter) => {
                if (!question.answer) return false;
                
                // Konversi huruf A-E menjadi angka 1-5
                const letterToNumber = {
                    'A': 1,  // Ubah menjadi number, bukan string
                    'B': 2,
                    'C': 3,
                    'D': 4,
                    'E': 5
                };
                
                // Bandingkan dengan jawaban yang tersimpan di database
                // Konversi question.answer ke number untuk memastikan perbandingan yang benar
                return Number(question.answer) === letterToNumber[optionLetter];
            };
        
            return {
                destroy,
                isAttitudeExam,
                getTotalWeight,
                isHighestWeight,
                isCorrectAnswer
            };
        }
    };
</script>

<style>

</style>