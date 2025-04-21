<template>
    <AdminLayout>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Assign Assessors</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Update error message handling -->
                    <div v-if="form.errors.message" class="alert alert-danger">
                        {{ form.errors.message }}
                    </div>

                    <div class="card-body">
                        <div v-if="form.errors.duplicate" class="alert alert-danger">
                            {{ form.errors.duplicate }}
                        </div>
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
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    assessment: {
        type: Object,
        required: true
    },
    participants: {
        type: Array,
        required: true
    }
});

const form = useForm({
    assessor_id: '',
    assessee_id: ''
});

const areaParticipants = computed(() => {
    return props.participants.filter(p => p.area_id === props.assessment.area_id);
});

// Add this computed property to check for existing assignments
const existingAssignments = computed(() => {
    return props.assessment.assessments || [];
});

const isAssignmentExists = (assessorId, assesseeId) => {
    return existingAssignments.value.some(assignment => 
        assignment.assessor_id === assessorId && 
        assignment.assessee_id === assesseeId
    );
};

const isFormValid = computed(() => {
    return form.assessor_id && 
           form.assessee_id && 
           form.assessor_id !== form.assessee_id &&
           !isAssignmentExists(form.assessor_id, form.assessee_id);
});

const submit = () => {
    if (isAssignmentExists(form.assessor_id, form.assessee_id)) {
        form.setError('message', 'This assessment pair already exists.');
        return;
    }

    form.post(`/admin/performance_assessments/${props.assessment.id}/store-assessor`, {
        onSuccess: () => {
            form.reset();
        },
        preserveScroll: true,
        preserveState: true
    });
};

const availableAssessees = computed(() => {
    if (!form.assessor_id) return props.participants;
    return props.participants.filter(p => p.id !== form.assessor_id);
});
</script>