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
        <div class="row mt-1">
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
                                        <td  class="text-center">
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
                        <Pagination :links="participants.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import Pagination from '../../../Components/Pagination.vue';
import { ref } from 'vue';
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
        categories: Array
    },

    setup(props) {
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        const exportToExcel = () => {
            // Create CSV content
            let csvContent = 'No,NIK,Nama,TREG,Witel,Job Role';
            // Add category headers
            props.categories.forEach(category => {
                csvContent += `,${category.title}`;
            });
            csvContent += '\n';

            // Add data rows
            props.participants.data.forEach((participant, index) => {
                const rowNum = index + 1 + (props.participants.current_page-1) * props.participants.per_page;
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
        };

        const getExamStatus = (participant, categoryTitle) => {
            if (!participant.grades || !participant.grades.length) return '❌';
            
            const categoryGrades = participant.grades.filter(grade => 
                grade.exam?.category?.title?.toLowerCase() === categoryTitle.toLowerCase()
            );

            if (categoryGrades.length === 0) return '❌';

            // Calculate average if multiple grades exist for the same category
            const sum = categoryGrades.reduce((acc, grade) => acc + Number(grade.grade), 0);
            const average = sum / categoryGrades.length;
            
            if (isNaN(average)) return '❌';
            
            // Add level indicator based on grade
            const grade = average.toFixed(2);
            if (grade >= 91) return `${grade} 💎`; // Expert
            if (grade >= 71) return `${grade} 🥇`; // Advanced
            if (grade >= 61) return `${grade} 🥈`; // Intermediate
            if (grade >= 31) return `${grade} 🥉`; // Basic
            return `${grade} 🌱`; // Starter
        }

        const handleSearch = () => {
            router.get('/admin/pending-exams', {
                q: search.value,
            }); 
        }

        return {
            search,
            handleSearch,
            getExamStatus,
            exportToExcel
        }
    }
};
</script>

<style>
.table td {
    padding: 0.75rem;
    vertical-align: middle;
}
</style>