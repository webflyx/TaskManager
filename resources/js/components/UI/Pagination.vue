<script setup>
import {ChevronLeftIcon, ChevronRightIcon} from '@heroicons/vue/20/solid'

const props = defineProps({
    itemName: String,
    totalItems: Number,
    totalPages: Number,
    nextUrl: String,
    prevUrl: String,
    currentPage: Number
})

const emit = defineEmits([
    'page-change'
]);

function changePage(newPage) {
    if (newPage >= 1 && props.currentPage <= props.totalPages) {
        emit('page-change', newPage);
    }
}

</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#"
               class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#"
               class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Total
                    <span class="font-medium">{{ totalItems }}</span>
                    {{ ' ' }}
                    {{ itemName }}
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#"
                       @click.prevent="changePage(currentPage - 1)"
                       class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true"/>
                    </a>

                    <template v-if="totalPages > 5">
                        <template v-for="(pageNumber, index) in totalPages" :key="index">
                            <a @click.prevent="changePage(pageNumber)"
                               v-if="pageNumber < 3  || pageNumber >= totalPages - 1 || currentPage + 1 === pageNumber ||  currentPage - 1 === pageNumber || currentPage === pageNumber"
                               :class="{ 'bg-indigo-600 text-white': pageNumber === currentPage }"
                               href="#" aria-current="page"
                               class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                {{ pageNumber }}
                            </a>
                            <div v-else v-if="(pageNumber === currentPage + 2) || (pageNumber === currentPage - 2 )"
                                 class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                ...
                            </div>
                        </template>
                    </template>
                    <template v-else>
                        <template v-for="(pageNumber, index) in totalPages" :key="index">
                            <a @click.prevent="changePage(pageNumber)"
                               :class="{ 'bg-indigo-600 text-white': pageNumber === currentPage }"
                               href="#" aria-current="page"
                               class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                {{ pageNumber }}
                            </a>
                        </template>
                    </template>

                    <a href="#"
                       @click.prevent="changePage(currentPage + 1)"
                       class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true"/>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
