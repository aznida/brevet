<template>
  <AdminLayout>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Assessment Details</h1>  
      <div class="card mb-4">
        <div class="card-body">
          <div class="mb-3">
            <div class="row">
              <div class="col-md-6">
                <strong>Name:</strong> {{ assessment.name }}
              </div>
              <div class="col-md-6">
                <strong>Description:</strong> {{ assessment.description || 'N/A' }}
              </div>
            </div>  <!-- Added missing closing div for row -->
            <div class="row">
              <div class="col-md-6">
                <strong>Start Date:</strong> {{ formatDate(assessment.start_date) }}
              </div>
              <div class="col-md-6">
                <strong>End Date:</strong> {{ formatDate(assessment.end_date) }}
              </div>
            </div>
          </div>  <!-- Added missing closing div for mb-3 -->
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <span>Assigned Assessments</span>
            <Link 
              :href="`/admin/performance_assessments/${assessment.id}/assign`"
              class="btn btn-primary btn-sm"
            >
              Assign New
            </Link>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Assessor</th>
                <th>Assessee</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="assignment in assessment.assessments" :key="assignment.id">
                <td>{{ assignment?.assessor?.name || 'N/A' }}</td>
                <td>{{ assignment?.assessee?.name || 'N/A' }}</td>
                <td>
                  <span :class="`badge bg-${getStatusColor(assignment?.status)}`">
                    {{ assignment?.status || 'N/A' }}
                  </span>
                </td>
                <td>
                  <!-- Actions -->
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import { Link } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { defineProps } from 'vue';

const props = defineProps({
    assessment: {
        type: Object,
        required: true
    }
});

// Update debug logs
console.log('Full Assessment Object:', props.assessment);
console.log('Assessments Array:', props.assessment?.assessments);

const formatDate = (date) => {
    if (!date) return 'N/A';
    try {
        const parsedDate = new Date(date);
        if (isNaN(parsedDate.getTime())) {
            return 'Invalid date';
        }
        return format(parsedDate, 'MMM d, yyyy');
    } catch {
        return 'Invalid date';
    }
};

const getStatusColor = (status) => {
    switch (status) {
        case 'pending':
            return 'warning';
        case 'completed':
            return 'success';
        case 'in_progress':
            return 'primary';
        case 'rejected':
            return 'danger';
        default:
            return 'secondary';
    }
};
</script>
