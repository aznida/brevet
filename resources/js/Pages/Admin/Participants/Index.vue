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
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            v-model="search"
                                            class="form-control border-0 shadow" 
                                            placeholder="masukkan kata kunci dan enter..."
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
            <div class="col-2">
                <Link href="/admin/participants/export" class="btn btn-md btn-info border-0 shadow w-100 text-white"
                    type="button"><i class="fa fa-file-excel"></i>
                Export</Link>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <!-- <h5 class="mb-3"><i class="fa fa-filter"></i> Filter</h5> -->
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="form-label">TREG (Area)</label>
                                <select v-model="selectedArea" class="form-select" @change="handleFilter">
                                    <option value="">Semua TREG</option>
                                    <option v-for="area in areas" :key="area.id" :value="area.id">
                                        {{ area.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Witel</label>
                                <select v-model="selectedWitel" class="form-select" @change="handleFilter">
                                    <option value="">Semua Witel</option>
                                    <option v-for="witel in filteredWitels" :key="witel" :value="witel">
                                        {{ witel }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Job Role</label>
                                <select v-model="selectedRole" class="form-select" @change="handleFilter">
                                    <option value="">Semua Job Role</option>
                                    <option v-for="role in filteredRoles" :key="role" :value="role">
                                        {{ role }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2" v-if="hasActiveFilters">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">Active Filters:</span>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span v-if="selectedArea" class="badge bg-primary">
                                            TREG: {{ getAreaName(selectedArea) }}
                                            <button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" @click="clearAreaFilter"></button>
                                        </span>
                                        <span v-if="selectedWitel" class="badge bg-primary">
                                            Witel: {{ selectedWitel }}
                                            <button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" @click="clearWitelFilter"></button>
                                        </span>
                                        <span v-if="selectedRole" class="badge bg-primary">
                                            Job Role: {{ selectedRole }}
                                            <button type="button" class="btn-close btn-close-white ms-2" aria-label="Close" @click="clearRoleFilter"></button>
                                        </span>
                                        <button v-if="hasActiveFilters" @click="clearAllFilters" class="btn btn-sm btn-outline-secondary">
                                            Clear All
                                        </button>
                                    </div>
                                </div>
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
                                        <th class="border-0">Witel/Kota</th>
                                        <th class="border-0">Password</th>
                                        <th class="border-0">Role</th>
                                        <th class="border-0">TREG</th>
                                        <th class="border-0">Status</th>
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
                                        <td>{{ participant.witel }}</td>
                                        <td>{{ participant.decrypted_password }}</td>
                                        <td class="text-center">
                                            <span v-if="participant.role === 'Supervisor'" class="badge bg-danger">{{ participant.role }}</span>
                                            <span v-else>{{ participant.role }}</span>
                                        </td>
                                        <td>{{ participant.area.title }}</td>
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
                         
                        <!-- Replace with this improved container that matches PendingExams: -->
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                            <div class="d-flex align-items-center">
                                <span class="text-muted me-2">Items per page</span>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="perPageDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 70px;">
                                        {{ perPage }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="perPageDropdown">
                                        <li><a class="dropdown-item" href="#" @click.prevent="setPerPage(10)">10</a></li>
                                        <li><a class="dropdown-item" href="#" @click.prevent="setPerPage(25)">25</a></li>
                                        <li><a class="dropdown-item" href="#" @click.prevent="setPerPage(50)">50</a></li>
                                        <li><a class="dropdown-item" href="#" @click.prevent="setPerPage(100)">100</a></li>
                                    </ul>
                                </div>
                                <span class="ms-2">of {{ participants.total }} entries</span>
                            </div>
                            
                            <!-- Keep the pagination navigation buttons as they are -->
                            <div class="d-flex align-items-center">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item" :class="{ disabled: !participants.prev_page_url }">
                                            <a class="page-link" href="#" @click.prevent="goToPage(participants.current_page - 1)" aria-label="Previous">
                                                <span aria-hidden="true">« Previous</span>
                                            </a>
                                        </li>
                                        <li v-for="page in pageNumbers" :key="page" class="page-item" :class="{ active: page === participants.current_page }">
                                            <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                                        </li>
                                        <li class="page-item" :class="{ disabled: !participants.next_page_url }">
                                            <a class="page-link" href="#" @click.prevent="goToPage(participants.current_page + 1)" aria-label="Next">
                                                <span aria-hidden="true">Next »</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
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
    import { ref, computed, onMounted } from 'vue'; // Add computed import here
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
            areas: Array,
            witels: Array,
            roles: Array,
            filters: Object
        },
        setup(props) { // Add props parameter here
            const search = ref(props.filters?.q || '');
            const selectedArea = ref(props.filters?.area_id || ''); // Define selectedArea
            const selectedWitel = ref(props.filters?.witel || ''); // Define selectedWitel
            const selectedRole = ref(props.filters?.role || ''); // Define selectedRole
            const selectedParticipant = ref(null);
            const perPage = ref(props.filters?.per_page || '10');
            let modal = null;

            onMounted(() => {
                modal = new bootstrap.Modal(document.getElementById('detailModal'));
            });

            // Add these pagination functions
            const setPerPage = (value) => {
                perPage.value = value;
                router.get('/admin/participants', {
                    q: search.value,
                    area_id: selectedArea.value,
                    witel: selectedWitel.value,
                    role: selectedRole.value,
                    per_page: perPage.value,
                    page: 1 // Reset to page 1 when changing items per page
                });
            }

            const goToPage = (page) => {
                if (page < 1 || page > props.participants.last_page) return;
                router.get('/admin/participants', {
                    q: search.value,
                    area_id: selectedArea.value,
                    witel: selectedWitel.value,
                    role: selectedRole.value,
                    per_page: perPage.value,
                    page: page
                });
            }

            const pageNumbers = computed(() => {
                const currentPage = props.participants.current_page;
                const lastPage = props.participants.last_page;
                const delta = 2; // Number of pages to show before and after current page
                
                let pages = [];
                
                // Always include first page
                pages.push(1);
                
                // Calculate range of pages to show around current page
                const rangeStart = Math.max(2, currentPage - delta);
                const rangeEnd = Math.min(lastPage - 1, currentPage + delta);
                
                // Add ellipsis if there's a gap after page 1
                if (rangeStart > 2) {
                    pages.push('...');
                }
                
                // Add pages in the calculated range
                for (let i = rangeStart; i <= rangeEnd; i++) {
                    pages.push(i);
                }
                
                // Add ellipsis if there's a gap before last page
                if (rangeEnd < lastPage - 1) {
                    pages.push('...');
                }
                
                // Always include last page if it's different from first page
                if (lastPage > 1) {
                    pages.push(lastPage);
                }
                
                return pages;  
            });
    

            // Add filteredWitels computed property
            const filteredWitels = computed(() => {
                if (!selectedArea.value) {
                    return props.witels; // Return all witels if no area is selected
                }
                
                // Filter participants by the selected area_id and get their unique witels
                const witelsInArea = props.participants.data
                    .filter(participant => participant.area_id === parseInt(selectedArea.value) || 
                                          participant.area.id === parseInt(selectedArea.value))
                    .map(participant => participant.witel);
                
                // Remove duplicates
                return [...new Set(witelsInArea)].sort();
            });

            //add filter
            const filteredRoles = computed(() => {
                if (!selectedArea.value && !selectedWitel.value) {
                    return props.roles; // Return all roles if no area or witel is selected
                }
                
                // Filter participants based on selected filters
                const filteredParticipants = props.participants.data.filter(participant => {
                    let matchesArea = true;
                    let matchesWitel = true;
                    
                    if (selectedArea.value) {
                        matchesArea = (participant.area_id === parseInt(selectedArea.value) || 
                                      participant.area.id === parseInt(selectedArea.value));
                    }
                    
                    if (selectedWitel.value) {
                        matchesWitel = participant.witel === selectedWitel.value;
                    }
                    
                    return matchesArea && matchesWitel;
                });
                
                // Extract unique roles from filtered participants
                const rolesInFiltered = filteredParticipants
                    .map(participant => participant.role)
                    .filter(role => role); // Filter out null/undefined roles
                
                // Remove duplicates
                return [...new Set(rolesInFiltered)].sort();
            });

            const hasActiveFilters = computed(() => {
                return selectedArea.value || selectedWitel.value || selectedRole.value;
            });

            const getAreaName = (areaId) => {
                const area = props.areas.find(a => a.id === parseInt(areaId));
                return area ? area.title : '';
            };

            const clearAreaFilter = () => {
                selectedArea.value = '';
                selectedWitel.value = ''; // Also clear witel when area is cleared
                selectedRole.value = ''; // Also clear role when area is cleared
                handleFilter();
            };

            const clearWitelFilter = () => {
                selectedWitel.value = '';
                selectedRole.value = ''; // Also clear role when witel is cleared
                handleFilter();
            };

            const clearRoleFilter = () => {
                selectedRole.value = '';
                handleFilter();
            };

            const clearAllFilters = () => {
                selectedArea.value = '';
                selectedWitel.value = '';
                selectedRole.value = '';
                router.get('/admin/participants', {
                    q: search.value, // Omitting the filter parameters will clear them
                    per_page: perPage.value,
                    page: 1 // Reset to page 1 when clearing filters
                });
            };

            const handleFilter = () => {
                router.get('/admin/participants', {
                    q: search.value,
                    area_id: selectedArea.value,
                    witel: selectedWitel.value,
                    role: selectedRole.value,
                    per_page: perPage.value,
                    page: 1 // Reset to page 1 when filtering
                });
            }

            const showModal = (participant) => {
                selectedParticipant.value = participant;
                modal.show();
            }

            const handleSearch = () => {
                router.get('/admin/participants', {
                q: search.value,
                area_id: selectedArea.value,
                witel: selectedWitel.value,
                role: selectedRole.value,
                per_page: perPage.value,
                page: 1 // Reset to page 1 when searching
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
                formatTanggalIndonesia,
                //filter
                filteredRoles,
                filteredWitels, // Add filteredWitels to return
                selectedArea,
                selectedWitel,
                selectedRole,
                hasActiveFilters,
                getAreaName,
                clearAreaFilter,
                clearWitelFilter,
                clearRoleFilter,
                clearAllFilters,
                handleFilter,
                perPage,
                goToPage,
                setPerPage,
                pageNumbers
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
.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5em 0.75em;
}
.btn-close {
    font-size: 0.65em;
}
</style>
