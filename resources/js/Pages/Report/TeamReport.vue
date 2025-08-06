<template>
    <Head title="User Create" />
    <Breadcrum :breadcrum="breadcrum" />
    <div class="flex lg:flex-nowrap flex-wrap gap-5">
        <div class="w-full">
            <div class="py-5 px-1 space-y-6 bg-white dark:bg-white/[0.03] border border-gray-200 rounded-2xl dark:border-gray-800">
                <form @submit.prevent="search()" enctype="multipart/form-data">
                    <div class="flex flex-wrap gap-y-3">
                        <div class="w-full px-2.5 xl:w-1/4">
                            <label for="from_date" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                From Date<span class="text-error-500">*</span>
                            </label>
                            <input type="date" id="from_date" v-model="form.from_date" onclick="this.showPicker()" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <p v-if="form.errors?.from_date" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.from_date }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/4">
                            <label for="to_date" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                To Date<span class="text-error-500">*</span>
                            </label>
                            <input type="date" id="to_date" v-model="form.to_date" onclick="this.showPicker()" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <p v-if="form.errors?.to_date" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.to_date }}
                            </p>
                        </div>
                       <div class="w-full px-2.5 xl:w-1/4">
                            <label for="team_id" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Select Team<span class="text-error-500">*</span>
                            </label>
                            <div class="relative z-20 bg-transparent">
                                <select v-model="form.team_id" id="team_id" @change="getTeamDetails" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="">Select</option>
                                    <option v-for="(value, key) in teams" :value="key">{{ value }}</option>
                                </select>
                                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </div>
                            <p v-if="form.errors?.team_id" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.team_id }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/7">
                            <label>&nbsp;</label>
                            <button type="submit" class="flex items-center justify-center w-full gap-2 p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600">
                                Search
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.98481 2.44399C3.11333 1.57147 1.15325 3.46979 1.96543 5.36824L3.82086 9.70527C3.90146 9.89367 3.90146 10.1069 3.82086 10.2953L1.96543 14.6323C1.15326 16.5307 3.11332 18.4291 4.98481 17.5565L16.8184 12.0395C18.5508 11.2319 18.5508 8.76865 16.8184 7.961L4.98481 2.44399ZM3.34453 4.77824C3.0738 4.14543 3.72716 3.51266 4.35099 3.80349L16.1846 9.32051C16.762 9.58973 16.762 10.4108 16.1846 10.68L4.35098 16.197C3.72716 16.4879 3.0738 15.8551 3.34453 15.2223L5.19996 10.8853C5.21944 10.8397 5.23735 10.7937 5.2537 10.7473L9.11784 10.7473C9.53206 10.7473 9.86784 10.4115 9.86784 9.99726C9.86784 9.58304 9.53206 9.24726 9.11784 9.24726L5.25157 9.24726C5.2358 9.20287 5.2186 9.15885 5.19996 9.11528L3.34453 4.77824Z" fill=""></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="h-px mx-2.5 w-full bg-gray-200 dark:bg-gray-800"></div>
                <template v-for="(teamAvailable, index) in teamAvailables" :key="index">
                    <details class="group overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mx-2">
                        <summary class="group-open:bg-gray-50 group-open:dark:bg-white/[0.03] flex items-center justify-between p-3 cursor-pointer">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">{{ teamAvailable.team.name }} - {{ formatDate(teamAvailable.date) }}</h4>
                            <div class="w-50 flex justify-between items-center">
                                <p class="text-lg font-medium text-gray-800 dark:text-white/90">Leader: {{ teamAvailable.team.user.name }}</p>
                                <span class="group flex h-12 w-full max-w-12 items-center justify-center rounded-full bg-gray-100 duration-200 ease-linear dark:bg-white/[0.03] text-gray-500 dark:text-gray-400 group-open:text-gray-800 group-open:dark:text-white/90 group-open:rotate-180">
                                    <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </div>
                        </summary>
                        <div class="py-2 gap-y-2 flex flex-wrap dark:border-gray-800 m-2">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-t border-gray-100 dark:border-white/[0.05] text-left">
                                        <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Sr No</th>
                                        <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Name</th>
                                        <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Role</th>
                                        <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Available</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(member, index) in teamAvailable.members" class="border-t border-gray-100 dark:border-white/[0.05]">
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                            <p class="text-gray-700 dark:text-white">
                                                {{ index + 1 }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                            <p class="text-gray-700 dark:text-white">
                                                {{ member.name }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                            <p class="text-gray-700 dark:text-white">
                                                {{ member.role }}
                                            </p>
                                        </td>
                                        <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                            <p class="text-gray-700 dark:text-white">
                                                {{ member.is_available ? 'Yes' : 'No' }}
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </details>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, router } from "@inertiajs/vue3";
import Layout from "@/Layout/MainLayout.vue";
import Breadcrum from "@/Components/Breadcrum.vue";
import axios from "axios";

export default {
    layout: Layout,
    components: {
        Head,
        Breadcrum,
    },
    props: {
        teamAvailables:Object,
        teams: Object,
        date: Array,
    },
    data() {
        return {
            breadcrum: {
                currentPage: 'User',
                previousPage: 'Dashboard',
                previousPageUrl: route('dashboard')
            },
            form: {
                from_date: this.date.from_date || '',
                to_date: this.date.to_date || '',
                search: this.date.search || ''
            },
        }
    },
    methods: {
        search() {
            let url = route('teamReport');
            this.form.errors = {},
            this.$inertia.get(url, this.form, {
                preserveState: true,
            });
        },
        formatDate(dateStr) {
            if (!dateStr) return '';
            const [year, month, day] = dateStr.split('-');
            return `${day}/${month}/${year}`;
        },
        async getTeamDetails() {
            let url = route('get_team_details');

            if (this.form.team_id) {
                let res = await axios.get(url, {
                    params: {
                        team_id: this.form.team_id,
                    }
                });
                this.team = res.data || [];
            } else {
                this.team = [];
            }
        },  
    }
}
</script>