<template>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <!-- Per page selector -->
        <div class="d-flex align-items-center" v-if="showPerPage">
            <span class="me-2">Show:</span>
            <select class="form-select form-select-sm" v-model="perPage" @change="changePerPage">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="all">All</option>
            </select>
        </div>
        <div v-else></div>
        
        <!-- Pagination links -->
        <nav>
            <ul :class="`pagination pagination-sm justify-content-${align} mb-0`">
                <li :class="[
                        'page-item', 
                        link.url == null ? 'disabled' : '',
                        link.active ? 'active' : '',
                    ]" 
                    v-for="(link, index) in links" :key="index">
                    <Link 
                        class="page-link" 
                        :href="link.url === null ? '#' : preserveQueryParams(link.url)" 
                        v-html="link.label">
                    </Link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import { router } from '@inertiajs/vue3';

    export default {
        props: {
            links: Array,
            align: {
                type: String,
                default: 'end'
            },
            showPerPage: {
                type: Boolean,
                default: false
            },
            filters: {
                type: Object,
                default: () => ({})
            }
        },

        components: {
            Link,
        },

        setup(props) {
            const perPage = ref(props.filters.per_page || '10');

            const preserveQueryParams = (url) => {
                if (!url) return '#';
                
                const urlObj = new URL(url);
                const currentUrl = new URL(window.location.href);
                
                // Copy all current query parameters except 'page' and 'per_page'
                currentUrl.searchParams.forEach((value, key) => {
                    if (key !== 'page' && key !== 'per_page') {
                        urlObj.searchParams.set(key, value);
                    }
                });
                
                // Set per_page parameter
                if (perPage.value) {
                    urlObj.searchParams.set('per_page', perPage.value);
                }
                
                return urlObj.href;
            };

            const changePerPage = () => {
                // Get current URL and preserve all existing query parameters
                const currentUrl = new URL(window.location.href);
                const params = {};
                
                // Copy all current query parameters except 'page' and 'per_page'
                currentUrl.searchParams.forEach((value, key) => {
                    if (key !== 'page' && key !== 'per_page') {
                        params[key] = value;
                    }
                });
                
                // Add per_page parameter and reset to page 1
                params.per_page = perPage.value;
                params.page = 1;
                
                // Navigate to the new URL with all parameters
                router.get(window.location.pathname, params);
            };

            return {
                perPage,
                preserveQueryParams,
                changePerPage
            };
        }
    }
</script>

<style>
.pagination .page-link {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>