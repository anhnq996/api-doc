<template>
    <div class="h-screen">
        <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
                aria-controls="sidebar-multi-level-sidebar" type="button"
                class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd"
                      d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>

        <aside id="sidebar-multi-level-sidebar"
               class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
               aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                <ul class="space-y-2 font-medium">
                    <tree-node v-for="(item, index) in menus" :key="index" :node="item"></tree-node>
                </ul>
            </div>
        </aside>

        <div class="sm:ml-64 h-screen">
            <div class="dark:border-gray-700 h-full">
                <div class="grid grid-cols-5 h-full p-8 pt-0 pr-1">
                    <div class="col-span-3 p-4 h-full">
                        <h1 class="mb-8 title">{{ props.data?.name }}</h1>
                        <p class="mt-8 mb-8 text-gray-500 dark:text-gray-400" v-html="description"></p>
                        <hr/>
                        <h2 class="mt-8 mb-8 text-lg font-medium font-bold">HTTP Request</h2>
                        <div class="bg-[#F2F9FE] p-4 mb-4 text-gray-500 rounded-lg shadow">
                            <div class="ml-3 text-sm font-bold text-[#15B881]">
                                <span class="mr-4">{{ apiMethod }}</span>
                                {{ apiUrl }}
                            </div>
                        </div>

                        <h2 class="mt-8 mb-8 text-lg font-medium font-bold">Parameter</h2>

                        <div class="relative overflow-x-auto sm:rounded-lg mt-5">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Field
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Required
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Min
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Max
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Note
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in parameter" :key="index"
                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ item.field }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ item.type }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.required }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.min || '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.max || '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ item.note || '-' }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <h2 class="mt-8 mb-8 text-lg font-medium font-bold">Response</h2>
                        <json-viewer
                            :value="response"
                            copyable
                            boxed
                            sort></json-viewer>
                    </div>
                    <div class="col-span-2 border-l-[0.5px] border-[#18181b1a] pl-2">
                        <div class="flex items-center justify-center self-center">
                            <input type="text" :value="apiUrl" readonly
                                   class="bg-gray-50 border border-gray-300 text-[#15B881] font-bold text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <button type="button" @click="sendApi"
                                    class="mt-2 ml-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                Send
                            </button>
                        </div>

                        <div
                            class="h-[300px] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="mb-1 border-b border-gray-200 dark:border-gray-700">
                                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab"
                                    data-tabs-toggle="#myTabContent" role="tablist">
                                    <li class="mr-2" role="presentation">
                                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                                                data-tabs-target="#profile" type="button" role="tab"
                                                aria-controls="profile"
                                                aria-selected="false">Body
                                        </button>
                                    </li>
                                    <li class="mr-2" role="presentation">
                                        <button
                                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                            id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                                            aria-controls="dashboard" aria-selected="false">Header
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div id="myTabContent">
                                <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                                     aria-labelledby="profile-tab">
                                    <div ref="headerEditorRef" style="height: 200px;"></div>
                                </div>
                                <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard"
                                     role="tabpanel"
                                     aria-labelledby="dashboard-tab">
                                    <div ref="bodyEditorRef" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                        <hr/>

                        <div
                            class="mt-2 h-[500px] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="mb-1 border-b border-gray-200 dark:border-gray-700">
                                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center"
                                    data-tabs-toggle="#responseTanContent" role="tablist">
                                    <li class="mr-2" role="presentation">
                                        <button class="inline-block p-4 border-b-2 rounded-t-lg"
                                                data-tabs-target="#response-body" type="button" role="tab"
                                                aria-controls="profile"
                                                aria-selected="false">Body
                                        </button>
                                    </li>
                                    <li class="mr-2" role="presentation">
                                        <button
                                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                            data-tabs-target="#response-header" type="button" role="tab"
                                            aria-controls="dashboard" aria-selected="false">Header
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div id="responseTanContent">
                                <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="response-body"
                                     role="tabpanel"
                                     aria-labelledby="profile-tab">

                                    <div class="inline-flex rounded-md shadow-sm" role="group">
                                        <button type="button"
                                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            Pretty
                                        </button>
                                        <button type="button"
                                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            Raw
                                        </button>
                                        <button type="button"
                                                class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-md hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                            Review
                                        </button>
                                    </div>
                                    <div class="relative h-full w-full">
                                        <div ref="resBodyEditorRef" :style="'height: 500px;' + (isLoadingApi ? 'display: none;' : '')"></div>
                                        <div role="status" :class="!isLoadingApi ? 'hidden' : '' + 'absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2'">
                                            <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>


                                </div>
                                <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="response-header"
                                     role="tabpanel"
                                     aria-labelledby="dashboard-tab">
                                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                            <thead
                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Key
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Value
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in responseHeader" :key="index"
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <td class="px-6 py-4">
                                                    {{ item.key }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.value }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>
