<template>
    <Head>
        <title>Result - Aplikasi Ujian Online</title>
    </Head>
    <div class="alert alert-warning mb-4" role="alert">
        <p class="mb-0">
            <i class="fa fa-info-circle me-2"></i>Hai, <b>{{ $page.props.auth.participant.name }}</b>! Saat ini Anda berada di level: 
            <span class="badge" :class="{
                'bg-secondary': getUserLevel.level === 'starter',
                'bg-bronze': getUserLevel.level === 'basic',
                'bg-silver': getUserLevel.level === 'intermediate',
                'bg-gold': getUserLevel.level === 'advanced',
                'bg-diamond': getUserLevel.level === 'expert'
            }">
                {{ getUserLevel.emoji }} {{ getUserLevel.level.toUpperCase() }}
            </span>
            <!-- <span class="ms-2 badge bg-info">
                Nilai: {{ Number(topTechniciansArea?.find(tech => 
                                                String(tech.participant_id) === String($page.props.auth.participant.id))?.average_grade || 0).toFixed(2) 
                                            }}
            </span> -->
        </p>
    </div>
    <div class="container-fluid mb-5 mt-5 px-4"> <!-- Menambahkan padding horizontal -->
        <div class="row mb-4">
            <div class="col-12 col-md-5">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen063.svg-->
                                <span class="svg-icon svg-icon-success svg-icon-2hx"><svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M21.1721 9.90759L19.6663 8.3801C19.5613 8.27722 19.4783 8.15406 19.4225 8.0181C19.3666 7.88214 19.339 7.73623 19.3413 7.58926V5.4226C19.3399 5.12576 19.2798 4.83214 19.1646 4.55858C19.0494 4.28503 18.8812 4.03693 18.6698 3.82856C18.4584 3.62018 18.2079 3.45562 17.9327 3.34434C17.6576 3.23305 17.3631 3.17724 17.0663 3.1801H14.8996C14.7526 3.18241 14.6067 3.15479 14.4708 3.09892C14.3348 3.04304 14.2116 2.96009 14.1088 2.8551L12.5921 1.3276C12.1696 0.905532 11.5968 0.668457 10.9996 0.668457C10.4024 0.668457 9.82962 0.905532 9.40711 1.3276L7.87961 2.83343C7.77673 2.93842 7.65357 3.02138 7.51761 3.07725C7.38165 3.13312 7.23575 3.16074 7.08877 3.15843H4.92211C4.62528 3.15984 4.33165 3.21989 4.05809 3.33512C3.78454 3.45035 3.53645 3.6185 3.32807 3.82989C3.11969 4.04129 2.95513 4.29178 2.84385 4.56696C2.73257 4.84215 2.67675 5.13661 2.67961 5.43343V7.6001C2.68192 7.74707 2.6543 7.89297 2.59843 8.02893C2.54255 8.16489 2.4596 8.28805 2.35461 8.39093L0.827108 9.90759C0.405044 10.3301 0.167969 10.9029 0.167969 11.5001C0.167969 12.0973 0.405044 12.6701 0.827108 13.0926L2.33294 14.6201C2.43793 14.723 2.52089 14.8461 2.57676 14.9821C2.63263 15.118 2.66025 15.264 2.65794 15.4109V17.5776C2.65935 17.8744 2.7194 18.1681 2.83463 18.4416C2.94986 18.7152 3.11801 18.9633 3.32941 19.1716C3.5408 19.38 3.79129 19.5446 4.06647 19.6559C4.34166 19.7671 4.63612 19.823 4.93294 19.8201H7.09961C7.24658 19.8178 7.39249 19.8454 7.52844 19.9013C7.6644 19.9571 7.78757 20.0401 7.89044 20.1451L9.41794 21.6726C9.84045 22.0947 10.4132 22.3317 11.0104 22.3317C11.6076 22.3317 12.1804 22.0947 12.6029 21.6726L14.1196 20.1668C14.2225 20.0618 14.3456 19.9788 14.4816 19.9229C14.6176 19.8671 14.7635 19.8394 14.9104 19.8418H17.0771C17.6747 19.8418 18.2479 19.6044 18.6705 19.1818C19.093 18.7592 19.3304 18.1861 19.3304 17.5884V15.4218C19.3281 15.2748 19.3557 15.1289 19.4116 14.9929C19.4675 14.857 19.5504 14.7338 19.6554 14.6309L21.1829 13.1034C21.3928 12.8933 21.5591 12.6438 21.6723 12.3691C21.7854 12.0945 21.8431 11.8003 21.8421 11.5033C21.8411 11.2063 21.7814 10.9124 21.6664 10.6385C21.5514 10.3647 21.3834 10.1163 21.1721 9.90759Z" fill="currentColor" fill-opacity="0.8"/>
                                <path d="M7.90276 8.65088H6.81943C6.36471 8.65088 5.99609 9.0195 5.99609 9.47421V15.0317C5.99609 15.4864 6.36471 15.855 6.81943 15.855H7.90276C8.35748 15.855 8.72609 15.4864 8.72609 15.0317V9.47421C8.72609 9.0195 8.35748 8.65088 7.90276 8.65088Z" fill="currentColor" fill-opacity="0.8"/>
                                <path d="M8.69141 10.1459L10.7714 7.00425C10.9133 6.7749 11.1313 6.60279 11.3873 6.51808C11.6433 6.43338 11.921 6.44147 12.1717 6.54096C12.4223 6.64044 12.63 6.82497 12.7582 7.0622C12.8864 7.29942 12.9271 7.57422 12.8731 7.83842L12.6022 9.38759C12.5864 9.47635 12.5902 9.56749 12.6134 9.65462C12.6366 9.74175 12.6785 9.82275 12.7364 9.89193C12.7942 9.96111 12.8665 10.0168 12.9481 10.055C13.0297 10.0933 13.1187 10.1132 13.2089 10.1134H15.3322C15.4753 10.116 15.6159 10.1516 15.7431 10.2174C15.8702 10.2831 15.9805 10.3772 16.0653 10.4925C16.1502 10.6078 16.2074 10.741 16.2324 10.8819C16.2575 11.0229 16.2497 11.1676 16.2097 11.3051L14.8664 15.6926C14.7942 15.9256 14.651 16.1303 14.4567 16.2779C14.2625 16.4256 14.0269 16.5088 13.7831 16.5159H11.1072C10.7461 16.5132 10.3944 16.3997 10.0997 16.1909L8.73474 15.1076L8.69141 10.1459Z" fill="currentColor" fill-opacity="0.8"/>
                                </svg>
                                </span>
                                <!--end::Svg Icon--> Score Map</h5>
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
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor"/>
                            <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="currentColor"/>
                            <rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor"/>
                            <rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon--> Hasil Assessment</h5>
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
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen020.svg-->
                            <span class="svg-icon svg-icon-2hx svg-icon-warning"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor"/>
                            <path opacity="0.3" d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon--> Top Teknisi Regional</h5>
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
                                        :class="{ 'table-posisi': String(tech.participant_id) === String($page.props.auth.participant.id) }">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>{{ tech.participant?.name }}</td>
                                        <td>{{ tech.participant?.area?.title }}</td>
                                        <td class="text-center">{{ Number(tech.average_grade).toFixed(2) }}</td>
                                    </tr>
                                </tbody>
                                </table>
                                <!-- For Regional ranking -->
                                <div class="mt-2 text-end">
                                    <small class="text-muted">
                                        <i><b>Nilai Anda:</b> </i> 
                                        <span class="badge bg-warning">
                                            {{ Number(topTechniciansArea?.find(tech => 
                                                String(tech.participant_id) === String($page.props.auth.participant.id))?.average_grade || 0).toFixed(2) 
                                            }}</span>     
                                        <i><b>     Posisi:</b> </i> 
                                        <span class="badge bg-success">#{{ 
                                            topTechniciansArea.findIndex(tech => 
                                                String(tech.participant_id) === String($page.props.auth.participant.id)) + 1 
                                        }}</span>
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
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/general/gen020.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor"/>
                            <path opacity="0.3" d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z" fill="currentColor"/>
                            </svg>
                            </span>
                            <!--end::Svg Icon--> Top Teknisi Nasional</h5>
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
                                        :class="{ 'table-posisi': String(tech.participant_id) === String($page.props.auth.participant.id) }">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>{{ tech.participant?.name }}</td>
                                        <td>{{ tech.participant?.area?.title }}</td>
                                        <td class="text-center">{{ Number(tech.average_grade).toFixed(2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- For National ranking -->
                            <div class="mt-2 text-end">
                                <small class="text-muted">
                                    <i><b>Nilai Anda:</b> </i> 
                                    <span class="badge bg-warning">
                                        {{ Number(topTechniciansNational?.find(tech => 
                                            String(tech.participant_id) === String($page.props.auth.participant.id))?.average_grade || 0).toFixed(2) 
                                        }}</span>     
                                    <i><b>     Posisi:</b> </i> 
                                    <span class="badge bg-success">#{{ 
                                        topTechniciansNational.findIndex(tech => 
                                            String(tech.participant_id) === String($page.props.auth.participant.id)) + 1 
                                    }}</span>
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
                        <h5><!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/keenthemes/metronic/docs/core/html/src/media/icons/duotune/abstract/abs027.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"/>
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"/>
                        </svg>
                        </span>
                        <!--end::Svg Icon--> Riwayat Nilai</h5>
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
        userNationalRank: Number,
        debugInfo: Object
    },
    mounted() {
        // Debug logging
        console.log('Debug Data:', {
            results: this.results,
            chartData: this.chartData,
            topTechnicians: {
                area: this.topTechniciansArea,
                national: this.topTechniciansNational
            },
            ranks: {
                area: this.userAreaRank,
                national: this.userNationalRank
            }
        });
    },
    computed: {
        getUserLevel() {
            console.log('Auth Participant ID:', this.$page.props.auth.participant.id);
            console.log('Top Technicians National:', this.topTechniciansNational);
            
            const averageGrade = Number(this.topTechniciansArea?.find(tech =>  
                String(tech.participant_id) === String(this.$page.props.auth.participant.id))?.average_grade || 0);
            
            console.log('Average Grade:', averageGrade);
            
            let level = {
                level: 'starter',
                emoji: '🌱',
                averageGrade: averageGrade
            };
            
            if (averageGrade > 90) {
                level = { level: 'expert', emoji: '💎', averageGrade: averageGrade };
            } else if (averageGrade > 70 && averageGrade <= 90) {
                level = { level: 'advanced', emoji: '🥇', averageGrade: averageGrade };
            } else if (averageGrade > 60 && averageGrade <= 70) {
                level = { level: 'intermediate', emoji: '🥈', averageGrade: averageGrade };
            } else if (averageGrade > 30 && averageGrade <= 60) {
                level = { level: 'basic', emoji: '🥉', averageGrade: averageGrade };
            }
            
            return level;
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
        },
        mounted() {
            console.log('Debug Data:', {
                auth: this.$page.props.auth,
                topTechnicians: this.topTechniciansNational,
                averageGrade: Number(this.topTechniciansNational?.find(tech => 
                    tech.participant_id === this.$page.props.auth.participant.id)?.average_grade || 0).toFixed(2)
            });
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