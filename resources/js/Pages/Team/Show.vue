<template>
    <Head title="Team Create" />
    <Breadcrum :breadcrum="breadcrum" />
    <div class="flex lg:flex-nowrap flex-wrap gap-5">
        <div class="w-full">
            <div class="py-5 px-1 space-y-6 bg-white dark:bg-white/[0.03] border border-gray-200 rounded-2xl dark:border-gray-800">
                <div class="flex flex-wrap gap-y-3">
                    <div class="w-full px-2.5 xl:w-1/3">
                        <h4 class="mb-2 text-center text-lg font-semibold text-gray-500 xl:text-left dark:text-white/70">
                            Team Name: <span class="text-gray-800 dark:text-white/90">{{ team.name }}</span>
                        </h4>
                    </div>
                    <div class="w-full px-2.5 xl:w-1/3">
                        <h4 class="mb-2 text-center text-lg font-semibold text-gray-500 xl:text-left dark:text-white/70">
                            Kendra: <span class="text-gray-800 dark:text-white/90">{{ team.kendra }}</span>
                        </h4>
                    </div>
                    <div class="w-full px-2.5 xl:w-1/3" v-if="team?.user">
                        <h4 class="mb-2 text-center text-lg font-semibold text-gray-500 xl:text-left dark:text-white/70">
                            Name: <span class="text-gray-800 dark:text-white/90">{{ team?.user?.name }}</span>
                        </h4>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4">
                    <!-- First table (4 columns wide) -->
                    <div class="col-span-4">
                        <h2 class="text-xl mx-2.5 font-semibold text-gray-800 dark:text-white/90 w-full my-2">Team Members</h2>
                        <table class="min-w-full border">
                            <thead>
                                <tr class="border-t border-gray-100 dark:border-white/[0.05] text-left">
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Sr No</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Members Name</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Members Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- {{ team }} -->
                                <tr v-for="(member, index) in team?.members" :key="member.id" class="border-t border-gray-100 dark:border-white/[0.05]">
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05] w-1/5">
                                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                            {{ index + 1 }}
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                            {{ member.name }}
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                            {{ member.role }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Second table (8 columns wide) -->
                    <div class="col-span-8">
                        <h2 class="text-xl mx-2.5 font-semibold text-gray-800 dark:text-white/90 w-full my-2">Spots</h2>
                        <table class="min-w-full border">
                            <thead>
                                <tr class="border-t border-gray-100 dark:border-white/[0.05] text-left">
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Sr No</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Date</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Spots Name</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300 text-end">children</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300 text-end">Women</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300 text-end">Men</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300 text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(available, aIndex) in team?.team_available" :key="available.id">
                                    <tr v-for="(spot, index) in available.spots" :key="spot.id" class="border-t border-gray-100 dark:border-white/[0.05]">
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05] w-1/11">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ index + 1 }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ spot.date }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ spot.spots_name }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05] text-end">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ spot.children }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05] text-end">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ spot.women }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05] text-end">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ spot.men }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05] font-semibold text-end">
                                            <p class="text-gray-800 text-theme-sm dark:text-white">
                                                {{ Number(spot.women) + Number(spot.men) + Number(spot.children) }}
                                            </p>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot class="border-t border-gray-100 dark:border-white/[0.05] text-end">
                                <tr class="border-t border-gray-100 dark:border-white/[0.05]">
                                    <td colspan="3" class="p-1 border border-gray-100 dark:border-white/[0.05] font-semibold">
                                        <p class="text-gray-800 text-theme-sm dark:text-white">
                                            Total
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05] font-semibold">
                                        <p class="text-gray-800 text-theme-sm dark:text-white">
                                            {{ total.children }}
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05] font-semibold">
                                        <p class="text-gray-800 text-theme-sm dark:text-white">
                                        {{ total.women }}
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05] font-semibold">
                                        <p class="text-gray-800 text-theme-sm dark:text-white">
                                        {{ total.men }}
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05] font-semibold">
                                        <p class="text-gray-800 text-theme-sm dark:text-white">
                                        {{ total.children + total.women + total.men }}
                                        </p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import Layout from "@/Layout/MainLayout.vue";
import Breadcrum from "@/Components/Breadcrum.vue";

export default {
    layout: Layout,
    props: {
        team:Object,
    },
    components: {
        Head,
        Breadcrum,
    },
    data() {
        return {
            breadcrum: {
                currentPage: 'Team',
                previousPage: 'Dashboard',
                previousPageUrl: route('dashboard')
            },
        }
    },
    computed: {
        total() {
            let children = 0;
            let women = 0;
            let men = 0;

            this.team?.team_available?.forEach(available => {
                available.spots?.forEach(spot => {
                    children += Number(spot.children) || 0;
                    women += Number(spot.women) || 0;
                    men += Number(spot.men) || 0;
                });
            });

            return { children, women, men };
        }
    }
}

</script>