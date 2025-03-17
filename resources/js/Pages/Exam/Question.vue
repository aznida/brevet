<template>
    <div v-if="question.question_type === 'rating_scale'" class="rating-scale-container">
        <div class="stars">
            <template v-for="n in 6" :key="n">
                <input 
                    type="radio" 
                    :name="'rating_' + question.id" 
                    :id="'rating_' + question.id + '_' + n"
                    :value="n"
                    v-model="selectedRating"
                    class="star-input"
                >
                <label 
                    :for="'rating_' + question.id + '_' + n" 
                    class="star-label"
                    :title="getRatingLabel(n)"
                >★</label>
            </template>
        </div>
        <div class="scale-description mt-2">
            <small class="text-muted">{{ getRatingLabel(selectedRating) }}</small>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const selectedRating = ref(0);

const getRatingLabel = (value) => {
    const labels = {
        1: 'Sangat Jarang',
        2: 'Jarang',
        3: 'Kadang-kadang',
        4: 'Sering',
        5: 'Sangat Sering',
        6: 'Selalu'
    };
    return labels[value] || 'Belum dipilih';
};
</script>

<style scoped>
.rating-scale-container {
    padding: 20px;
    text-align: center;
}

.stars {
    display: inline-flex;
    flex-direction: row-reverse;
    gap: 0.3rem;
}

.star-input {
    display: none;
}

.star-label {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}

.star-input:checked ~ .star-label {
    color: #ffd700;
}

.star-label:hover,
.star-label:hover ~ .star-label {
    color: #ffed4a;
}

.stars:hover .star-input:checked ~ .star-label {
    color: #ddd;
}

.stars:hover .star-input:checked + .star-label {
    color: #ffd700;
}
</style>