<script setup>
import {ref, onMounted} from 'vue'
import {initFlowbite} from 'flowbite'

import 'brace'
import 'brace/mode/javascript'
import 'brace/theme/dracula'
import axios from "axios";
import TreeNode from '../Components/TreeNode.vue'

const props = defineProps({ menus: Array, data: Object })
console.log(props.data)
const apiMethod = props.data?.method
const apiDomain = props.data?.url
const apiPath = props.data?.path
const apiUrl = apiDomain + apiPath
const description = props.data?.description
const parameter = props.data?.body

const headerEditorRef = ref(null)
let headerEditor = null
let headers = JSON.stringify(props.data?.headers, null, 4);

const bodyEditorRef = ref(null)
let bodyEditor = null
let body = JSON.stringify(props.data?.sample_request, null, 4);

const resBodyEditorRef = ref(null)
let resBodyEditor = null
let responseData = ''
let responseHeader = ref([]);
let isLoadingApi = ref(false)
// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
    headerEditor = window.ace.edit(headerEditorRef.value)
    headerEditor.setTheme('ace/theme/dracula')
    headerEditor.getSession().setMode('ace/mode/javascript')
    headerEditor.setValue(headers, 1)

    bodyEditor = window.ace.edit(bodyEditorRef.value)
    bodyEditor.setTheme('ace/theme/dracula')
    bodyEditor.getSession().setMode('ace/mode/javascript')
    bodyEditor.setValue(body, 1)

    resBodyEditor = window.ace.edit(resBodyEditorRef.value)
    resBodyEditor.setTheme('ace/theme/dracula')
    resBodyEditor.getSession().setMode('ace/mode/javascript')
    resBodyEditor.setValue(responseData, 1)
})
const response = props.data?.sample_response || {}

const sendApi = () => {
    isLoadingApi.value = true
    switch (apiMethod) {
        case 'GET':
            axios.get(apiDomain + apiPath)
                .then(response => {
                    // handle success

                    responseData = JSON.stringify(response.data, null, 4);
                    responseHeader.value = []
                    Object.keys(response.headers).forEach(key => {
                        responseHeader.value.push({
                            key: key,
                            value: response.headers[key] || ''
                        })
                    });

                    resBodyEditor.setValue(responseData, 1)

                    console.log(responseData)
                    isLoadingApi.value = false
                })
                .catch(error => {
                    // handle error
                    isLoadingApi.value = false
                    responseData = '';
                })
                .finally(() => {
                    isLoadingApi.value = false
                })
            break;
        case 'POST':
            let config = {
                headers: JSON.parse(headers)
            };
            axios.post(apiDomain + apiPath, JSON.parse(body), config)
                .then(response => {
                    // handle success
                    responseData = JSON.stringify(response.data, null, 4);
                    responseHeader.value = []
                    Object.keys(response.headers).forEach(key => {
                        responseHeader.value.push({
                            key: key,
                            value: response.headers[key] || ''
                        })
                    });

                    resBodyEditor.setValue(responseData, 1)

                    isLoadingApi.value = false
                })
                .catch(error => {
                    // handle error
                    isLoadingApi.value = false
                    responseData = '';
                })
                .finally(() => {
                    isLoadingApi.value = false
                })
            break;
        default:
            break;
    }
}
</script>

<style scoped>

</style>
