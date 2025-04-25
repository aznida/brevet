<template>
    <Head>
        <title>Sesi Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3 col-12 mb-2">
                        <Link href="/admin/exam_sessions/create" class="btn btn-md btn-primary border-0 shadow w-100" type="button"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</Link>
                    </div>
                    <div class="col-md-9 col-12 mb-2">
                        <form @submit.prevent="handleSearch">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 shadow" v-model="search" placeholder="masukkan kata kunci dan enter...">
                                <span class="input-group-text border-0 shadow">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-2 text-end">
                <button @click="sendNotifications" :class="['btn btn-md border-0 shadow w-100 text-white', isLoading ? 'btn-warning' : 'btn-success']" type="button" :disabled="isLoading">
                    <i :class="['fa', isLoading ? 'fa-spinner fa-spin' : 'fa-bell']"></i> 
                    {{ isLoading ? 'Sedang Proses Kirim Email...' : 'Notif ke Peserta' }}
                </button>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Ujian</th>
                                        <th class="border-0">Sesi</th>
                                        <th class="border-0">Partisipan</th>
                                        <th class="border-0">Mulai</th>
                                        <th class="border-0">Selesai</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(exam_session, index) in exam_sessions.data" :key="index">
                                        <td class="fw-bold text-center">{{ ++index + (exam_sessions.current_page - 1) * exam_sessions.per_page }}</td>
                                        <td>
                                            <strong class="fw-bold">{{ exam_session.exam.title }}</strong>
                                            <ul class="mt-2">
                                                <li>Area : <strong class="fw-bold">{{ exam_session.exam.area.title }}</strong></li>
                                                <li>Kategori : <strong class="fw-bold">{{ exam_session.exam.category.title }}</strong></li>
                                            </ul>
                                        </td>
                                        <td>{{ exam_session.title }}</td>
                                        <td class="text-center">{{ exam_session.exam_groups.length }}</td>
                                        <td>{{ exam_session.start_time }}</td>
                                        <td>{{ exam_session.end_time }}</td>
                                        <td class="text-center">
                                            <Link :href="`/admin/exam_sessions/${exam_session.id}`" class="btn btn-sm btn-primary border-0 shadow me-2" type="button"><i class="fa fa-plus-circle"></i></Link>
                                            <Link :href="`/admin/exam_sessions/${exam_session.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button"><i class="fa fa-pencil-alt"></i></Link>
                                            <button @click.prevent="destroy(exam_session.id)" class="btn btn-sm btn-danger border-0"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="exam_sessions.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

    //import sweet alert2
    import Swal from 'sweetalert2'; 

    //import Heade and Link from Inertia
    import {
        Head,
        Link,
        router
    } from '@inertiajs/vue3';

    //import ref from vue
    import {
        ref
    } from 'vue';

    export default {
        //layout
        layout: LayoutAdmin,

        //register component
        components: {
            Head,
            Link,
            Pagination
        },

        //props
        props: {
            exam_sessions: Object,
        },

        //inisialisasi composition API
        setup() {
            //define state loading
            const isLoading = ref(false);

            //define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));

            //define method search
            const handleSearch = () => {
                router.get('/admin/exam_sessions', {

                    //send params "q" with value from state "search"
                    q: search.value,
                });
            }


            //define method destroy
            const destroy = (id) => {
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

                        router.delete(`/admin/exam_sessions/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Sesi Ujian Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            //define method send notifications
            const sendNotifications = () => {
                Swal.fire({
                    title: 'Kirim Notifikasi',
                    text: "Apakah Anda yakin ingin mengirim notifikasi ke semua peserta?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kirim!',
                    cancelButtonText: 'Batal'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        isLoading.value = true;
                        
                        router.get('/admin/exam-sessions/send-notifications', {}, {
                            onSuccess: (page) => {
                                isLoading.value = false;
                                
                                // Debug untuk melihat isi response
                                console.log('Response:', page.props?.flash);
                                
                                // Periksa apakah ada flash message
                                const flash = page.props?.flash;
                                
                                if (flash && typeof flash === 'object') {
                                    if (flash.type === 'success') {  // Ubah pengecekan ke flash.type
                                        Swal.fire({
                                            title: '<div class="text-success"><strong>Berhasil!</strong></div>',
                                            html: `
                                                <div class="text-center">
                                                    <div class="mb-4">
                                                        <i class="fa fa-envelope-open-text text-success fa-4x mb-3"></i>
                                                        <div class="checkmark-circle">
                                                            <i class="fa fa-check text-white"></i>
                                                        </div>
                                                    </div>
                                                    <h4 class="mb-3">Email Terkirim!</h4>
                                                    <p class="mb-2">${flash.message}</p>
                                                    <small class="text-muted">Total: ${flash.details?.total} peserta | ${flash.details?.timestamp}</small>
                                                </div>
                                            `,
                                            icon: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showConfirmButton: false,
                                            customClass: {
                                                popup: 'animated bounceIn'
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: flash.message || 'Terjadi kesalahan saat mengirim notifikasi',
                                            icon: 'error',
                                            timer: 3000,
                                            showConfirmButton: false
                                        });
                                    }
                                }
                            },
                            onError: (error) => {
                                isLoading.value = false;
                                console.error('Error:', error);  // Tambahkan logging
                                Swal.fire({
                                    title: 'Error!',
                                    text: error?.message || 'Terjadi kesalahan saat mengirim notifikasi',
                                    icon: 'error',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            }

            return {
                search,
                handleSearch,
                destroy,
                sendNotifications,
                isLoading  // tambahkan isLoading ke return statement
            }
        }
    }

</script>

<style scoped>

.checkmark-circle {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 25px;
    height: 25px;
    background-color: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: -30px;
    margin-left: 30px;
}

.animated {
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

@keyframes bounceIn {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.05); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); opacity: 1; }
}

.bounceIn {
    animation-name: bounceIn;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.shake {
    animation-name: shake;
}
</style>