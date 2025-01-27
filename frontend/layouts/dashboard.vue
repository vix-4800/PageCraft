<template>
    <div>
        <dashboard-header />

        <div
            class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-100"
        >
            <div class="flex flex-col flex-auto max-w-full">
                <div class="container p-4 mx-auto lg:p-8 xl:max-w-7xl">
                    <div class="grid grid-cols-1 md:gap-20 lg:grid-cols-12">
                        <dashboard-sidebar :categories="categories" />

                        <main class="lg:col-span-9">
                            <div v-if="showWelcomeMessage" class="p-6">
                                <p class="text-2xl font-semibold">
                                    Welcome back,
                                    <span class="text-indigo-600">
                                        {{ authStore.user.name }}!
                                    </span>
                                </p>
                            </div>

                            <div
                                class="p-6 overflow-hidden bg-white border rounded-xl border-slate-200"
                            >
                                <slot></slot>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <dashboard-footer />
    </div>
</template>

<script lang="ts" setup>
const authStore = useAuthStore();
const route = useRoute();

const showWelcomeMessage = computed(() =>
    ['/dashboard/admin', '/dashboard/user'].includes(route.fullPath)
);

const sharedCategories = {
    'My Account': [
        {
            label: 'My Orders',
            icon: 'material-symbols:shopping-cart',
            to: '/dashboard/my-orders',
        },
        {
            label: 'My Reviews',
            icon: 'material-symbols:rate-review',
            to: '/dashboard/my-reviews',
        },
        {
            label: 'Saved Addresses',
            icon: 'material-symbols:location-on',
            to: '/dashboard/my-addresses',
        },
    ],
};

const adminCategories = {
    Store: [
        {
            label: 'Orders',
            icon: 'material-symbols:shopping-cart',
            to: '/dashboard/admin/orders',
        },
        {
            label: 'Products',
            icon: 'material-symbols:storefront',
            to: '/dashboard/admin/products',
        },
        {
            label: 'Coupons',
            icon: 'mdi:tag',
            to: '/dashboard/admin/coupons',
        },
    ],
    Content: [
        {
            label: 'Articles',
            icon: 'material-symbols:article',
            to: '/dashboard/admin/articles',
        },
    ],
    Integrations: [
        {
            label: 'Marketplaces',
            icon: 'material-symbols:storefront',
            to: '/dashboard/admin/marketplaces',
        },
    ],
    Management: [
        {
            label: 'Users',
            icon: 'material-symbols:groups',
            to: '/dashboard/admin/users',
        },
        {
            label: 'Activity History',
            icon: 'material-symbols:history',
            to: '/dashboard/admin/activity-history',
        },
        {
            label: 'Statistics',
            icon: 'material-symbols:analytics',
            to: '/dashboard/admin/statistics',
        },
    ],
    Feedback: [
        {
            label: 'Reviews',
            icon: 'material-symbols:rate-review',
            to: '/dashboard/admin/reviews',
        },
        {
            label: 'User Questions',
            icon: 'material-symbols:feedback',
            to: '/dashboard/admin/questions',
        },
        {
            label: 'FAQ',
            icon: 'material-symbols:question-mark',
            to: '/dashboard/admin/faq',
        },
    ],
    Customization: [
        {
            label: 'Templates',
            icon: 'material-symbols:design-services',
            to: '/dashboard/admin/templates',
        },
        {
            label: 'Email Templates',
            icon: 'material-symbols:mail',
            to: '/dashboard/admin/email-templates',
        },
        {
            label: 'Banners',
            icon: 'material-symbols:brand-awareness-rounded',
            to: '/dashboard/admin/banners',
        },
    ],
    Settings: [
        {
            label: 'Settings',
            icon: 'material-symbols:settings-outline',
            to: '/dashboard/admin/settings',
        },
    ],
    'System Monitoring': [
        {
            label: 'Backups',
            icon: 'material-symbols:cloud-download',
            to: '/dashboard/admin/backups',
        },
        {
            label: 'Application Logs',
            icon: 'material-symbols:bug-report',
            to: '/dashboard/admin/logs',
        },
        {
            label: 'Queue Logs',
            icon: 'material-symbols:timeline',
            to: '/dashboard/admin/queue-logs',
        },
    ],
};

const categories = {
    Dashboard: [
        {
            label: 'Dashboard',
            icon: 'material-symbols:dashboard',
            to: authStore.isAdmin ? '/dashboard/admin' : '/dashboard/user',
        },
    ],
    ...sharedCategories,
    ...(authStore.isAdmin ? adminCategories : []),
};
</script>
