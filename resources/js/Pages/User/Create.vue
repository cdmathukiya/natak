<template>
    <Head title="User Create" />
    <Breadcrum :breadcrum="breadcrum" />
    <div class="flex lg:flex-nowrap flex-wrap gap-5">
        <div class="w-full">
            <div class="py-5 px-1 space-y-6 bg-white dark:bg-white/[0.03] border border-gray-200 rounded-2xl dark:border-gray-800">
                <form @submit.prevent="submit()" enctype="multipart/form-data">
                    <div class="flex flex-wrap gap-y-3">
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Name<span class="text-error-500">*</span>
                            </label>
                            <input type="text" id="name" v-model="form.name" placeholder="Enter name" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            <p v-if="form.errors?.name" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.name }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email<span class="text-error-500">*</span>
                            </label>
                            <input type="email" id="email" v-model="form.email" placeholder="Enter email" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            <p v-if="form.errors?.email" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.email }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Password<span class="text-error-500">*</span>
                            </label>
                            <input type="password" id="password" v-model="form.password" placeholder="Enter password" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" autocomplete="false">
                            <p v-if="form.errors?.password" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.password }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="phone" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Phone
                            </label>
                            <input type="text" id="phone" v-model="form.phone" placeholder="Enter phone" class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                            <p v-if="form.errors?.phone" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.phone }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="address" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Address
                            </label>
                            <textarea v-model="form.address" id="address" placeholder="Address" rows="4" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
                            <p v-if="form.errors?.address" class="text-theme-xs text-error-500 mt-1.5">
                                {{ form.errors.address }}
                            </p>
                        </div>
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label for="is_active" class="flex cursor-pointer items-center gap-3 text-medium font-medium text-gray-800 select-none dark:text-white/90">
                                Is Active ?
                                <div class="relative">
                                    <input @change="form.is_active = !form.is_active" type="checkbox" id="is_active" class="sr-only"/>
                                    <div :class="form.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'" class="block h-6 w-11 rounded-full"></div>
                                    <div :class="form.is_active ? 'translate-x-full rtl:-translate-x-full' : 'translate-x-0'" class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear"></div>
                                </div>
                            </label>
                        </div>
                        <div class="w-full px-2.5">
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

export default {
    layout: Layout,
    props: {
        userData: Object,
    },
    components: {
        Head,
        Breadcrum,
    },
    data() {
        return {
            breadcrum: {
                currentPage: 'User',
                previousPage: 'Dashboard',
                previousPageUrl: route('dashboard')
            },
            form : {
                name: this.userData?.name ?? '',
                email: this.userData?.email ?? '',
                password: '',
                phone: this.userData?.phone ?? '',
                is_active: this.userData?.is_active ?? true,
            },
        }
    },
    methods : {
        submit() {
            let url = route('user.save');
            if(this.userData?.id) {
                url = route('user.update', this.userData.id);
                this.form._method = 'put';
            }
            this.form.errors = {},
            router.post(url, this.form, {
                onSuccess: () => {
                },
                onError: (errors) => {
                    this.form.errors = errors;
                },
            });
        }
    }
}

</script>