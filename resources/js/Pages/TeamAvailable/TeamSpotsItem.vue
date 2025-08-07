<template>
    <h2 class="text-xl mx-2.5 font-semibold text-gray-800 dark:text-white/90 w-full my-5">Add Team Spots</h2>
    <div class="py-5 px-1 space-y-6 bg-white dark:bg-white/[0.03] border border-gray-200 rounded-2xl dark:border-gray-800">
         <form @submit.prevent="submit()" enctype="multipart/form-data">
             <div class="flex my-3">
                 <div class="w-full px-2.5 xl:w-1/2">
                     <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                         Spots Name<span class="text-error-500">*</span>
                     </label>
                     <input type="text" v-model="addSpots.spots_name" placeholder="Enter Sport Name" min="1" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                     <p v-if="addSpots.errors?.spots_name" class="text-theme-xs text-error-500 mt-1.5">
                         {{ addSpots.errors.spots_name }}
                     </p>
                 </div>
                 <div class="w-full px-2.5 xl:w-1/2">
                     <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                         children<span class="text-error-500">*</span>
                     </label>
                     <input type="text" v-model="addSpots.children" placeholder="Enter children" min="1" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                     <p v-if="addSpots.errors?.children" class="text-theme-xs text-error-500 mt-1.5">
                         {{ addSpots.errors.children }}
                     </p>
                 </div>
                 <div class="w-full px-2.5 xl:w-1/2">
                     <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                         Women<span class="text-error-500">*</span>
                     </label>
                     <input type="text" v-model="addSpots.women" placeholder="Enter women" min="1" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                     <p v-if="addSpots.errors?.women" class="text-theme-xs text-error-500 mt-1.5">
                         {{ addSpots.errors.women }}
                     </p>
                 </div>
                 <div class="w-full px-2.5 xl:w-1/2">
                     <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                         Men<span class="text-error-500">*</span>
                     </label>
                     <input type="text" v-model="addSpots.men" placeholder="Enter Men" min="1" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                     <p v-if="addSpots.errors?.men" class="text-theme-xs text-error-500 mt-1.5">
                         {{ addSpots.errors.men }}
                     </p>
                 </div>
                 <div class="w-full px-2.5 xl:w-1/2 flex items-end justify-center">
                     <button type="button" @click="add_Spots" class="w-full gap-2 p-3 text-sm font-medium text-white transition-colors rounded-lg bg-brand-500 hover:bg-brand-600">
                         Add Team Spots
                     </button>
                 </div>
             </div>
             <div class="h-px mx-2.5 w-full bg-gray-200 dark:bg-gray-800"></div>
             <table class="min-w-full my-3 ">
                 <thead>
                     <tr class="border-t border-gray-100 dark:border-white/[0.05] text-left">
                         <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Sr No</th>
                         <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Spots Name</th>
                         <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">children</th>
                         <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Women</th>
                         <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Men</th>
                         <th class="p-1 border border-gray-100 dark:border-white/[0.05] dark:text-gray-300">Action</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr v-for="(spot, index) in form.spots" class="border-t border-gray-100 dark:border-white/[0.05]">
                         <td class="p-1 border border-gray-100 dark:border-white/[0.05] w-1/11">
                             <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                 {{ index + 1 }}
                             </p>
                         </td>
                         <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                             <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                 <input type="text" v-model="spot.spots_name" placeholder="Enter spots name" class="dark:bg-dark-900 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                             </p>
                             <p v-if="form.errors?.[`spot.${index}.spots_name`]" class="text-theme-xs text-error-500 mt-1.5">
                                 {{ form.errors?.[`spot.${index}.spots_name`] }}
                             </p>
                         </td>
                         <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                             <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                 <input type="text" v-model="spot.children" placeholder="Enter children" class="dark:bg-dark-900 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                             </p>
                             <p v-if="form.errors?.[`spot.${index}.children`]" class="text-theme-xs text-error-500 mt-1.5">
                                 {{ form.errors?.[`spot.${index}.children`] }}
                             </p>
                         </td>
                         <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                             <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                 <input type="text" v-model="spot.women" placeholder="Enter women" class="dark:bg-dark-900 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                             </p>
                             <p v-if="form.errors?.[`spot.${index}.women`]" class="text-theme-xs text-error-500 mt-1.5">
                                 {{ form.errors?.[`spot.${index}.women`] }}
                             </p>
                         </td>
                         <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                             <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                <input type="text" v-model="spot.men" placeholder="Enter men" class="dark:bg-dark-900 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-2 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                             </p>
                             <p v-if="form.errors?.[`spot.${index}.men`]" class="text-theme-xs text-error-500 mt-1.5">
                                 {{ form.errors?.[`spot.${index}.men`] }}
                             </p>
                         </td>
                         <td class="p-1 border border-gray-100 dark:border-white/[0.05]">
                             <button @click.prevent="deleteSpots(index)" type="button" class="text-2xl text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500 mx-1">
                                 <i class="fa-solid fa-trash"></i>
                             </button>
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
         </form>
    </div>
    <DeleteAlert 
        v-if="isDeleted" 
        @confirmDelete="deleteSpotsConfirmed"
        @cancelDelete="cancelDelete"
        :title="'Spots Delete'"
        :message="'Are you sure you want to delete this Spots?'" 
    />
</template>
<script>
import {router } from "@inertiajs/vue3";
import DeleteAlert from "../../Components/DeleteAlert.vue";

export default {
    props: {
        teamAvailableId: {type: [Number, String]},
        date: String,
        spots: Object
    },
    components: {
        DeleteAlert,
    },
    data() {
        return {
            form : {
                spots: this.spots || [],
            },
            addSpots: {
                spots_name: "",
                women: "",
                children: "",
                men: "",
                errors: {},
            },
            isDeleted: false,
            spotsIndex: null,
        }
    },
    methods : {
        submit() {
            Object.assign(this.form, {
                team_available_id: this.teamAvailableId ?? '',
                date: this.date ?? '',
            });
            let url = route('team_available.spots_item.save');
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
        add_Spots() {
            if (!this.addSpots.spots_name) {
                this.addSpots.errors.spots_name = 'The Spots Name is required.';
                return;
            } else {
                this.addSpots.errors.spots_name = '';
            }
            
            if (!this.addSpots.children) {
                this.addSpots.errors.children = 'The Children is required.';
                return;
            } else {
                this.addSpots.errors.children = '';
            }
            if (!this.addSpots.women) {
                this.addSpots.errors.women = 'The women is required.';
                return;
            } else {
                this.addSpots.errors.women = '';
            }
            if (!this.addSpots.children) {
                this.addSpots.errors.children = 'The Children is required.';
                return;
            } else {
                this.addSpots.errors.children = '';
            }
            if (!this.addSpots.men) {
                this.addSpots.errors.men = 'The men is required.';
                return;
            } else {
                this.addSpots.errors.men = '';
            }

            this.form.spots.push(this.addSpots);

            this.addSpots = {
                spots_name: '',
                women: '',
                children: '',
                men: '',
                errors: {},
            }
        },
        deleteSpots(index) {
            this.isDeleted = true;
            this.spotsIndex = index;
        },
        deleteSpotsConfirmed() {
            this.form.spots.splice(this.spotsIndex, 1);
            this.isDeleted = false;
            this.spotsIndex = null;
        },
        cancelDelete() {
            this.isDeleted = false;
            this.spotsIndex = null;
        },
    },
}

</script>