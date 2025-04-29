<template>
    <Head>
        <title>Partisipan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-10"> 
                <div class="row">
                    <div class="col-md-5 col-12 mb-2">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-2">
                                <Link href="/admin/participants/create" class="btn btn-md btn-primary border-0 shadow w-100"
                                    type="button"><i class="fa fa-plus-circle"></i>
                                Tambah</Link>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <Link href="/admin/participants/import" class="btn btn-md btn-success border-0 shadow w-100 text-white"
                                    type="button"><i class="fa fa-file-excel"></i>
                                Import</Link>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-12 mb-2">
                        <div class="row">
                            <div class="col-md-8 col-12 mb-2">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control border-0 shadow" placeholder="masukkan kata kunci dan enter...">
                                        <span class="input-group-text border-0 shadow">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <Link href="/admin/participants/export" class="btn btn-md btn-info border-0 shadow w-100 text-white"
                    type="button"><i class="fa fa-file-excel"></i>
                Export</Link>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <!-- <h4 class="mb-0 text-dark p-2 mb-2">Management Partisipants</h4> -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">NIK</th>
                                        <th class="border-0">Nama</th>
                                        <!-- <th class="border-0">Email</th> -->
                                        <!-- <th class="border-0">No. Hp</th> -->
                                        
                                        <th class="border-0">TREG</th>
                                        <th class="border-0">Witel/Kota</th>
                                        <th class="border-0">Status</th>
                                        <!-- <th class="border-0">Password</th> -->
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(participant, index) in participants.data" :key="index">
                                        <td class="fw-bold text-center">
                                            {{ ++index + (participants.current_page - 1) * participants.per_page }}</td>
                                        <td>{{ participant.nik }}</td>
                                        <td>{{ participant.name }}</td>
                                        <!-- <td>{{ participant.email }}</td> -->
                                        <!-- <td>{{ participant.hp }}</td> -->
                                        <td>{{ participant.area.title }}</td>
                                        <td>{{ participant.witel }}</td>
                                        <td class="text-center">
                                            <span v-if="participant.status === 'Aktif'" class="badge bg-success">{{ participant.status }}</span>
                                            <span v-else-if="participant.status === 'Block'" class="badge bg-danger">{{ participant.status }}</span>
                                            <span v-else>{{ participant.status }}</span>
                                        </td>
                                        <!-- <td>{{ participant.password }}</td> -->
                                        <td class="text-center">
                                            <button @click="showModal(participant)" class="btn btn-sm btn-success border-0 shadow me-2" type="button">
                                                <i class="fa fa-eye text-white"></i>
                                            </button>
                                            <Link :href="`/admin/participants/${participant.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button">
                                                <i class="fa fa-pencil-alt"></i>
                                            </Link>
                                            <button @click.prevent="destroy(participant.id)" class="btn btn-sm btn-danger border-0">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="participants.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog ">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold">Detail Partisipan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4 py-3" v-if="selectedParticipant">
                        <table class="table table-bordered mb-0">
                            <tr>
                                <td class="fw-bold bg-light" width="35%">NIK</td>
                                <td>{{ selectedParticipant.nik }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Nama</td>
                                <td>{{ selectedParticipant.name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Email</td>
                                <td>{{ selectedParticipant.email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">No. HP</td>
                                <td>{{ selectedParticipant.hp || '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">TREG</td>
                                <td>{{ selectedParticipant.area.title }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Witel/Kota</td>
                                <td>{{ selectedParticipant.witel }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Jenis Kelamin</td>
                                <td>{{ selectedParticipant.gender === 'P' ? 'Perempuan' : 'Laki-Laki' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Masa Kerja</td>
                                <td>{{ selectedParticipant.masa_kerja }} Tahun</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Tanggal Lahir</td>
                                <td>{{ formatTanggalIndonesia(selectedParticipant.tanggal_lahir) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Usia</td>
                                <td>{{ calculateAge(selectedParticipant.tanggal_lahir) }} Tahun</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Job Role</td>
                                <td>{{ selectedParticipant.role }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Status</td>
                                <td>
                                    <span v-if="selectedParticipant.status === 'Aktif'" class="badge bg-success">{{ selectedParticipant.status }}</span>
                                    <span v-else-if="selectedParticipant.status === 'Block'" class="badge bg-danger">{{ selectedParticipant.status }}</span>
                                    <span v-else>{{ selectedParticipant.status }}</span>
                                </td>
                            </tr>
                        </table>
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
    import { ref, onMounted } from 'vue';
    import Swal from 'sweetalert2';
    import { Head, Link, router } from '@inertiajs/vue3';

    export default {
        layout: LayoutAdmin,
        components: {
            Head,
            Link,
            Pagination
        },
        props: {
            participants: Object,
        },
        setup() {
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));
            const selectedParticipant = ref(null);
            let modal = null;

            onMounted(() => {
                modal = new bootstrap.Modal(document.getElementById('detailModal'));
            });

            const showModal = (participant) => {
                selectedParticipant.value = participant;
                modal.show();
            }

            const handleSearch = () => {
                router.get('/admin/participants', {
                    q: search.value,
                }); 
            }

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
                        router.delete(`/admin/participants/${id}`);
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Data Partisipan Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            const calculateAge = (birthDate) => {
                if (!birthDate) return '-';
                
                const today = new Date();
                const birth = new Date(birthDate);
                
                let age = today.getFullYear() - birth.getFullYear();
                const monthDiff = today.getMonth() - birth.getMonth();
                
                // Kurangi 1 tahun jika belum mencapai bulan & tanggal kelahiran
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                    age--;
                }
                
                return age;
            }

            const formatTanggalIndonesia = (tanggal) => {
                if (!tanggal) return '-';
                
                const bulanIndonesia = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                
                const date = new Date(tanggal);
                const tanggalStr = date.getDate().toString().padStart(2, '0');
                const bulan = bulanIndonesia[date.getMonth()];
                const tahun = date.getFullYear();
                
                return `${tanggalStr} ${bulan} ${tahun}`;
            }

            return {
                search,
                handleSearch,
                destroy,
                showModal,
                selectedParticipant,
                calculateAge,
                formatTanggalIndonesia  // Tambahkan ini
            }
        }
    }
</script>

<style>
.modal-dialog {
    max-width: 500px;
}
.table td {
    padding: 0.75rem;
    vertical-align: middle;
}
.modal-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #dee2e6;
}
.bg-light {
    background-color: #f8f9fa !important;
}
</style>
