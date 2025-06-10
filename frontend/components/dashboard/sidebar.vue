<template>
    <aside class="hidden rounded-lg lg:col-span-3 lg:block">
        <nav>
            <div
                v-for="(links, category) in categories"
                :key="category"
                class="mb-4"
            >
                <u-separator :label="category" />

                <div class="space-y-1">
                    <div v-for="link in links" :key="link.label">
                        <dashboard-nav-link :to="link.href" :label="link.label">
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
    categories: {
        type: Object as () => {
            [category: string]: { label: string; href: string; icon: string }[];
        },
        required: true,
    },
});
</script>
