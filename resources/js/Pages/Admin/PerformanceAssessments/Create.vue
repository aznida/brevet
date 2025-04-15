<template>
    <AdminLayout>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Create Performance Assessment</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" v-model="form.name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Area</label>
                            <select class="form-select" v-model="form.area_id" required>
                                <option value="">Select Area</option>
                                <option v-for="area in areas" :key="area.id" :value="area.id">
                                    {{ area.title }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" v-model="form.description"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" v-model="form.start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" v-model="form.end_date" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Assessment</button>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';

defineProps({
    areas: Array
});

const form = useForm({
    name: '',
    area_id: '',
    description: '',
    start_date: '',
    end_date: ''
});

const submit = () => {
    form.post('/admin/performance_assessments');
};
</script>