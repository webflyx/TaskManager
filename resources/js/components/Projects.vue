<script setup>
import Auth from "../helpers/auth.js";
import {ref} from "vue";
import Pagination from "./UI/Pagination.vue";
import ProjectForm from "./UI/Project/ProjectForm.vue";

let projectsData = ref({});
let currentPage = ref(1);
let beforePage = ref(1);

function getProjects() {
    axios
        .get('/api/v1/projects', [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            projectsData.value = response.data;
            currentPage.value = response.data.meta.curr_page
        })
        .catch((error) => {
            console.log(error.response.data);
        });
}

getProjects();

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

function handlePageChange(pageNumber) {
    beforePage.value = currentPage.value;
    currentPage.value = pageNumber;

    if(pageNumber <= projectsData.value?.meta?.total_pages && pageNumber > 0 && pageNumber != beforePage.value){
        paginate(pageNumber);

    }
}

function paginate(nextPage) {
    axios
        .get('/api/v1/projects?page=' + nextPage, [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            projectsData.value = response.data;
            currentPage.value = response.data.meta.curr_page
        })
        .catch((error) => {
            console.log(error.response.data);
        });
}

let createProject = ref(false);
function toggleCreateProject() {
    createProject.value = !createProject.value;
}
</script>

<template>
    <div class="bg-white px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <h1 class="text-2xl text-bold border-b-2 pb-2">Projects</h1>
            <ul role="list" class="divide-y divide-gray-100">
                <li v-for="project in projectsData.projects" :key="project.id"
                    class="flex justify-between gap-x-6 py-5">
                    <router-link :to="{name: 'project', params: {id: project.id}}">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">{{ project.title }}</p>
                                <p class="mt-1  text-xs leading-5 text-gray-500">{{ project.description }}</p>
                                <p v-if="project.created_at" class="mt-1 text-xs leading-5 text-gray-500">
                                    Created
                                    <time :datetime="formatDate(project.created_at)">{{
                                            formatDate(project.created_at)
                                        }}
                                    </time>
                                </p>
                            </div>
                        </div>
                    </router-link>
                </li>
            </ul>

            <Pagination itemName="projects" :totalItems="projectsData.meta?.total_items"
                        :nextUrl="projectsData.links?.next_url"
                        :prevUrl="projectsData.links?.prev_url"
                        :totalPages="projectsData.meta?.total_pages"
                        :currentPage="projectsData.meta?.curr_page"
                        @page-change="handlePageChange"
            />


            <div class="mt-8 flex gap-8">
                <div @click="toggleCreateProject" class="text-sm bg-blue-400 text-white px-4 py-1 rounded cursor-pointer">
                    Create Project
                </div>
            </div>

            <div class="mt-8" v-if="createProject">
                <ProjectForm @sendForm="getProjects" type="create"  />
            </div>

        </div>
    </div>
</template>

<style scoped>

</style>
