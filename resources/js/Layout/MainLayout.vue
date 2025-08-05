<template>
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <Sidebar :sidebarToggle="sidebarToggle" />
        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Small Device Overlay Start -->
            <div @click="sidebarToggle = false" :class="sidebarToggle ? 'block lg:hidden' : 'hidden'" class="fixed w-full h-screen z-9 bg-gray-900/50"></div>
            <!-- Small Device Overlay End -->
             
            <!-- ===== Header Start ===== -->
            <Header :auth="auth" :sidebarToggle="sidebarToggle" @toggleDarkMode="toggleDarkMode" @sidebarToggle="sidebarToggle = !sidebarToggle" />
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <Notification v-if="showNotification && (flash.success || flash.error)" :flash="flash" @closeNotification="showNotification = false"/>
                    <slot />
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
</template>

<script>
import Sidebar from '@/Components/Sidebar.vue';
import Header from '@/Components/Header.vue';
import Notification from '../Components/Notification.vue';
export default {
    components: {
        Sidebar,
        Header,
        Notification,
    },
    props: {
        auth: Object,
        flash:Object
    },
    data() {
        return {
            sidebarToggle: false,
            darkMode: JSON.parse(localStorage.getItem('darkMode')) || false,
            showNotification: true
        }
    },
    methods: {
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            document.body.classList.toggle('dark');
            document.body.classList.toggle('bg-gray-900');
        },
    },
    mounted() {
        if (this.darkMode) {
            document.body.classList.add('dark');
            document.body.classList.add('bg-gray-900');
        } else {
            document.body.classList.remove('dark');
            document.body.classList.remove('bg-gray-900');
        }
        if (this.flash.success || this.flash.error) {
            setTimeout(() => {
                this.showNotification = false;
            }, 2000);
        }
    },
    watch: {
        darkMode(newDarkMode, oldnDarkMode) {
            localStorage.setItem('darkMode', JSON.stringify(newDarkMode));
        },
        flash: {
            handler(newFlash) {
                if (newFlash.success || newFlash.error) {
                    this.showNotification = true;
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 2000);
                }
            },
            deep: true
        }
    }
}
</script>