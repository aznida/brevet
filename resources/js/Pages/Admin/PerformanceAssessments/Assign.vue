<template>
    <AdminLayout>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Assign Assessors</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label">Assessor</label>
                            <select class="form-select" v-model="form.assessor_id" required>
                                <option value="">Select Assessor</option>
                                <option v-for="participant in areaParticipants" :key="participant.id" :value="participant.id">
                                    {{ participant.name }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assessee</label>
                            <select class="form-select" v-model="form.assessee_id" required>
                                <option value="">Select Assessee</option>
                                <option v-for="participant in areaParticipants" :key="participant.id" :value="participant.id"
                                    :disabled="participant.id === form.assessor_id">
                                    {{ participant.name }}
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" :disabled="!isFormValid">
                            Assign
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/Admin.vue';

const props = defineProps({
    assessment: {
        type: Object,
        required: true
    },
    participants: {
        type: Array,
        required: true,
        default: () => []
    }
});

const form = useForm({
    assessor_id: '',
    assessee_id: ''
});

const areaParticipants = computed(() => {
    return props.participants.filter(p => p.area_id === props.assessment.area_id);
});

const isFormValid = computed(() => {
    return form.assessor_id && form.assessee_id && form.assessor_id !== form.assessee_id;
});

const submit = () => {
    form.post(`/admin/performance_assessments/${props.assessment.id}/store-assessor`);
};
</script>