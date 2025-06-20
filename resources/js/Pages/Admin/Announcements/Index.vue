<template>
    <Head>
        <title>Pengumuman - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-10"> 
                <div class="row">
                    <div class="col-md-5 col-12 mb-2">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-2">
                                <Link href="/admin/announcements/create" class="btn btn-md btn-primary border-0 shadow w-100"
                                    type="button"><i class="fa fa-plus-circle"></i>
                                Tambah</Link>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-12 mb-2">
                        <div class="row">
                            <div class="col-md-8 col-12 mb-2">
                                <form @submit.prevent="searchData">
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            v-model="search"
                                            class="form-control border-0 shadow" 
                                            placeholder="cari berdasarkan judul pengumuman..."
                                        >
                                        <button 
                                            type="submit" 
                                            class="input-group-text border-0 shadow"
                                        >
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <th class="border-0">Judul</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Tanggal</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <!-- loading -->
                                    <tr v-if="announcements.data.length === 0">
                                        <td colspan="5" class="text-center">
                                            <div class="alert alert-warning mb-0">
                                                Data Belum Tersedia!
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(announcement, index) in announcements.data" :key="announcement.id">
                                        <td class="fw-bold text-center">{{ ++index + (announcements.current_page - 1) * announcements.per_page }}</td>
                                        <td>{{ announcement.title }}</td>
                                        <td>
                                            <span v-if="announcement.is_active" class="badge bg-success">Aktif</span>
                                            <span v-else class="badge bg-danger">Tidak Aktif</span>
                                        </td>
                                        <td>{{ formatTanggalIndonesia(announcement.created_at) }}</td>
                                        <td class="text-center">
                                            <button @click="showModal(announcement)" class="btn btn-sm btn-success border-0 shadow me-2" type="button">
                                                <i class="fa fa-eye text-white"></i>
                                            </button>
                                            <Link :href="`/admin/announcements/${announcement.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button">
                                                <i class="fa fa-pencil-alt"></i>
                                            </Link>
                                            <button @click.prevent="destroy(announcement.id)" class="btn btn-sm btn-danger border-0">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="announcements.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog modal-lg">  <!-- Menambahkan kelas modal-lg untuk memperlebar modal -->
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold">Detail Pengumuman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-4 py-3" v-if="selectedAnnouncement">
                        <table class="table table-bordered mb-0">
                            <tr>
                                <td class="fw-bold bg-light" width="20%">Judul</td>  <!-- Mengurangi lebar kolom pertama -->
                                <td style="word-wrap: break-word; white-space: normal;">{{ selectedAnnouncement.title }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Konten</td>
                                <td v-html="selectedAnnouncement.content" style="word-wrap: break-word; white-space: normal;"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Tanggal</td>
                                <td>{{ formatTanggalIndonesia(selectedAnnouncement.created_at) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold bg-light">Status</td>
                                <td>
                                    <span v-if="selectedAnnouncement.is_active" class="badge bg-success">Aktif</span>
                                    <span v-else class="badge bg-danger">Tidak Aktif</span>
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
            announcements: Object,
            filters: Object
        },
        setup(props) {
            const search = ref(props.filters?.q ?? '');
            const selectedAnnouncement = ref(null);
            let modal = null;

            onMounted(() => {
                modal = new bootstrap.Modal(document.getElementById('detailModal'));
            });

            const showModal = (announcement) => {
                selectedAnnouncement.value = announcement;
                modal.show();
            }

            const searchData = () => {
                router.get('/admin/announcements', {
                    q: search.value
                });
            }

            const destroy = (id) => {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Data Tidak Dapat Dikembalikan Setelah Dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.delete(`/admin/announcements/${id}`, {
                            onSuccess: () => {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Data Berhasil Dihapus!.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            }
                        });
                    }
                });
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
                searchData,
                destroy,
                showModal,
                selectedAnnouncement,
                formatTanggalIndonesia
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

</style>