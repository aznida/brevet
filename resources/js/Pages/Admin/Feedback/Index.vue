<template>
    <Head>
        <title>Feedback - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <!-- National Statistics Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow bg-primary text-white">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <h4 class="mb-1">{{ nationalStats.satisfaction }}</h4>
                                <p class="mb-0">📊 National Satisfaction Rating</p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-1">{{ nationalStats.relevance }}</h4>
                                <p class="mb-0">🎯 National Relevance Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        

        <!-- Charts section -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <canvas ref="satisfactionChart" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <canvas ref="relevanceChart" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search section -->
        <div class="row">
            <div class="col-md-8">
                <div class="row">
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
        </div>

        <!-- Table section -->
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0" style="width:15%">Participant</th>
                                        <th class="border-0" style="width:15%">Area</th>
                                        <th class="border-0" style="width:10%">Satisfaction</th>
                                        <th class="border-0" style="width:10%">Relevance</th>
                                        <th class="border-0" style="width:35%">Comments</th>
                                        <th class="border-0 rounded-end" style="width:10%">Date</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(item, index) in feedback.data" :key="item.id">
                                        <td class="text-center fw-bold">
                                            {{ (feedback.current_page - 1) * feedback.per_page + index + 1 }}
                                        </td>
                                        <td class="fw-bold">
                                            {{ item.participant.name }}
                                        </td>
                                        <td>
                                            {{ item.participant.area?.title || '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ item.satisfaction_rating }}
                                        </td>
                                        <td class="text-center">
                                            {{ item.relevance_rating }}
                                        </td>
                                        <td>
                                            {{ item.comments }}
                                        </td>
                                        <td class="text-center">
                                            {{ new Date(item.created_at).toLocaleDateString() }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="feedback.links" align="end" />
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
    import { Head, Link, router } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import Chart from 'chart.js/auto';

    export default {
        layout: LayoutAdmin,
        components: { Head, Link, Pagination },
        props: {
            feedback: Object,
            filters: Object,
            stats: Object,
        },

        setup(props) {
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));
            const index = ref(0);
            const satisfactionChart = ref(null);
            const relevanceChart = ref(null);
            let charts = [];

            // Enhanced debug logging
            console.log('Full props:', props);
            console.log('Props stats:', props.stats);
            console.log('Area stats:', props.stats?.areaStats);
            
            // Ensure areaStats exists and is an array
            const areaStats = props.stats?.areaStats || [];
            console.log('Raw areaStats:', areaStats);
            console.log('areaStats length:', areaStats.length);
            
            // Log each individual area stat to see the structure
            areaStats.forEach((stat, index) => {
                console.log(`Area ${index}:`, stat);
                console.log(`Area ${index} name:`, stat.area_name);
                console.log(`Area ${index} name type:`, typeof stat.area_name);
                console.log(`Area ${index} name toLowerCase:`, stat.area_name?.toLowerCase());
            });
            
            // Updated filtering logic with better debugging
            const filteredAreaStats = areaStats.filter(stat => {
                console.log('Filtering stat:', stat);
                console.log('stat.area_name:', stat.area_name);
                console.log('Has area_name:', !!stat.area_name);
                console.log('area_name toLowerCase:', stat.area_name?.toLowerCase());
                console.log('Is nasional:', stat.area_name?.toLowerCase() === 'nasional');
                
                // More robust filtering - check for area_name existence and not 'nasional'
                const hasAreaName = stat.area_name && stat.area_name.trim() !== '';
                const isNotNasional = stat.area_name?.toLowerCase().trim() !== 'nasional';
                const shouldInclude = hasAreaName && isNotNasional;
                
                console.log('Should include:', shouldInclude);
                return shouldInclude;
            });
            
            console.log('Filtered area stats:', filteredAreaStats);
            console.log('Filtered area stats length:', filteredAreaStats.length);
            
            // If no filtered stats, let's include all for debugging
            const chartData = filteredAreaStats.length > 0 ? filteredAreaStats : areaStats;
            console.log('Chart data to use:', chartData);
            
            const nationalStat = areaStats.find(stat => 
                stat.area_name && stat.area_name.toLowerCase().trim() === 'nasional'
            );
            
            const nationalStats = {
                satisfaction: nationalStat?.avg_satisfaction || props.stats?.averageSatisfaction || 'N/A',
                relevance: nationalStat?.avg_relevance || props.stats?.averageRelevance || 'N/A'
            };

            console.log('National stats:', nationalStats);

            const createChart = (ctx, data, label, color) => {
                console.log(`Creating ${label} chart with data:`, data);
                
                // Check if we have data
                if (!data || data.length === 0) {
                    console.warn(`No data available for ${label} chart`);
                    return null;
                }

                // Check if all data points are zero
                const hasNonZeroData = data.some(value => value > 0);
                if (!hasNonZeroData) {
                    console.warn(`All data points are zero for ${label} chart`);
                }

                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.map(stat => stat.area_name || 'Unknown'),
                        datasets: [{
                            label: label,
                            data: data,
                            backgroundColor: color.background,
                            borderColor: color.border,
                            borderWidth: 2,
                            borderRadius: 8,
                            barPercentage: 0.8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: `${label} by Area`
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 5,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            };

            onMounted(() => {
                console.log('Component mounted, creating charts...');
                console.log('chartData in onMounted:', chartData);
                
                // Create charts if we have any data (filtered or all)
                if (chartData.length > 0) {
                    console.log('Creating charts with', chartData.length, 'areas');
                    
                    // Create satisfaction chart
                    if (satisfactionChart.value) {
                        const satisfactionCtx = satisfactionChart.value.getContext('2d');
                        const satisfactionData = chartData.map(stat => {
                            console.log('Satisfaction data for', stat.area_name, ':', stat.avg_satisfaction);
                            return parseFloat(stat.avg_satisfaction) || 0;
                        });
                        console.log('Final satisfaction data:', satisfactionData);
                        
                        const satisfactionChartInstance = createChart(satisfactionCtx, satisfactionData, 'Satisfaction Rating', {
                            background: 'rgba(75, 192, 192, 0.6)',
                            border: 'rgba(75, 192, 192, 1)'
                        });
                        if (satisfactionChartInstance) {
                            charts.push(satisfactionChartInstance);
                        }
                    }

                    // Create relevance chart
                    if (relevanceChart.value) {
                        const relevanceCtx = relevanceChart.value.getContext('2d');
                        const relevanceData = chartData.map(stat => {
                            console.log('Relevance data for', stat.area_name, ':', stat.avg_relevance);
                            return parseFloat(stat.avg_relevance) || 0;
                        });
                        console.log('Final relevance data:', relevanceData);
                        
                        const relevanceChartInstance = createChart(relevanceCtx, relevanceData, 'Relevance Rating', {
                            background: 'rgba(54, 162, 235, 0.6)',
                            border: 'rgba(54, 162, 235, 1)'
                        });
                        if (relevanceChartInstance) {
                            charts.push(relevanceChartInstance);
                        }
                    }
                } else {
                    console.warn('No area data available for charts');
                    console.log('Available data:', {
                        areaStats,
                        filteredAreaStats,
                        chartData,
                        statsDebug: props.stats?.debug
                    });
                }
            });

            const handleSearch = () => {
                router.get('/admin/feedback', {
                    q: search.value,
                });
            }

            return {
                search,
                handleSearch,
                index,
                satisfactionChart,
                relevanceChart,
                nationalStats,
                filteredAreaStats: chartData // Return the data we're actually using
            }
        }
    }
</script>

<style>

</style>