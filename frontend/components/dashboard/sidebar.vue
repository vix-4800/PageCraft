<template>
    <aside class="hidden rounded-lg lg:col-span-3 lg:block">
        <nav>
            <div
                v-for="(links, category) in groupedLinks"
                :key="category"
                class="mb-4"
            >
                <u-divider :label="category" />

                <div class="space-y-1">
                    <div v-for="link in links" :key="link.label">
                        <dashboard-nav-link :to="link.to" :label="link.label">
                            <u-icon :name="link.icon" size="20" />
                        </dashboard-nav-link>
                    </div>
                </div>
            </div>
        </nav>
    </aside>
</template>

<script lang="ts" setup>
defineProps({
    groupedLinks: {
        type: Object as () => {
            [category: string]: { label: string; to: string; icon: string }[];
        },
        required: true,
    },
});
</script>
