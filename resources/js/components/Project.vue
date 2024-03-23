<script setup>
import {ref} from "vue";
import {useRoute} from 'vue-router'
import Auth from "../helpers/auth.js";
import Pagination from "./UI/Pagination.vue";
import TaskStatus from "./UI/Task/TaskStatus.vue";
import TaskDates from "./UI/Task/TaskDates.vue";
import TaskForm from "./UI/Task/TaskForm.vue";
import ProjectForm from "./UI/Project/ProjectForm.vue";
import router from "../routes.js";

const route = useRoute();
const projectId = route.params.id

let project = ref({});
let tasksData = ref({});
let currentPage = ref(1);
let beforePage = ref(1);


function getProject() {
    axios
        .get('/api/v1/projects/' + projectId, [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            project.value = response.data.project;
        })
        .catch((error) => {
            if(error.response.status >= 400) {
                router.push(Auth.check() ? {name: 'projects'} : {name: 'login'})
            }
            // console.log(error.response.data);
        });
}

function getTasks() {
    axios
        .get('/api/v1/projects/' + projectId + '/tasks', [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            tasksData.value = response.data;
            currentPage.value = response.data.meta.curr_page
        })
        .catch((error) => {
            // console.log(error.response.data);
        });
}

getProject();
getTasks();

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
}

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

function handlePageChange(pageNumber) {
    beforePage.value = currentPage.value;
    currentPage.value = pageNumber;

    if(pageNumber <= tasksData.value?.meta?.total_pages && pageNumber > 0 && pageNumber != beforePage.value){
        paginate(pageNumber);

    }
}

function paginate(nextPage) {
    axios
        .get('/api/v1/projects/' + projectId + '/tasks?page=' + nextPage, [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            tasksData.value = response.data;
            currentPage.value = response.data.meta.curr_page
        })
        .catch((error) => {
            console.log(error.response.data);
        });
}

let createTask = ref(false);
let updateProject = ref(false);
function toggleTaskCreate() {
    createTask.value = !createTask.value;
    updateProject.value = false;
}
function toggleUpdateProject() {
    updateProject.value = !updateProject.value;
    createTask.value = false;
}

function deleteProject() {
    axios
        .delete('/api/v1/projects/' + projectId, [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            router.push({name: 'projects'});
        })
        .catch((error) => {
            console.log(error.response.data);
        });
}
</script>

<template>
    <div class="bg-white px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <h1 class="text-2xl text-bold border-b-2 pb-2">Project: {{ project.title }}</h1>
            <div class="mt-4 text-sm text-gray-700" v-if="project.description">{{ project.description }}</div>

            <template v-if="tasksData?.tasks?.length > 0">
                <h2 class="text-xl text-bold mt-12 border-b-2 pt-2">Task List</h2>
                <ul role="list" class="divide-y divide-gray-100">
                    <li v-for="task in tasksData.tasks" :key="task.id" class="flex justify-between gap-x-6 py-5">
                        <router-link :to="{name: 'task', params: {id: project.id, taskId: task.id}}">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm leading-6 text-gray-900 flex items-center gap-8">
                                        <span class="font-semibold ">{{ task.title }}</span>
                                        <TaskStatus :status="task.status" />
                                    </p>
                                    <p class="mt-1  text-xs leading-5 text-gray-500">{{ task.description }}</p>
                                    <TaskDates :created="task.created_at" :updated="task.updated_at" />
                                </div>
                            </div>
                        </router-link>
                    </li>
                </ul>
            </template>

            <Pagination v-if="tasksData.meta?.total_pages > 1" itemName="tasks" :totalItems="tasksData.meta?.total_items"
                        :nextUrl="tasksData.links?.next_url"
                        :prevUrl="tasksData.links?.prev_url"
                        :totalPages="tasksData.meta?.total_pages"
                        :currentPage="tasksData.meta?.curr_page"
                        @page-change="handlePageChange"
            />


            <div class="mt-8 flex gap-8">
                <div @click="toggleTaskCreate" class="text-sm bg-blue-400 text-white px-4 py-1 rounded cursor-pointer">
                    Create Task
                </div>
                <div @click="toggleUpdateProject" class="text-sm bg-blue-400 text-white px-4 py-1 rounded cursor-pointer">
                    Update Project
                </div>
                <div @click="deleteProject" class="text-sm bg-red-400 text-white px-4 py-1 rounded cursor-pointer">
                    Delete Project
                </div>
            </div>

            <div class="mt-8" v-if="createTask">
                <TaskForm @sendForm="getTasks" type="create"  />
            </div>
            <div class="mt-8" v-if="updateProject">
                <ProjectForm @sendForm="getProject" :project="project" type="edit"  />
            </div>


        </div>
    </div>
</template>

<style scoped>

</style>
