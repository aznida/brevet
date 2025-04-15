<template>
  <AdminLayout>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Performance Assessment: {{ assessment.name }}</h1>
      
      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <span>Assessment Details</span>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <strong>Description:</strong> {{ assessment.description || 'N/A' }}
          </div>
          <div class="row">
            <div class="col-md-6">
              <strong>Start Date:</strong> {{ formatDate(assessment.start_date) }}
            </div>
            <div class="col-md-6">
              <strong>End Date:</strong> {{ formatDate(assessment.end_date) }}
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <span>Assigned Assessments</span>
            <Link 
              :href="route('admin.performance_assessments.assign', assessment.id)"
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
              <tr v-for="assignment in assignedAssessments" :key="assignment.id">
                <td>{{ assignment.assessor.name }}</td>
                <td>{{ assignment.assessee.name }}</td>
                <td>
                  <span :class="`badge bg-${getStatusColor(assignment.status)}`">
                    {{ assignment.status }}
                  </span>
                </td>
                <td>
                  <!-- Add action buttons here if needed -->
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

const props = defineProps({
  assessment: Object,
  assignedAssessments: Array,
});

const formatDate = (dateString) => {
  return format(new Date(dateString), 'MMM dd, yyyy');
};

const getStatusColor = (status) => {
  switch(status) {
    case 'pending': return 'warning';
    case 'completed': return 'success';
    default: return 'secondary';
  }
};
</script>