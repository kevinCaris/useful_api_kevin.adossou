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
                    <td class="py-4 px-6 border-b border-gray-200">
                        <label
                            class="relative inline-flex items-center cursor-pointer"
                        >
                            <input
                                v-model="active"
                                v-on="toggleElement(module)"
                                type="checkbox"
                                value=""
                                class="sr-only peer"
                            />
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
                            ></div>
                            <span
                                class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >Toggle me</span
                            >
                        </label>
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

const toggleElement=(data)=>{
    active= data
    console.log("data",active)
    if (active) {
      console.log('La checkbox est cochée');
    } else {
      console.log('La checkbox n\'est pas cochée');
    }
}
</script>
