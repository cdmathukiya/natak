<template>
  <div v-if="links.length > 1" class="border border-t-0 rounded-b-xl border-gray-100 py-4 pl-[18px] pr-4 dark:border-white/[0.05]">
    <div class="flex items-center justify-center gap-2 xl:justify-end">
      <template v-for="(link, key) in links" :key="key">
        <span v-if="!link.url" class="flex w-auto px-4 p-0 h-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]" v-html="link.label"/>
        <Link v-else :href="link.url" class="flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 shadow-sm transition-all duration-200 hover:bg-gray-100 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700" :class="[link.active ? 'bg-gray-200 text-gray-900 font-bold' : '', link.label.includes('Next') || link.label.includes('Previous') ? 'w-auto px-4 ' : 'w-10']" v-html="link.label"/>
      </template>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
  components: {
    Link,
  },
  props: {
    links: {
      type: Array,
      required: true,
    },
  },
};
</script>