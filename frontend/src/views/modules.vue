<template>
    <div class="shadow-lg rounded-lg overflow-hidden mx-4 md:mx-10 pt-5">
        <table class="w-full table-fixed">
            <thead>
                <tr class="bg-gray-100">
                    <th
                        class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase"
                    >
                        Name
                    </th>
                    <th
                        class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase"
                    >
                        description
                    </th>
                    <th
                        class="w-1/4 py-4 px-6 text-left text-gray-600 font-bold uppercase"
                    >
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white" v-for="module in modulesStore.modules" :key="module.id">
                <tr>
                    <td class="py-4 px-6 border-b border-gray-200">
                        {{ module.name }}
                    </td>
                    <td class="py-4 px-6 border-b border-gray-200 truncate">
                        {{ module.description }}
                    </td>
                        <td class="p-3 px-5 flex justify-end">
                        <button type="button" @click="handleActivate(module)"
                            class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">activate</button>
                        <button type="button" @click="handleDesa(module)"
                            class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Détactivate</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { useModuleStore } from "@/stores/moduleStore";
import { onMounted, ref } from "vue";

const modulesStore = useModuleStore();
let active=ref(null)


onMounted(async () => {
    modulesStore.AllModules();
});


const handleActivate=(data)=>{
    modulesStore.activateModules(data.id)
}
const handleDesa=(data)=>{
    modulesStore.deactivateModules(data.id)
}
</script>
