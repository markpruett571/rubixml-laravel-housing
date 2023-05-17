<!-- From https://github.com/inertiajs/pingcrm/blob/master/resources/js/Shared/MainMenu.vue -->
<template>
    <div>
        <div class="mb-4">
            <Link class="flex items-center py-3" :href="route('dashboard')">
                <icon name="dashboard" class="fill-white mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : ''" />
                <div :class="isUrl('') ? 'text-white' : 'text-white hover:bg-blue-600'">Dashboard</div>
            </Link>
        </div>
        <div class="mb-4">
            <Link class="flex items-center py-3" :href="route('house-sales.index')">
                <icon name="office" class="fill-white mr-2 w-4 h-4" :class="isUrl('house-sales') ? 'fill-white' : ''" />
                <div :class="isUrl('organizations') ? 'text-white' : 'text-white hover:bg-blue-600'">House Sales</div>
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Components/Icon.vue'

export default {
    components: {
        Icon,
        Link,
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length
        },
    },
}
</script>
