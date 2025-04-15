<script setup>
import { Link } from '@inertiajs/vue3';
import { format } from 'date-fns';
import AdminLayout from '@/Layouts/Admin.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    assessments: Array
});

const formatDate = (date) => {
    return format(new Date(date), 'MMM dd, yyyy');
};
</script>

<template>
    <AdminLayout>
        <div class="container-fluid px-4">
            <h1 class="mt-4">360 Performance Reviews</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Performance Assessments</span>
                        <Link href="/admin/performance_assessments/create" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Create New
                        </Link>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="assessment in assessments" :key="assessment.id">
                                <td>{{ assessment.name }}</td>
                                <td>{{ formatDate(assessment.start_date) }}</td>
                                <td>{{ formatDate(assessment.end_date) }}</td>
                                <td>
                                    <Link :href="`/admin/performance_assessments/${assessment.id}/assign`" 
                                        class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-user-plus"></i>
                                    </Link>
                                    <Link :href="`/admin/performance_assessments/${assessment.id}`" 
                                        class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>