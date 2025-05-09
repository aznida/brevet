<template>
    <Head>
        <title>Result - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Hasil Assessment</h5>
                        <div class="chart-container">
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
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-chart-line"></i> Level Stream</h5>
                        <div class="chart-container">
                            <apexchart
                                type="pie"
                                :options="levelStreamChartOptions"
                                :series="levelStreamSeries"
                                height="320"
                            ></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
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
        chartData: Object
    },
    computed: {
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
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: this.chartData?.categories || [],
                },
                yaxis: {
                    title: {
                        text: 'Nilai'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val
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
        }
    }
}
</script>