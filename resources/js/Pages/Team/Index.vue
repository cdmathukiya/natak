<template>

    <Head title="Teams" />
    <Breadcrum :breadcrum="breadcrum" />
    <div class="border-gray-100 dark:border-gray-800">
        <div class="space-y-5">
            <div class="overflow-hidden rounded-xl bg-white dark:border-gray-800 dark:bg-white/[0.01]">
                <div class="flex flex-col gap-2 px-4 py-4 border border-b-0 border-gray-100 dark:border-white/[0.05] rounded-t-xl sm:flex-row sm:items-center sm:justify-between">
                    <div class="relative">
                        <input type="text" v-model="search" placeholder="Search..." class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]">
                        <button class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" fill=""></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-3">
                        <Link :href="route('team.create')" class="inline-flex items-center gap-2 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.2502 4.99951C9.2502 4.5853 9.58599 4.24951 10.0002 4.24951C10.4144 4.24951 10.7502 4.5853 10.7502 4.99951V9.24971H15.0006C15.4148 9.24971 15.7506 9.5855 15.7506 9.99971C15.7506 10.4139 15.4148 10.7497 15.0006 10.7497H10.7502V15.0001C10.7502 15.4143 10.4144 15.7501 10.0002 15.7501C9.58599 15.7501 9.2502 15.4143 9.2502 15.0001V10.7497H5C4.58579 10.7497 4.25 10.4139 4.25 9.99971C4.25 9.5855 4.58579 9.24971 5 9.24971H9.2502V4.99951Z" fill=""></path>
                            </svg>
                            Crate Team
                        </Link>
                    </div>
                </div>
                <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-t border-gray-100 dark:border-white/[0.05]">
                                <th v-for="(column, index) in columns" :key="index"
                                    class="px-4 py-3 border border-gray-100 dark:border-white/[0.05]"
                                    @click="handleSort(column.key)">
                                    <div class="flex items-center justify-between w-full cursor-pointer">
                                        <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">
                                            {{ column.label }}
                                        </p>
                                        <span class="flex flex-col gap-0.5">
                                            <svg :class="{ 'fill-blue-500 dark:fill-blue-500' : sortKey === column.key && sortDirection === 'asc', 'fill-gray-300 dark:fill-gray-700': sortKey !== column.key || sortDirection !== 'asc' }" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"></path>
                                            </svg>
                                            <svg :class="{ 'fill-blue-500 dark:fill-blue-500': sortKey === column.key && sortDirection === 'desc', 'fill-gray-300 dark:fill-gray-700': sortKey !== column.key || sortDirection !== 'desc' }" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(team, index) in teams.data" :key="index" class="border-t border-gray-100 dark:border-white/[0.05]">
                                <td class="px-4 py-3 border border-gray-100 dark:border-white/[0.05]">
                                    <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                        {{ teams.from + index }}
                                    </p>
                                </td>
                                <td class="px-4 py-3 border border-gray-100 dark:border-white/[0.05]">
                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ team.name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 border border-gray-100 dark:border-white/[0.05]">
                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ team.kendra }}
                                    </span>
                                </td>
                                <td class="px-4 py-[17.5px] border border-gray-100 dark:border-white/[0.05]">
                                    <div class="flex items-center w-full gap-2">
                                        <Link :href="route('team.edit', team.id)" class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90">
                                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z" fill=""></path>
                                            </svg>
                                        </Link>
                                        <button @click.prevent="deleteTeam(team.id)" type="button" class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500">
                                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" fill=""></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :links="teams.links" />
                </div>
            </div>
        </div>
    </div>
    <DeleteAlert 
        v-if="isDeleted" 
        @confirmDelete="deleteTeamConfirmed"
        @cancelDelete="cancelDelete"
        :title="'Team Delete'"
        :message="'Are you sure you want to delete this card?'" 
    />
</template>

<script>
import { Head, Link, router } from "@inertiajs/vue3";
import Layout from "@/Layout/MainLayout.vue";
import Breadcrum from "@/Components/Breadcrum.vue";
import DeleteAlert from "../../Components/DeleteAlert.vue";
import Common from "@/Components/Composables/Common";
import Pagination from '@/components/Pagination.vue';

export default {
    layout: Layout,
    components: {
        Link,
        Head,
        Breadcrum,
        DeleteAlert,
        Pagination
    },
    props: {
        teams: Object,
        filters: {
            type: Object,
            default: () => ({})
        }
    },
    created() {
        const { sortTable } = Common();
        this.sortTable = sortTable;
    },
    data() {
        return {
            breadcrum: {
                currentPage: 'Teams',
                previousPage: 'Dashboard',
                previousPageUrl: route('dashboard'),
            },
            columns: [
                { key: 'id', label: 'Id' },
                { key: 'name', label: 'Name' },
                { key: 'kendra', label: 'Kendra' },
                { key: 'Action', label: 'Action' },
            ],
            search: this.filters?.search || '',
            sortKey: '',
            sortDirection: 'asc',
            isDeleted: false,
            deleteId: null,
            searchTimeOut: null,
        }
    },
    watch: {
        search(value) {
            document.body.style.cursor = 'progress';
            clearTimeout(this.searchTimeOut);
            this.searchTimeOut =  setTimeout( () => {
                this.$inertia.get(route('teams'), { search: value }, {
                    preserveState: true,
                    replace: true,
                    onFinish: () => {
                        document.body.removeAttribute('style');
                    }
                });
            }, 1000);
        }
    },
    methods: {
        deleteTeam(id) {
            this.isDeleted = true;
            this.deleteId = id;
        },
        deleteTeamConfirmed() {
            if (this.deleteId) {
                router.delete(route("team.delete", this.deleteId));
            }
            this.isDeleted = false;
            this.deleteId = null;
        },
        cancelDelete() {
            this.isDeleted = false;
            this.deleteId = null;
        },
        handleSort(key) {
            if (this.sortKey === key) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortKey = key;
                this.sortDirection = 'asc';
            }
            this.teams.data = this.sortTable(key, this.teams.data);
        }
    }
}
</script>