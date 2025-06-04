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
    import { ref, computed } from 'vue';

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
            
            // Ensure areaStats exists and is an array
            const areaStats = props.stats?.areaStats || [];
            
            // Get national statistics
            const nationalStats = computed(() => {
                const nationalStat = areaStats.find(stat => 
                    stat.area_name && stat.area_name.toLowerCase().trim() === 'nasional'
                );
                
                return {
                    satisfaction: nationalStat?.avg_satisfaction || props.stats?.averageSatisfaction || 'N/A',
                    relevance: nationalStat?.avg_relevance || props.stats?.averageRelevance || 'N/A'
                };
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
                nationalStats
            }
        }
    }
</script>

