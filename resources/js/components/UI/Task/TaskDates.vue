<script setup>

defineProps({
    created: String,
    updated: String
})

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}
</script>

<template>
    <div class="flex justify-between mt-4">
        <p v-if="created" class="mt-1 text-xs leading-5 text-gray-500">
            Created
            <time :datetime="formatDate(created)">{{ formatDate(created) }}</time>
        </p>
        <p v-if="updated" class="mt-1 text-xs leading-5 text-gray-500">
            Updated
            <time :datetime="formatDate(updated)">{{ formatDate(updated) }}</time>
        </p>
    </div>
</template>

<style scoped>

</style>
