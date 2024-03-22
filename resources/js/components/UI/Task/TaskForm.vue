<script setup>
import {ref} from "vue";
import Select from "../Select.vue";
import {useRoute} from 'vue-router'

const route = useRoute();

const props = defineProps({
    type: String, // create or edit
    task: {
        type: Object,
        default: {
            'title': '',
            'description': '',
            'status': 'new',
        }
    }
})

const emit = defineEmits([
    'sendForm'
])

const emitSend = () => {
    emit('sendForm', true)
}

const projectId = route.params.id
const taskId = route.params.taskId

let taskData = ref({
    'title': props.task.title,
    'description': props.task.description,
    'status': props.task.status,
})

let errorsBag = ref({});
let successMsg = ref('');

let apiUrl = '/api/v1/projects/' + projectId + '/tasks/' + taskId;
let apiMethod = 'patch';

if(props.type === 'create') {
    apiUrl = '/api/v1/projects/' + projectId + '/tasks';
    apiMethod = 'post'
}


const statusList = [
    { name: 'New', value: 'new' },
    { name: 'Progress', value: 'progress' },
    { name: 'Complete', value: 'complete' }
];

let selectOption = ref(statusList.find(item => item.value === props.task.status));

function sendForm() {
    axios
        [apiMethod](apiUrl, taskData.value)
        .then(response => {
            successMsg.value = response.data.message;
            emitSend();

            if(props.type === 'create') {
                taskData.value.title = ''
                taskData.value.description = ''
            }
        })
        .catch((error) => {
            errorsBag.value = error.response.data.errors;
        });
}

</script>

<template>
    <form class="space-y-6 mt-8 border border-gray-200 p-4 rounded shadow" action="#" method="POST">
        <div>
            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
            <div class="mt-2">
                <input v-model="taskData.title" id="title" name="title" type="text"
                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
            <div class="mt-2">
                <textarea v-model="taskData.description" id="description" name="description"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </textarea>
            </div>
        </div>

        <Select :selected="selectOption"
                :options="statusList"
                @selectOption="taskData.status = $event.value" label="Status"
                name="status"/>

        <div class="text-bold text-green-700" v-if="successMsg">
            {{successMsg}}
        </div>

        <div>
            <button v-if="props.type === 'edit'" type="submit" @click.prevent="sendForm"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Edit
            </button>
            <button v-if="props.type === 'create'" type="submit" @click.prevent="sendForm"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Create
            </button>
        </div>

        <div v-if="errorsBag.error" class="my-2 text-start text-red-500">
            {{ errorsBag.error }}
        </div>
        <div v-else class="my-2 text-start text-red-500">
            <div v-for="error in errorsBag">
                {{ error[0] }}
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
