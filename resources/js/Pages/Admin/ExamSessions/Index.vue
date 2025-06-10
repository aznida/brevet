<template>
    <Head>
        <title>Sesi Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <!-- Header Section -->
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3 col-12 mb-2">
                        <Link href="/admin/exam_sessions/create" class="btn btn-md btn-primary border-0 shadow w-100" type="button">
                            <i class="fa fa-plus-circle"></i> Tambah
                        </Link>
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
                <button @click="showParticipantModal" class="btn btn-md btn-success border-0 shadow w-100 text-white" type="button">
                    <i class="fa fa-bell"></i> Notif ke Peserta
                </button>
            </div>
        </div>

        <!-- Main Table Section -->
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
                                <tbody>
                                    <tr v-for="(exam_session, index) in exam_sessions.data" :key="index">
                                        <td class="fw-bold text-center">
                                            {{ ++index + (exam_sessions.current_page - 1) * exam_sessions.per_page }}
                                        </td>
                                        <td>
                                            <strong class="fw-bold">{{ exam_session.exam.title }}</strong>
                                            <ul class="mt-2 list-unstyled">
                                                <li>Area : <strong class="fw-bold">{{ exam_session.exam.area.title }}</strong></li>
                                                <li>Kategori : <strong class="fw-bold">{{ exam_session.exam.category.title }}</strong></li>
                                            </ul>
                                        </td>
                                        <td>{{ exam_session.title }}</td>
                                        <td class="text-center">{{ exam_session.exam_groups.length }}</td>
                                        <td>{{ exam_session.start_time }}</td>
                                        <td>{{ exam_session.end_time }}</td>
                                        <td class="text-center">
                                            <Link :href="`/admin/exam_sessions/${exam_session.id}`" class="btn btn-sm btn-primary border-0 shadow me-2" type="button">
                                                <i class="fa fa-plus-circle"></i>
                                            </Link>
                                            <Link :href="`/admin/exam_sessions/${exam_session.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button">
                                                <i class="fa fa-pencil-alt"></i>
                                            </Link>
                                            <button @click.prevent="destroy(exam_session.id)" class="btn btn-sm btn-danger border-0">
                                                <i class="fa fa-trash"></i>
                                            </button>
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

        <!-- Participant Modal -->
        <div class="modal fade" id="participantModal" tabindex="-1" aria-labelledby="participantModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="participantModalLabel">Pilih Peserta untuk Notifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Tambahkan form pencarian -->
                        <div class="mb-3">
                            <form @submit.prevent="handleParticipantSearch">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        class="form-control border-0 shadow" 
                                        v-model="participantSearch" 
                                        placeholder="masukkan kata kunci dan enter..."
                                    >
                                    <span class="input-group-text border-0 shadow">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0" style="width: 5%">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" v-model="selectAll" @change="toggleSelectAll">
                                            </div>
                                        </th>
                                        <th class="border-0">NAMA</th>
                                        <th class="border-0">NIK</th>
                                        <th class="border-0">WITEL</th>
                                        <th class="border-0">EMAIL</th>
                                        <th class="border-0">TREG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(group, index) in allUniqueParticipants" :key="index">
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                        v-model="selectedParticipants" 
                                                        :value="group.participant.id"
                                                        @change="checkSelection"> 
                                                </div>
                                            </td>
                                            <td>{{ group.participant.name }}</td>
                                            <td>{{ group.participant.nik }}</td>
                                            <td>{{ group.participant.witel }}</td>
                                            <td>{{ group.participant.email }}</td>
                                            <td>{{ group.participant.area?.title || '-' }}</td>
                                        </tr>
                                    </template>
                                    <tr v-if="!hasParticipants">
                                        <td colspan="5" class="text-center">Tidak ada peserta yang tersedia</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" @click="sendNotifications" :disabled="isLoading">
                            <i :class="['fa', isLoading ? 'fa-spinner fa-spin' : 'fa-paper-plane']"></i>
                            {{ isLoading ? 'Mengirim...' : 'Kirim Notifikasi' }}
                        </button>
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
//import Head and Link from Inertia
import { Head, Link, router } from '@inertiajs/vue3';
//import ref from vue
import { ref, computed } from 'vue';

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

    //composition API
    setup(props) {
        //define state loading
        const isLoading = ref(false);
        const selectedParticipants = ref([]);
        const selectAll = ref(false);
        const participantModal = ref(null);
        const participantSearch = ref('');  // Tambahkan ini

        //define state search
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        //define method search
        const handleSearch = () => {
            router.get('/admin/exam_sessions', {
                q: search.value,
            });
        }

        // Toggle select all participants
        const toggleSelectAll = () => {
            if (selectAll.value) {
                // Hanya ambil ID dari peserta yang terlihat setelah filter
                selectedParticipants.value = props.exam_sessions.data
                    .flatMap(session => 
                        filteredParticipants(session.exam_groups)
                            .filter(group => group.participant)
                            .map(group => group.participant.id)
                    );
            } else {
                selectedParticipants.value = [];
            }
        }

        // Show modal
        const showParticipantModal = () => {
            // Reset selection setiap kali modal dibuka
            selectedParticipants.value = [];
            selectAll.value = false;
            
            participantModal.value = new bootstrap.Modal(document.getElementById('participantModal'));
            participantModal.value.show();
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
            if (selectedParticipants.value.length === 0) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Silakan pilih peserta terlebih dahulu',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Pastikan kita hanya mengambil ID yang benar-benar dipilih
            const selectedIds = [...new Set(selectedParticipants.value)]; // Gunakan Set untuk menghilangkan duplikat
            
            Swal.fire({
                title: 'Kirim Notifikasi',
                text: `Apakah Anda yakin ingin mengirim notifikasi ke ${selectedIds.length} peserta terpilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    isLoading.value = true;
                    
                    // Kirim request dengan ID yang unik
                    router.post('/admin/exam-sessions/send-notifications', {
                        participant_ids: selectedIds  // Kirim hanya ID yang dipilih
                    }, {
                        onSuccess: (page) => {
                            isLoading.value = false;
                            participantModal.value.hide();
                            
                            // Reset pemilihan setelah berhasil
                            selectedParticipants.value = [];
                            selectAll.value = false;
                            
                            const flash = page.props?.flash;
                            
                            if (flash && typeof flash === 'object') {
                                if (flash.type === 'success') {
                                    // Buat daftar email yang gagal jika ada
                                    let failedEmailsList = '';
                                    if (flash.details.failed > 0 && flash.details.failed_emails && flash.details.failed_emails.length > 0) {
                                        // Jika ada lebih dari 3 email yang gagal, tampilkan 3 pertama dan tambahkan tombol untuk melihat semua
                                        const emailsToShow = flash.details.failed_emails.slice(0, 3);
                                        const hasMoreEmails = flash.details.failed_emails.length > 3;
                                        
                                        failedEmailsList = `
                                            <div class="mt-4 text-start">
                                                <p class="text-danger mb-2"><strong>Email yang gagal terkirim:</strong></p>
                                                <div class="failed-emails-list" style="max-height: 120px; overflow-y: auto; background-color: #f8f9fa; padding: 10px; border-radius: 4px; border-left: 3px solid #dc3545;">
                                                    ${emailsToShow.map(email => `<div class="text-danger py-1"><i class="fa fa-times-circle mr-1"></i> ${email}</div>`).join('')}
                                                    ${hasMoreEmails ? `<div class="mt-2 text-center text-secondary">...dan ${flash.details.failed_emails.length - 3} email lainnya</div>` : ''}
                                                </div>
                                                ${hasMoreEmails ? `<button id="showDetailFailedBtn" class="btn btn-sm btn-outline-danger mt-3 w-100" onclick="window.showFailedEmailsModal(${JSON.stringify(flash.details.failed_emails)})">Lihat Semua Email Gagal</button>` : ''}
                                            </div>
                                        `;
                                    }
                                
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
                                                <div class="mt-3">
                                                    <small class="text-muted">Waktu: ${flash.details.timestamp}</small>
                                                </div>
                                                <div class="mt-3 d-flex justify-content-center">
                                                    <div class="px-3 text-center">
                                                        <div class="h3 text-success">${flash.details.success}</div>
                                                        <div class="small">Berhasil</div>
                                                    </div>
                                                    ${flash.details.failed > 0 ? `
                                                    <div class="px-3 text-center">
                                                        <div class="h3 text-danger">${flash.details.failed}</div>
                                                        <div class="small">Gagal</div>
                                                    </div>` : ''}
                                                </div>
                                                ${failedEmailsList}
                                            </div>
                                        `,
                                        icon: false,
                                        timer: flash.details.failed > 0 ? 15000 : 5000, // Tampilkan lebih lama jika ada email yang gagal
                                        timerProgressBar: true,
                                        showConfirmButton: flash.details.failed > 0,
                                        confirmButtonText: 'Tutup',
                                        customClass: {
                                            popup: 'animated bounceIn'
                                        },
                                        didOpen: () => {
                                            // Tambahkan event listener untuk tombol detail
                                            const detailBtn = document.getElementById('showDetailFailedBtn');
                                            if (detailBtn) {
                                                detailBtn.addEventListener('click', () => {
                                                    window.showFailedEmailsModal(flash.details.failed_emails);
                                                });
                                            }
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
                            participantModal.value.hide();
                            
                            // Reset pemilihan jika terjadi error
                            selectedParticipants.value = [];
                            selectAll.value = false;
                            
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

        // Tambahkan method handleParticipantSearch
        const handleParticipantSearch = () => {
            // Filter akan otomatis terjadi karena kita menggunakan v-model
            return false;
        }

        // Fungsi untuk memfilter peserta dan menghilangkan duplikasi
        const filteredParticipants = (groups) => {
            if (!groups || groups.length === 0) return [];
            
            // Filter berdasarkan kata kunci pencarian
            const filtered = !participantSearch.value ? groups : groups.filter(group => {
                if (!group.participant) return false;
                
                const searchLower = participantSearch.value.toLowerCase();
                return (
                    String(group.participant.name || '').toLowerCase().includes(searchLower) ||
                    String(group.participant.nik || '').toLowerCase().includes(searchLower) ||
                    String(group.participant.email || '').toLowerCase().includes(searchLower) ||
                    String(group.participant.area?.title || '').toLowerCase().includes(searchLower)
                );
            });
            
            return filtered.filter(group => group.participant);
        };

        // Computed property untuk mendapatkan semua peserta unik dari semua grup
        const allUniqueParticipants = computed(() => {
            // Kumpulkan semua peserta dari semua sesi ujian
            const allParticipants = props.exam_sessions.data.flatMap(session => 
                filteredParticipants(session.exam_groups)
            );
            
            // Gunakan Map untuk menghilangkan duplikasi berdasarkan ID peserta
            const uniqueParticipantsMap = new Map();
            
            allParticipants.forEach(group => {
                if (group.participant && !uniqueParticipantsMap.has(group.participant.id)) {
                    uniqueParticipantsMap.set(group.participant.id, group);
                }
            });
            
            // Kembalikan array dari nilai Map (grup unik)
            return Array.from(uniqueParticipantsMap.values());
        });

        // Computed property untuk mengecek ketersediaan peserta
        const hasParticipants = computed(() => {
            return allUniqueParticipants.value.length > 0;
        });

        // Computed property untuk mengecek ketersediaan peserta setelah filter
        const hasFilteredParticipants = computed(() => {
            return props.exam_sessions.data.some(session => 
                filteredParticipants(session.exam_groups).some(group => group.participant)
            );
        });

        // Tambahkan Fungsi untuk Menampilkan Modal Detail Email Gagal
        
        // Tambahkan fungsi berikut di dalam setup function
        const showFailedEmailsModal = (failedEmails) => {
            Swal.fire({
                title: '<div class="text-danger"><i class="fa fa-exclamation-triangle mr-2"></i> Detail Email Gagal Terkirim</div>',
                html: `
                    <div class="failed-emails-detail">
                        <p class="text-center mb-3">Total: <strong>${failedEmails.length}</strong> email gagal terkirim</p>
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 10%" class="text-center">No</th>
                                    <th>Alamat Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${failedEmails.map((email, index) => `
                                    <tr>
                                        <td class="text-center">${index + 1}</td>
                                        <td class="text-danger">${email}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `,
                width: '600px',
                showConfirmButton: true,
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'animated fadeInUp'
                }
            });
        };
        
        // Tambahkan ini untuk membuat fungsi tersedia secara global
        window.showFailedEmailsModal = showFailedEmailsModal;
        
        return {
            search,
            handleSearch,
            destroy,
            sendNotifications,
            showParticipantModal,
            isLoading,
            selectedParticipants,
            selectAll,
            toggleSelectAll,
            hasParticipants,
            hasFilteredParticipants,
            filteredParticipants,
            participantSearch,
            handleParticipantSearch,
            allUniqueParticipants,
            showFailedEmailsModal  // Tambahkan fungsi ini
        }
    }
}

const checkSelection = () => {
    // Log untuk debugging
    console.log('Selected participants:', selectedParticipants.value);
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

/* Tambahkan di dalam <style> */
.failed-emails-list {
    font-family: monospace;
    font-size: 12px;
}

.failed-emails-detail {
    font-size: 14px;
}

/* Animasi untuk modal */
.animated {
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

.bounceIn {
    animation-name: bounceIn;
}

.fadeInUp {
    animation-name: fadeInUp;
}

@keyframes bounceIn {
    0%, 20%, 40%, 60%, 80%, 100% {
        transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
    }
    0% {
        opacity: 0;
        transform: scale3d(.3, .3, .3);
    }
    20% {
        transform: scale3d(1.1, 1.1, 1.1);
    }
    40% {
        transform: scale3d(.9, .9, .9);
    }
    60% {
        opacity: 1;
        transform: scale3d(1.03, 1.03, 1.03);
    }
    80% {
        transform: scale3d(.97, .97, .97);
    }
    100% {
        opacity: 1;
        transform: scale3d(1, 1, 1);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 100%, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
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
