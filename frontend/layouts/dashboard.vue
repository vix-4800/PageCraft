<template>
    <div>
        <dashboard-header />

        <div
            class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-100"
        >
            <div class="flex flex-col flex-auto max-w-full">
                <div class="container p-4 mx-auto lg:p-8 xl:max-w-7xl">
                    <div class="grid grid-cols-1 md:gap-20 lg:grid-cols-12">
                        <dashboard-sidebar :grouped-links="groupedLinks" />

                        <main class="lg:col-span-9">
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

const sharedLinks = [
    {
        category: 'My Account',
        label: 'My Orders',
        icon: 'material-symbols:shopping-cart',
        to: '/dashboard/my-orders',
    },
    {
        category: 'My Account',
        label: 'My Reviews',
        icon: 'material-symbols:rate-review',
        to: '/dashboard/my-reviews',
    },
];

const adminLinks = [
    {
        category: 'Orders',
        label: 'Orders',
        icon: 'material-symbols:shopping-cart',
        to: '/dashboard/admin/orders',
    },
    {
        category: 'Products',
        label: 'Products',
        icon: 'material-symbols:storefront',
        to: '/dashboard/admin/products',
    },
    {
        category: 'Content',
        label: 'Articles',
        icon: 'material-symbols:article',
        to: '/dashboard/admin/articles',
    },
    {
        category: 'Integrations',
        label: 'Marketplaces',
        icon: 'material-symbols:storefront',
        to: '/dashboard/admin/marketplaces',
    },
    {
        category: 'Management',
        label: 'Users',
        icon: 'material-symbols:groups',
        to: '/dashboard/admin/users',
    },
    {
        category: 'Management',
        label: 'Activity History',
        icon: 'material-symbols:history',
        to: '/dashboard/admin/activity-history',
    },
    {
        category: 'Management',
        label: 'Statistics',
        icon: 'material-symbols:analytics',
        to: '/dashboard/admin/statistics',
    },
    {
        category: 'Feedback',
        label: 'Reviews',
        icon: 'material-symbols:rate-review',
        to: '/dashboard/admin/reviews',
    },
    {
        category: 'Feedback',
        label: 'User Questions',
        icon: 'material-symbols:question-mark',
        to: '/dashboard/admin/questions',
    },
    {
        category: 'Settings',
        label: 'Templates',
        icon: 'material-symbols:design-services',
        to: '/dashboard/admin/templates',
    },
    {
        category: 'Settings',
        label: 'Settings',
        icon: 'material-symbols:settings-outline',
        to: '/dashboard/admin/settings',
    },
    {
        category: 'Settings',
        label: 'Email Templates',
        icon: 'material-symbols:mail',
        to: '/dashboard/admin/email-templates',
    },
    {
        category: 'Settings',
        label: 'Banners',
        icon: 'material-symbols:brand-awareness-rounded',
        to: '/dashboard/admin/banners',
    },
    {
        category: 'System Monitoring',
        label: 'Backups',
        icon: 'material-symbols:cloud-download',
        to: '/dashboard/admin/backups',
    },
    {
        category: 'System Monitoring',
        label: 'Application Logs',
        icon: 'material-symbols:bug-report',
        to: '/dashboard/admin/logs',
    },
    {
        category: 'System Monitoring',
        label: 'Queue Logs',
        icon: 'material-symbols:timeline',
        to: '/dashboard/admin/queue-logs',
    },
];

const links = [
    {
        category: 'Dashboard',
        label: 'Dashboard',
        icon: 'material-symbols:dashboard',
        to: authStore.isAdmin ? '/dashboard/admin' : '/dashboard/user',
    },
    ...sharedLinks,
    ...(authStore.isAdmin ? adminLinks : []),
];

const groupedLinks = computed(() => {
    return links.reduce((groups, link) => {
        (groups[link.category] = groups[link.category] || []).push(link);

        return groups;
    }, {});
});
</script>
