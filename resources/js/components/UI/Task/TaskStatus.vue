<script setup>
defineProps({
    status: String
})


const Status = (function () {
    const statuses = {
        progress: 'Progress',
        complete: 'Complete',
        new: 'New'
    }
    return {
        get: function (status) {
            return statuses[status];
        }
    };
})();
</script>

<template>
<span class="text-xs border border-black rounded px-2 py-1"
      :class="{
       'bg-gray-300': status === 'new',
       'bg-green-300': status === 'complete',
       'bg-blue-300': status === 'progress',
         }">
      {{Status.get(status)}}
</span>
</template>

<style scoped>

</style>
