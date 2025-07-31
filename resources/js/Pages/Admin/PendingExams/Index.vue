<template>
    <Head>
        <title>Status Ujian Partisipan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 col-12 mb-2">
                        <form>
                            <div class="input-group">
                                <input v-model="search" type="text" class="form-control border-0 shadow" 
                                    placeholder="masukkan kata kunci dan enter..." @keypress.enter.prevent="handleSearch">
                                <span class="input-group-text border-0 shadow">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button @click="exportToExcel" class="btn btn-success float-end text-white">
                    <i class="fa fa-file-excel me-2"></i>Download Excel
                </button>
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
        
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">NIK</th>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">TREG</th>
                                        <th class="border-0">Witel</th>
                                        <th class="border-0">Usia</th>
                                        <th class="border-0">Masa Kerja</th>
                                        <th class="border-0">Job Role</th>
                                        <th v-for="category in categories" :key="category.id" class="border-0">
                                            {{ category.title }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(participant, index) in participants.data" :key="participant.id">
                                        <td class="text-center">{{ ++index + (participants.current_page-1) * participants.per_page }}</td>
                                        <td>{{ participant.nik }}</td>
                                        <td>{{ participant.name }}</td>
                                        <td>{{ participant.area.title }}</td>
                                        <td>{{ participant.witel }}</td>
                                        <td>{{ calculateAge(participant.tanggal_lahir) }} Tahun</td>
                                        <td>{{ participant.masa_kerja }} Tahun</td>
                                        <td class="text-center">
                                            <span v-if="participant.role === 'Teknisi'" class="badge bg-success">
                                                {{ participant.role }}
                                            </span>
                                            <span v-else-if="participant.role === 'Supervisor'" class="badge bg-warning">
                                                {{ participant.role }}
                                            </span>
                                            <span v-else>
                                                {{ participant.role }}
                                            </span>
                                        </td>
                                        <td v-for="category in categories" :key="category.id" class="text-center">
                                            {{ getExamStatus(participant, category.title) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Replace your current pagination section with this exact match to the reference image -->
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
                            
                            <!-- Pagination navigation buttons -->
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
                        <!-- Remove the card-footer with the duplicate pagination -->
                        <!-- <div class="card-footer bg-white">
                            <Pagination 
                                :links="participants.links" 
                                align="center" 
                                :show-per-page="true"
                                :filters="filters"
                            />
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import Pagination from '../../../Components/Pagination.vue';
import { ref, computed } from 'vue';
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
        categories: Array,
        areas: Array,
        witels: Array,
        roles: Array,
        filters: Object
    },

    setup(props) {
        const search = ref(props.filters.q || '');
        const selectedArea = ref(props.filters.area_id || '');
        const selectedWitel = ref(props.filters.witel || '');
        const selectedRole = ref(props.filters.role || '');
        const perPage = ref(props.filters.per_page || '10');


        // Add a computed property to filter witels based on selected area
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

        // Add a computed property to filter roles based on selected area and witel
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
            //handleFilter();
            router.get('/admin/pending-exams', {
                q: search.value, // Omitting the filter parameters will clear them
                page: 1 // Reset to page 1 when clearing filters
            });
        };

        const exportToExcel = async () => {
            try {
                // Fetch all records with current filters
                const response = await fetch(`/admin/pending-exams/export?q=${encodeURIComponent(search.value)}&area_id=${encodeURIComponent(selectedArea.value)}&witel=${encodeURIComponent(selectedWitel.value)}&role=${encodeURIComponent(selectedRole.value)}`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                // Create CSV content with all records
                let csvContent = 'No,NIK,Nama,TREG,Witel,Job Role';
                // Add category headers
                props.categories.forEach(category => {
                    csvContent += `,${category.title}`;
                });
                csvContent += '\n';

                // Add data rows
                data.participants.forEach((participant, index) => {
                    const rowNum = index + 1;
                    let row = `${rowNum},${participant.nik},"${participant.name}",${participant.area.title},${participant.witel},${participant.role}`;
                    
                    // Add grades for each category
                    props.categories.forEach(category => {
                        const status = getExamStatus(participant, category.title);
                        // Remove icons and handle "Belum Ujian" for Excel
                        let excelStatus = status;
                        if (status === '❌') {
                            excelStatus = 'Belum Ujian';
                        } else if (status.includes('💎') || status.includes('🥇') || 
                                 status.includes('🥈') || status.includes('🥉') || 
                                 status.includes('🌱')) {
                            excelStatus = status.split(' ')[0]; // Keep only the grade number
                        }
                        row += `,"${excelStatus}"`;
                    });
                    csvContent += row + '\n';
                });

                // Create and download file
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'progress_Ujian_Brevet.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } catch (error) {
                console.error('Error exporting to Excel:', error);
                alert('Failed to export data. Please try again later.');
            }
        };

        const getExamStatus = (participant, categoryTitle) => {
            if (!participant.grades || !participant.grades.length) return '❌';
            
            const categoryGrades = participant.grades.filter(grade => 
                grade.exam?.category?.title?.toLowerCase() === categoryTitle.toLowerCase() &&
                grade.end_time !== null &&
                grade.grade !== null &&
                grade.exam_type !== null // Filter tambahan di sini
            );

            if (categoryGrades.length === 0) return '❌';

            // Calculate average if multiple grades exist for the same category
            const sum = categoryGrades.reduce((acc, grade) => acc + Number(grade.grade), 0);
            const average = sum / categoryGrades.length;
            
            if (isNaN(average)) return '❌';
            
            // Add level indicator based on grade
            const grade = average.toFixed(2);
            if (grade >= 91) return `${grade} 💎`; // Expert
            if (grade >= 76) return `${grade} 🥇`; // Advanced
            if (grade >= 61) return `${grade} 🥈`; // Intermediate
            if (grade >= 41) return `${grade} 🥉`; // Basic
            return `${grade} 🌱`; // Starter
        }

        const handleSearch = () => {
            router.get('/admin/pending-exams', {
                q: search.value,
                area_id: selectedArea.value,
                witel: selectedWitel.value,
                role: selectedRole.value,
                page: 1 // Reset to page 1 when searching
            }); 
        }

        const handleFilter = () => {
            router.get('/admin/pending-exams', {
                q: search.value,
                area_id: selectedArea.value,
                witel: selectedWitel.value,
                role: selectedRole.value,
                page: 1 // Reset to page 1 when searching
            });
        }

        const setPerPage = (value) => {
            perPage.value = value;
            router.get('/admin/pending-exams', {
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
            router.get('/admin/pending-exams', {
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

        // Add this method in the setup function before the return statement
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
        
        // Make sure to include calculateAge in the return statement
        return {
            search,
            selectedArea,
            selectedWitel,
            selectedRole,
            filteredWitels,
            filteredRoles,
            hasActiveFilters,
            getAreaName,
            clearAreaFilter,
            clearWitelFilter,
            clearRoleFilter,
            clearAllFilters,
            handleSearch,
            handleFilter,
            getExamStatus,
            exportToExcel,
            perPage,
            goToPage,
            setPerPage,
            pageNumbers,
            calculateAge  // Add this line to include the calculateAge function
        }
    }
};
</script>

<style>
.table td {
    padding: 0.75rem;
    vertical-align: middle;
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
