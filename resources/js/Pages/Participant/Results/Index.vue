<template>
    <Head>
        <title>Result - Aplikasi Ujian Online</title>
    </Head>
    <div class="alert alert-warning mb-4" role="alert">
                <p class="mb-0">
                    Hai, <b>{{ $page.props.auth.participant.name }}</b>! Saat ini Anda berada di level: 
                    <span class="badge" :class="{
                        'bg-secondary': getUserLevel.level === 'starter',
                        'bg-bronze': getUserLevel.level === 'basic',
                        'bg-silver': getUserLevel.level === 'intermediate',
                        'bg-gold': getUserLevel.level === 'advanced',
                        'bg-diamond': getUserLevel.level === 'expert'
                    }">
                        {{ getUserLevel.emoji }} {{ getUserLevel.level.toUpperCase() }}
                    </span>
                </p>
            </div>
    <div class="container-fluid mb-5 mt-5 px-4"> <!-- Menambahkan padding horizontal -->
        <div class="row mb-4">
            <div class="col-12 col-md-5">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Score Map</h5>
                        <div v-if="!radarSeries || radarSeries.length === 0" class="alert alert-warning">
                            Data score map belum tersedia
                        </div>
                        <div v-else class="chart-container">
                            <apexchart
                                type="radar"
                                :options="radarChartOptions"
                                :series="radarSeries"
                                height="310"
                            ></apexchart>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Hasil Assessment</h5>
                        <div v-if="!assessmentSeries || assessmentSeries.length === 0" class="alert alert-warning">
                            Data hasil assessment belum tersedia
                        </div>
                        <div v-else class="chart-container">
                            <apexchart
                                type="bar"
                                :options="assessmentChartOptions"
                                :series="assessmentSeries"
                                height="310"
                            ></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Menambahkan alert untuk level -->
            <!-- Top Teknisi Area -->
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-trophy"></i> Top Teknisi Regional</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>NO.</th>
                                        <th>NAMA</th>
                                        <th>TREG</th>
                                        <th>NILAI</th>
                                    </tr>
                                </thead>
                                <!-- Top Teknisi Area -->
                                <tbody>
                                    <tr v-for="(tech, index) in topTechniciansArea.slice(0, 10)" :key="index" 
                                        :class="{ 'table-posisi': tech.participant_id === $page.props.auth.participant.id }">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>{{ tech.participant?.name }}</td>
                                        <td>{{ tech.participant?.area?.title }}</td>
                                        <td class="text-center">{{ Number(tech.average_grade).toFixed(2) }}</td>
                                    </tr>
                                </tbody>
                                </table>
                                <div class="mt-2 text-end">
                                    <small class="text-muted">
                                        <i><b>Nilai Anda:</b> </i> <span class="badge bg-warning">{{ Number(topTechniciansArea.find(tech => tech.participant_id === $page.props.auth.participant.id)?.average_grade || 0).toFixed(2) }}</span>     
                                        <i><b>     Posisi:</b> </i> <span class="badge bg-success">#{{ topTechniciansArea.findIndex(tech => tech.participant_id === $page.props.auth.participant.id) + 1 }}</span>
                                    </small>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Teknisi Nasional -->
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-trophy"></i> Top Teknisi Nasional</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>NO.</th>
                                        <th>NAMA</th>
                                        <th>TREG</th>
                                        <th>NILAI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(tech, index) in topTechniciansNational.slice(0, 10)" :key="index"
                                        :class="{ 'table-posisi': tech.participant_id === $page.props.auth.participant.id }">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>{{ tech.participant?.name }}</td>
                                        <td>{{ tech.participant?.area?.title }}</td>
                                        <td class="text-center">{{ Number(tech.average_grade).toFixed(2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-2 text-end">
                                <small class="text-muted">
                                    <i><b>Nilai Anda:</b> </i> <span class="badge bg-warning">{{ Number(topTechniciansNational.find(tech => tech.participant_id === $page.props.auth.participant.id)?.average_grade || 0).toFixed(2) }}   </span>     
                                    <i><b>     Posisi:</b> </i> <span class="badge bg-success">#{{ topTechniciansNational.findIndex(tech => tech.participant_id === $page.props.auth.participant.id) + 1 }}</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-list"></i> Riwayat Nilai</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0">No.</th>
                                        <th class="border-0">Ujian</th>
                                        <th class="border-0">Kategori</th>
                                        <th class="border-0">Nilai</th>
                                        <th class="border-0">Level</th>
                                        <th class="border-0">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(result, index) in results" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ result.exam_title }}</td>
                                        <td>{{ result.category }}</td>
                                        <td class="text-center">{{ result.grade }}</td>
                                        <td class="text-center">{{ result.level }}</td>
                                        <td>{{ result.date }}</td>
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
import LayoutParticipant from '../../../Layouts/Participant.vue';
import { Head } from '@inertiajs/vue3';
import VueApexCharts from 'vue3-apexcharts';

export default {
    layout: LayoutParticipant,
    components: {
        Head,
        apexchart: VueApexCharts
    },
    props: {
        results: Array,
        chartData: Object,
        topTechniciansArea: Array,
        topTechniciansNational: Array,
        userAreaRank: Number,
        userNationalRank: Number
    },
    computed: {
        getUserLevel() {
            // Calculate user level based on average grade
            const averageGrade = this.results?.reduce((acc, result) => acc + parseFloat(result.grade), 0) / (this.results?.length || 1);
            
            if (averageGrade >= 90) {
                return { level: 'expert', emoji: '💎' };
            } else if (averageGrade >= 70) {
                return { level: 'advanced', emoji: '🥇' };
            } else if (averageGrade >= 60) {
                return { level: 'intermediate', emoji: '🥈' };
            } else if (averageGrade >= 30) {
                return { level: 'basic', emoji: '🥉' };
            } else {
                return { level: 'starter', emoji: '🌱' };
            }
        },
        assessmentChartOptions() {
            return {
                chart: {
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    },
                },
                colors: ['#FF6B6B', '#4ECDC4', '#45B7D1'],
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toFixed(2)
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold',
                        colors: ['#000']
                    },
                    offsetY: -20
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: this.chartData?.categories || [],
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Nilai'
                    },
                    max: 100,
                    tickAmount: 5,
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0)
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toFixed(2)
                        }
                    }
                }
            }
        },
        assessmentSeries() {
            return [{
                name: 'Nilai',
                data: this.chartData?.values || []
            }]
        },
        levelStreamChartOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: ['Expert', 'Advanced', 'Intermediate', 'Basic', 'Starter'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }
        },
        levelStreamSeries() {
            const levelCounts = {
                Expert: 0,
                Advanced: 0,
                Intermediate: 0,
                Basic: 0,
                Starter: 0
            };

            this.results?.forEach(result => {
                const grade = parseFloat(result.grade);
                if (grade >= 91) levelCounts.Expert++;
                else if (grade >= 71) levelCounts.Advanced++;
                else if (grade >= 61) levelCounts.Intermediate++;
                else if (grade >= 31) levelCounts.Basic++;
                else levelCounts.Starter++;
            });

            return Object.values(levelCounts);
        },
        radarChartOptions() {
            return {
                chart: {
                    type: 'radar',
                    toolbar: {
                        show: false
                    },
                    height: 350
                },
                dataLabels: {
                    enabled: true
                },
                plotOptions: {
                    radar: {
                        size: 120,
                        polygons: {
                            strokeColors: '#e9e9e9',
                            fill: {
                                colors: ['#f8f8f8', '#fff']
                            }
                        }
                    }
                },
                colors: ['#FF4560'],
                markers: {
                    size: 4,
                    colors: ['#fff'],
                    strokeColor: '#FF4560',
                    strokeWidth: 2
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    }
                },
                xaxis: {
                    categories: ['Attitude', 'Electrical', 'Mechanical', 'Maintenance', 'Monitoring', 'Automation', 'Praktik']
                },
                yaxis: {
                    labels: {
                        formatter: function(val, i) {
                            if (i % 2 === 0) {
                                return val
                            } else {
                                return ''
                            }
                        }
                    }
                }
            };
        },
        radarSeries() {
            // Mengelompokkan nilai berdasarkan kategori dan filter nilai 0
            const categoryGrades = {};
            
            this.results?.forEach(result => {
                const grade = parseFloat(result.grade);
                if(grade <= 0) return; // Skip nilai 0
                
                let category = result.category;
                if (category === 'Assesment Praktik') category = 'Praktik';
                if (category === 'Assesment Attitude') category = 'Attitude';
                
                if (!categoryGrades[category]) {
                    categoryGrades[category] = [];
                }
                categoryGrades[category].push(grade);
            });

            // Menghitung rata-rata untuk setiap kategori
            const radarCategories = ['Attitude', 'Electrical', 'Mechanical', 'Maintenance', 'Monitoring', 'Automation', 'Praktik'];
            const averageGrades = radarCategories.map(category => {
                const grades = categoryGrades[category] || [];
                if (grades.length === 0) return 0;
                const sum = grades.reduce((a, b) => a + b, 0);
                return parseFloat((sum / grades.length).toFixed(2));
            });

            return [{
                name: 'Nilai',
                data: averageGrades
            }];
        }
    }
};
</script>

