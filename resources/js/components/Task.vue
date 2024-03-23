<script setup>
import {ref} from "vue";
import {useRoute} from 'vue-router'
import Auth from "../helpers/auth.js";
import TaskDates from "./UI/Task/TaskDates.vue";
import TaskStatus from "./UI/Task/TaskStatus.vue";
import TaskForm from "./UI/Task/TaskForm.vue";
import router from "../routes.js";

const route = useRoute();
const projectId = route.params.id
const taskId = route.params.taskId

let task = ref({});

function getTask() {
    axios
        .get('/api/v1/projects/' + projectId + '/tasks/' + taskId, [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            task.value = response.data.task;

        })
        .catch((error) => {
            if(error.response.status  >= 400) {
                router.push(Auth.check() ? {name: 'projects'} : {name: 'login'})
            }
            // console.log(error.response.data);
        });
}
getTask();

let taskEdit = ref(false);

const toggletaskEdit = () => {
    taskEdit.value = !taskEdit.value;
};

function deleteTask() {
    axios
        .delete('/api/v1/projects/' + projectId + '/tasks/' + taskId, [], {
            "headers": {
                "Authorization": "Bearer " + Auth.token
            }
        })
        .then(response => {
            router.push({name: 'project', params: {id: projectId}});
        })
        .catch((error) => {
            console.log(error.response.data);
        });
}
</script>

<template>

    <div class="bg-white px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="border-b-2 pb-2 flex items-center justify-between">
                <h1 class="text-2xl text-bold ">Task: {{ task.title }}</h1>
                <TaskStatus :status="task.status"/>
            </div>
            <div class="mt-4 text-sm text-gray-700" v-if="task.description">{{ task.description }}</div>
            <TaskDates :created="task.created_at" :updated="task.updated_at"/>

            <div class="flex gap-4 mt-8">
                <div @click="toggletaskEdit" class="text-sm bg-blue-400 text-white px-4 py-1 rounded cursor-pointer">
                    Edit
                </div>
                <div @click="deleteTask" class="text-sm bg-red-400 text-white px-4 py-1 rounded cursor-pointer">Delete</div>
            </div>

            <div v-if="taskEdit" class="">
                <TaskForm @sendForm="getTask" type="edit" :task="task" />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
