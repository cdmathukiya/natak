<template>
    <Head title="Team Create" />
    <Breadcrum :breadcrum="breadcrum" />
    <div class="flex lg:flex-nowrap flex-wrap gap-5">
        <div class="w-full">
            <div class="py-5 px-1 space-y-6 bg-white dark:bg-white/[0.03] border border-gray-200 rounded-2xl dark:border-gray-800">
                <form @submit.prevent="submit()" enctype="multipart/form-data">
                    <div class="flex flex-wrap gap-y-3">
                        <div class="w-full px-2.5 xl:w-1/2">
                            <h4 class="mb-2 text-center text-lg font-semibold text-gray-500 xl:text-left dark:text-white/70">
                                Team Name: <span class="text-gray-800 dark:text-white/90">{{ teamAvailable?.team.name }}</span>
                            </h4>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <h4 class="mb-2 text-center text-lg font-semibold text-gray-500 xl:text-left dark:text-white/70">
                                Kendra: <span class="text-gray-800 dark:text-white/90">{{ teamAvailable?.team.kendra }}</span>
                            </h4>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <h4 class="mb-2 text-center text-lg font-semibold text-gray-500 xl:text-left dark:text-white/70">
                                Date: <span class="text-gray-800 dark:text-white/90">{{ form.date }}</span>
                            </h4>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2" v-if="team?.user">
                            <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                                Name: {{ team?.user?.name }}
                            </h4>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2" v-if="team?.user">
                            <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                                Phone: {{ team?.user?.phone }}
                            </h4>
                        </div>
                        <div class="h-px mx-2.5 w-full bg-gray-200 dark:bg-gray-800"></div>
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-t border-gray-100 dark:border-white/[0.05] text-left">
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Sr No.</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Name</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Role</th>
                                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(member, index) in form.members" class="border-t border-gray-100 dark:border-white/[0.05]">
                                    <input type="hidden" v-model="member.member_id">
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
                            <button v-if="teamAvailable.date.slice(0, 10) > new Date().toISOString().split('T')[0]" type="submit" class="flex items-center justify-center w-full gap-2 p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600">
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
    <TeamSpotsItem v-if="teamAvailable?.id" :spots="teamAvailable?.spots"  :team-available-id="teamAvailable?.id" :date="teamAvailable?.date" />

    <div class="py-5 px-1 space-y-6 bg-white dark:bg-white/[0.03] border border-gray-200 my-5 rounded-2xl dark:border-gray-800 hidden" v-if="teamAvailable?.spots?.length > 0">
        <h2 class="text-xl mx-2.5 font-semibold text-gray-800 dark:text-white/90 w-full my-2">Add Team Spots</h2>
        <table class="min-w-full my-3">
            <thead>
                <tr class="border-t border-gray-100 dark:border-white/[0.05] text-left">
                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Sr No</th>
                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Spots Name</th>
                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">children</th>
                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Women</th>
                    <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Men</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(spot, index) in teamAvailable.spots" class="border-t border-gray-100 dark:border-white/[0.05]">
                    <td class="p-1 border border-gray-100 dark:border-white/[0.05] w-1/11">
                       <input type="hidden" v-model="spot.id">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                            {{ index + 1 }}
                        </p>
                    </td>
                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                           {{ spot.spots_name }}
                        </p>
                    </td>
                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                            {{ spot.children }}
                        </p>
                    </td>
                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                            {{ spot.women }}
                        </p>
                    </td>
                    <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                        <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                           {{ spot.men }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { Head, router } from "@inertiajs/vue3";
import Layout from "@/Layout/MainLayout.vue";
import Breadcrum from "@/Components/Breadcrum.vue";
import axios from "axios";
import TeamSpotsItem from "@/Pages/TeamAvailable/TeamSpotsItem.vue";

export default {
    layout: Layout,
    props: {
        teams: Object,
        teamAvailable:Object,
    },
    components: {
        TeamSpotsItem,
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
                members: this.teamAvailable?.members ?? [],
            },
            team: this.teamAvailable?.team || [],
            memberIndex: null,
        }
    },
    methods : {
        submit() {
            let url;
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
