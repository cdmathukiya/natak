<template>
    <Head title="Team Create" />
    <Breadcrum :breadcrum="breadcrum" />
    <div class="flex lg:flex-nowrap flex-wrap gap-5">
        <div class="w-full">
            <div class="py-5 px-1 space-y-6 bg-white dark:bg-white/[0.03] border border-gray-200 rounded-2xl dark:border-gray-800">
                <form @submit.prevent="submit()" enctype="multipart/form-data">
                    <div class="flex flex-wrap gap-y-3">
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="team_id" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Select Team<span class="text-error-500">*</span>
                            </label>
                            <div class="relative z-20 bg-transparent">
                                <select v-model="form.team_id" id="team_id"  @change="getTeamDetails" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                                    <option value="" :disabled="teamAvailable?.team_id">Select</option>
                                    <option v-if="teamAvailable?.team_id" :value="teamAvailable?.team_id" selected>{{ teamAvailable?.team.name }}</option>
                                    <option v-for="(value, key) in teams" :value="key" :key="key" :selected="auth?.user.role !== 'admin'">{{ value }}</option>
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
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="date" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Date<span class="text-error-500">*</span>
                            </label>
                            <input type="date" id="date" v-model="form.date" onclick="this.showPicker()" :min="today"  :disabled="is_edit" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            <p v-if="form.errors?.date" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.date }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2" v-if="team?.user">
                            <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                                Name: {{ team?.user?.name }}
                            </h4>
                            <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                                Phone: {{ team?.user?.phone }}
                            </h4>
                        </div>
                        <div class="h-px mx-2.5 w-full bg-gray-200 dark:bg-gray-800"></div>
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-t border-gray-100 dark:border-white/[0.05] text-left">
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Name</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Role</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(member, index) in form.members" class="border-t border-gray-100 dark:border-white/[0.05]">
                                    <input type="hidden" v-model="member.member_id">
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                            <input type="text" v-model="member.name" placeholder="Enter name" class="dark:bg-dark-900 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                        </p>
                                        <p v-if="form.errors?.[`members.${index}.name`]" class="text-theme-xs text-error-500 mt-1.5">
                                            {{ form.errors?.[`members.${index}.name`] }}
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                            <input type="text" v-model="member.role" placeholder="Enter role" class="dark:bg-dark-900 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                                        </p>
                                        <p v-if="form.errors?.[`members.${index}.role`]" class="text-theme-xs text-error-500 mt-1.5">
                                            {{ form.errors?.[`members.${index}.role`] }}
                                        </p>
                                    </td>
                                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                            <label class="flex cursor-pointer items-center gap-3 text-medium font-medium text-gray-800 select-none dark:text-white/90">
                                                <div class="relative">
                                                    <input @change="form.members[index].is_available = !form.members[index].is_available" type="checkbox" class="sr-only"/>
                                                    <div :class="form.members[index].is_available ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'" class="block h-6 w-11 rounded-full"></div>
                                                    <div :class="form.members[index].is_available ? 'translate-x-full rtl:-translate-x-full' : 'translate-x-0'" class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear"></div>
                                                </div>
                                                {{ form.members[index].is_available ? 'Yes' : 'No' }}
                                            </label>
                                        </p>
                                        <p v-if="form.errors?.[`members.${index}.is_available`]" class="text-theme-xs text-error-500 mt-1.5">
                                            {{ form.errors?.[`members.${index}.is_available`] }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="w-full px-2.5">
                            <p v-if="form.errors && Object.values(form?.errors).length >= 0" class="text-error-500 mt-1.5">
                                {{ Object.values(form.errors)[0] }}
                            </p>
                            <button type="submit" class="flex items-center justify-center w-full gap-2 p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600">
                                Save
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.98481 2.44399C3.11333 1.57147 1.15325 3.46979 1.96543 5.36824L3.82086 9.70527C3.90146 9.89367 3.90146 10.1069 3.82086 10.2953L1.96543 14.6323C1.15326 16.5307 3.11332 18.4291 4.98481 17.5565L16.8184 12.0395C18.5508 11.2319 18.5508 8.76865 16.8184 7.961L4.98481 2.44399ZM3.34453 4.77824C3.0738 4.14543 3.72716 3.51266 4.35099 3.80349L16.1846 9.32051C16.762 9.58973 16.762 10.4108 16.1846 10.68L4.35098 16.197C3.72716 16.4879 3.0738 15.8551 3.34453 15.2223L5.19996 10.8853C5.21944 10.8397 5.23735 10.7937 5.2537 10.7473L9.11784 10.7473C9.53206 10.7473 9.86784 10.4115 9.86784 9.99726C9.86784 9.58304 9.53206 9.24726 9.11784 9.24726L5.25157 9.24726C5.2358 9.20287 5.2186 9.15885 5.19996 9.11528L3.34453 4.77824Z" fill=""></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
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
    props: {
        is_edit:Boolean,
        auth:Object,
        teams: Object,
        teamAvailable:Object,
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
            form : {
                team_id: this.teamAvailable?.team_id ?? '',
                date: this.teamAvailable?.date ?? '',
                members: (this.teamAvailable?.members ?? []),
            },
            team: this.teamAvailable?.team || [],
            memberIndex: null,
            today: new Date().toISOString().split('T')[0]
        }
    },
    mounted() {
        this.getTeamDetails()
    },
    methods : {
        submit() {
            console.log(this.form.members)
            let url = route('team_available.save');
            if(this.teamAvailable?.id) {
                url = route('team_available.update', this.teamAvailable.id);
                this.form._method = 'put';
            }
            this.form.errors = {},
            router.post(url, this.form, {
                onSuccess: () => {
                },
                onError: (errors) => {
                    this.form.errors = errors;
                    console.log(this.form);
                },
            });
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
                this.form.members = [...res.data.members];
            } else {
                this.team = [];
                this.form.members = [];
            }
        },  
    }
}

</script>