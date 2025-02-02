<template>
    <div>
        <dashboard-header :pages="pages" />

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
            href: '/dashboard/my-orders',
        },
        {
            label: 'My Reviews',
            icon: 'material-symbols:rate-review',
            href: '/dashboard/my-reviews',
        },
        {
            label: 'Saved Addresses',
            icon: 'material-symbols:location-on',
            href: '/dashboard/my-addresses',
        },
    ],
};

const adminCategories = {
    Store: [
        {
            label: 'Orders',
            icon: 'material-symbols:shopping-cart',
            href: '/dashboard/admin/orders',
        },
        {
            label: 'Products',
            icon: 'material-symbols:storefront',
            href: '/dashboard/admin/products',
        },
        {
            label: 'Coupons',
            icon: 'mdi:tag',
            href: '/dashboard/admin/coupons',
        },
    ],
    Content: [
        {
            label: 'Articles',
            icon: 'material-symbols:article',
            href: '/dashboard/admin/articles',
        },
    ],
    Integrations: [
        {
            label: 'Marketplaces',
            icon: 'material-symbols:storefront',
            href: '/dashboard/admin/marketplaces',
        },
    ],
    Management: [
        {
            label: 'Users',
            icon: 'material-symbols:groups',
            href: '/dashboard/admin/users',
        },
        {
            label: 'Activity History',
            icon: 'material-symbols:history',
            href: '/dashboard/admin/activity-history',
        },
        {
            label: 'Statistics',
            icon: 'material-symbols:analytics',
            href: '/dashboard/admin/statistics',
        },
    ],
    Feedback: [
        {
            label: 'Reviews',
            icon: 'material-symbols:rate-review',
            href: '/dashboard/admin/reviews',
        },
        {
            label: 'User Questions',
            icon: 'material-symbols:feedback',
            href: '/dashboard/admin/questions',
        },
        {
            label: 'FAQ',
            icon: 'material-symbols:question-mark',
            href: '/dashboard/admin/faq',
        },
    ],
    Customization: [
        {
            label: 'Templates',
            icon: 'material-symbols:design-services',
            href: '/dashboard/admin/templates',
        },
        {
            label: 'Email Templates',
            icon: 'material-symbols:mail',
            href: '/dashboard/admin/email-templates',
        },
        {
            label: 'Banner',
            icon: 'material-symbols:brand-awareness-rounded',
            href: '/dashboard/admin/banner',
        },
    ],
    Settings: [
        {
            label: 'Settings',
            icon: 'material-symbols:settings-outline',
            href: '/dashboard/admin/settings',
        },
    ],
    'System Monitoring': [
        {
            label: 'Backups',
            icon: 'material-symbols:cloud-download',
            href: '/dashboard/admin/backups',
        },
        {
            label: 'Application Logs',
            icon: 'material-symbols:bug-report',
            href: '/dashboard/admin/logs',
        },
        {
            label: 'Queue Logs',
            icon: 'material-symbols:timeline',
            href: '/dashboard/admin/queue-logs',
        },
        {
            label: 'System Information',
            icon: 'material-symbols:system-update',
            href: '/dashboard/admin/system-info',
        },
    ],
};

const categories = {
    Dashboard: [
        {
            label: 'Dashboard',
            icon: 'material-symbols:dashboard',
            href: authStore.isAdmin ? '/dashboard/admin' : '/dashboard/user',
        },
    ],
    ...sharedCategories,
    ...(authStore.isAdmin ? adminCategories : []),
};

const pages = computed(() => {
    return Object.values(categories).flat();
});
</script>
