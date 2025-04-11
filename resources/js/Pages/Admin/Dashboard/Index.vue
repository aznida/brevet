<template>
    <Head>
        <title>Dashboard - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-back icon icon-md" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Area</h2>
                                    <h3 class="fw-extrabold mb-1">{{ areas }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Area</h2>
                                    <h3 class="fw-extrabold mb-1">{{ areas }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-people-fill icon icon-md" viewBox="0 0 16 16">
                                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Partisipan</h2>
                                    <h3 class="fw-extrabold mb-1">{{ participants }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Partisipan</h2>
                                    <h3 class="fw-extrabold mb-1">{{ participants }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square icon icon-md" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exams }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exams }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-danger rounded me-4 me-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-stopwatch icon icon-md" viewBox="0 0 16 16">
                                        <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                                        <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                                    </svg>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Sesi Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exam_sessions }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h5">Sesi Ujian</h2>
                                    <h3 class="fw-extrabold mb-1">{{ exam_sessions }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Assement Result</h5>
                        <div class="chart-container">
                            <div class="text-center pt-5">No data available</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Level Stream</h5>
                        <div class="chart-container">
                            <div class="text-center pt-5">No data available</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard tabel Level Stream per Regional -->
        <div class="row mt-1 mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5><i class="fa fa-chart-line"></i> Level Stream per Regional</h5>
                            <button @click="exportAllToExcel" class="btn btn-success btn-sm text-white">
                                <i class="fas fa-file-excel me-1 text-white"></i> Export Excel
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">TREG Area</th>
                                        <th class="border-0">Starter 🌱</th>
                                        <th class="border-0">Basic 🥉</th>
                                        <th class="border-0">Intermediate 🥈</th>
                                        <th class="border-0">Advanced 🥇</th>
                                        <th class="border-0 rounded-end" style="width:15%">Expert 💎</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(stat, index) in filteredAreaStats" :key="index">
                                        <td class="fw-bold text-center">{{ index + 1 }}</td>
                                        <td>{{ stat.title }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'starter', stat.starter_participants)">{{ stat.starter }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'basic', stat.basic_participants)">{{ stat.basic }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'intermediate', stat.intermediate_participants)">{{ stat.intermediate }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'advanced', stat.advanced_participants)">{{ stat.advanced }}</td>
                                        <td class="text-center cursor-pointer" @click="showParticipants(stat.title, 'expert', stat.expert_participants)">{{ stat.expert }}</td>
                                    </tr>
                                    <tr class="bg-light fw-bold">
                                        <td colspan="2" class="text-center">Total</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('starter')">{{ getTotalByLevel('starter') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('basic')">{{ getTotalByLevel('basic') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('intermediate')">{{ getTotalByLevel('intermediate') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('advanced')">{{ getTotalByLevel('advanced') }}</td>
                                        <td class="text-center cursor-pointer" @click="showAllParticipantsByLevel('expert')">{{ getTotalByLevel('expert') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
    <!-- Modal -->
    <div class="modal fade" id="participantsModal" tabindex="-1" aria-labelledby="participantsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-dialog  modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="participantsModalLabel">{{ modalTitle }}</h5>
                            <div>
                                <button @click="exportToExcel" class="btn btn-success btn-sm me-2 text-white">
                                    <i class="fas fa-file-excel me-1 text-white"></i> Export Excel
                                </button>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div v-if="selectedParticipants && selectedParticipants.length > 0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                        <thead class="thead-dark">
                                            <tr class="border-0">
                                                <th class="border-0 rounded-start" style="width:10%">No.</th>
                                                <th class="border-0">Nama</th>
                                                <th class="border-0">TREG - Area</th>
                                                <th class="border-0">Witel</th>
                                                <th class="border-0">Nilai</th>
                                                <th class="border-0 rounded-end" style="width:20%">Level Stream</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(participant, index) in selectedParticipants" :key="index">
                                                <td class="text-center">{{ index + 1 }}</td>
                                                <td>{{ participant.name }}</td>
                                                <td>{{ participant.areas }}</td>
                                                <td>{{ participant.witel || '-' }}</td>
                                                <td class="text-center">{{ participant.grade }}</td>
                                                <td class="text-center">{{ participant.level }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-else class="text-center">
                                No participants found
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <!-- End Dashboard tabel level stream per regional -->

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Top Participant per Regional</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Regional</th>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">Witel</th>
                                        <th class="border-0">Nilai</th>
                                        <th class="border-0 rounded-end">Level Stream</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="topParticipantsByRegional.length > 0">
                                        <tr v-for="(participant, index) in topParticipantsByRegional" :key="index">
                                            <td class="text-center">{{ index + 1 }}</td>
                                            <td>{{ participant.regional }}</td>
                                            <td>{{ participant.name }}</td>
                                            <td>{{ participant.witel }}</td>
                                            <td class="text-center">{{ participant.grade }}</td>
                                            <td class="text-center">{{ participant.level }}</td>
                                        </tr>
                                    </template>
                                    <tr v-else>
                                        <td colspan="6" class="text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Mechanical</h5>
                        <div class="chart-container">
                            <div class="text-center pt-5">No data available</div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    //import layout Admin
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import Heade from Inertia
    import {
        Head,
    } from '@inertiajs/vue3';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head
        },

        //props
        props: {
            participants: Number,
            exams: Number,
            exam_sessions: Number,
            areas: Number,
            areaLevelStats: Array,
        },

        computed: {
        filteredAreaStats() {
            if (!this.areaLevelStats) return [];
            return this.areaLevelStats.filter(stat => !stat.title.toLowerCase().includes('nasional'));
        },
        topParticipantsByRegional() {
            if (!this.areaLevelStats) return [];
            
            const topParticipants = [];
            this.filteredAreaStats.forEach(stat => {
                const allParticipants = [];
                
                ['starter', 'basic', 'intermediate', 'advanced', 'expert'].forEach(level => {
                    const participants = stat[`${level}_participants`] || [];
                    participants.forEach(p => {
                        allParticipants.push({
                            ...p,
                            name: p.name,
                            witel: p.witel || '-',  // Ensure witel has a fallback value
                            grade: p.grade,
                            level: level
                        });
                    });
                });
                
                const topTwo = allParticipants
                    .sort((a, b) => b.grade - a.grade)
                    .slice(0, 2)
                    .map(p => ({
                        ...p,
                        regional: stat.title,
                        witel: p.witel || '-',  // Preserve witel in the final mapping
                        level: this.getLevelWithEmoji(p.level)
                    }));
                    
                if (topTwo.length > 0) {
                    topParticipants.push(...topTwo);
                }
            });
            
            return topParticipants;
        },
    },
    data() {
        return {
            modalTitle: '',
            selectedParticipants: [],
            modal: null
        }
    },

    mounted() {
        this.modal = new bootstrap.Modal(document.getElementById('participantsModal'));
    },

    methods: {
        // In showParticipants method
        showParticipants(area, level, participants) {
            const levelEmoji = {
                'starter': '🌱',
                'basic': '🥉',
                'intermediate': '🥈',
                'advanced': '🥇',
                'expert': '💎'
            };
            
            this.modalTitle = `${area} - ${level.charAt(0).toUpperCase() + level.slice(1)} Level ${levelEmoji[level]}`;
            this.selectedParticipants = participants.map(participant => ({
                ...participant,
                areas: area,
                witel: participant.witel,  // Preserve witel
                level: `${level.charAt(0).toUpperCase() + level.slice(1)} ${levelEmoji[level]}`
            })) || [];
            this.modal.show();
        },
        
        // In showAllParticipantsByLevel method
        showAllParticipantsByLevel(level) {
            const levelEmoji = {
                'starter': '🌱',
                'basic': '🥉',
                'intermediate': '🥈',
                'advanced': '🥇',
                'expert': '💎'
            };
            
            const allParticipants = [];
            this.filteredAreaStats.forEach(stat => {
                const participants = stat[`${level}_participants`] || [];
                participants.forEach(p => {
                    allParticipants.push({
                        ...p,
                        areas: stat.title,
                        witel: p.witel,  // Preserve witel
                        level: `${level.charAt(0).toUpperCase() + level.slice(1)} ${levelEmoji[level]}`
                    });
                });
            });
        
            this.modalTitle = `All ${level.charAt(0).toUpperCase() + level.slice(1)} Level ${levelEmoji[level]} Participants`;
            this.selectedParticipants = allParticipants;
            this.modal.show();
        },
        
        // In exportAllToExcel method
        exportAllToExcel() {
            const allParticipants = [];
            
            this.filteredAreaStats.forEach(stat => {
                ['starter', 'basic', 'intermediate', 'advanced', 'expert'].forEach(level => {
                    const participants = stat[`${level}_participants`] || [];
                    participants.forEach(p => {
                        allParticipants.push({
                            name: p.name,
                            areas: stat.title,
                            witel: p.witel,  // Add witel to export
                            grade: p.grade,
                            level: this.getLevelWithEmoji(level)
                        });
                    });
                });
            });
        
            // Update headers to include Witel
            const headers = ['No.', 'Nama', 'TREG - Area', 'Witel', 'Nilai', 'Level Stream'];
            const csvContent = [
                headers,
                ...allParticipants.map((p, index) => [
                    index + 1,
                    p.name,
                    p.areas,
                    p.witel || '-',
                    p.grade,
                    p.level
                ])
            ].map(row => row.join(',')).join('\n');

            // Create and trigger download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'Level_Stream_per_Regional.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },

        getLevelWithEmoji(level) {
            const levelEmoji = {
                'starter': '🌱',
                'basic': '🥉',
                'intermediate': '🥈',
                'advanced': '🥇',
                'expert': '💎'
            };
            return `${level.charAt(0).toUpperCase() + level.slice(1)} ${levelEmoji[level] || ''}`;
        },
        getTotalByLevel(level) {
            return this.filteredAreaStats.reduce((total, stat) => total + (stat[level] || 0), 0);
        },
            exportToExcel() {
            // Create CSV content
            const headers = ['No.', 'Nama', 'TREG - Area', 'Witel', 'Nilai', 'Level Stream'];
                const csvContent = [
                    headers,
                    ...this.selectedParticipants.map((p, index) => [
                        index + 1,
                        p.name,
                        p.areas,
                        p.witel || '-',
                        p.grade,
                        p.level
                    ])
                ].map(row => row.join(',')).join('\n');

            // Create and trigger download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `${this.modalTitle.replace(/[^\w\s]/gi, '_')}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        },
            

        }

</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
.cursor-pointer:hover {
    background-color: rgba(0,0,0,0.05);
}
</style>
