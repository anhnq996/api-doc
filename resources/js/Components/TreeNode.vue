<template>
    <li>
        <div v-if="node.type === 'Dir'">
            <button type="button"
                    :class="'flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 ' + padding"
                    aria-controls="dropdown-example" :data-collapse-toggle="node.child.length ? ('sub-menu-' + node.uuid) : null">
                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path
                        d="M4.09 7.586A1 1 0 0 1 5 7h13V6a2 2 0 0 0-2-2h-4.557L9.043.8a2.009 2.009 0 0 0-1.6-.8H2a2 2 0 0 0-2 2v14c.001.154.02.308.058.457L4.09 7.586Z"/>
                    <path
                        d="M6.05 9 2 17.952c.14.031.281.047.424.048h12.95a.992.992 0 0 0 .909-.594L20 9H6.05Z"/>
                </svg>
                <span class="flex-1 ml-3 text-left text-sm font-semibold text-zinc-900 dark:text-white">{{
                        node.name
                    }}</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            <ul v-if="node.child.length" :id="'sub-menu-' + node.uuid" :class="hidden + ' py-2 space-y-2'">
                <tree-node v-for="(child, index) in node.child" :key="child.uuid" :node="child"></tree-node>
            </ul>
        </div>
        <div v-else>
            <a :href="node.path"
                    class="flex items-center w-full p-2 pl-11 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 20">
                    <path stroke="currentColor" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="2"
                          d="M4.828 10h6.239m-6.239 4h6.239M6 1v4a1 1 0 0 1-1 1H1m14-4v16a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2Z"/>
                </svg>
                <span
                    class="flex-1 ml-3 text-left text-sm text-zinc-600 hover:text-[#15B881] dark:text-zinc-400 dark:hover:text-white">{{
                        node.name
                    }}</span>
            </a>
        </div>
    </li>
</template>

<script>
export default {
    props: {
        node: {
            type: Object,
            required: true
        }
    },
    name: 'tree-node',
    beforeMount() {
        switch (this.node.level) {
            case 1:
                this.padding = 'pl-0'
                this.hidden = ''
                break
            case 2:
                this.padding = 'pl-6'
                this.hidden = 'hidden'
                break
            case 3:
                this.padding = 'pl-11'
                this.hidden = 'hidden'
                break
            default:
                this.padding = 'pl-0'
                break
        }

    }
}
</script>