<style scoped>
.container-fluid {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2px;
}

@media (max-width: 768px) {
    .card {
        margin-bottom: 8px;
    }
    
    .table td, .table th {
        padding: 0.5rem;
    }
}

.table-posisi {
    background-color: #FF6B6B !important;
    color: #ffffff !important;
    font-weight: 500 !important;
}

.text-muted {
    font-size: 0.875rem;
    color: #6c757d !important;
}

.posisi-info {
    margin-top: 8px;
    text-align: right;
    padding-right: 10px;
}

.table td, .table th {
    padding: 0.75rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table tbody tr:hover {
    background-color: rgba(0,0,0,0.075);
}

.table-posisi:hover {
    background-color: #ff5252 !important;
}

.table th:nth-child(1) { width: 10%; }
.table th:nth-child(2) { width: 35%; }
.table th:nth-child(3) { width: 35%; }
.table th:nth-child(4) { width: 20%; }

.bg-secondary {
    background-color: #CD7F32 !important;
    color: white;
}

.bg-bronze {
    background-color: #CD7F32 !important;
    color: white;
}

.bg-silver {
    background-color: #C0C0C0 !important;
    color: white;
}

.bg-gold {
    background-color: #FFD700 !important;
    color: black;
}

.bg-diamond {
    background-color: #B9F2FF !important;
    color: black;
}
</style>
