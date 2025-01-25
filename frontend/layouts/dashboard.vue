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
const adminLinks = [
    {
        category: 'Dashboard',
        label: 'Dashboard',
        icon: 'material-symbols:dashboard',
        to: '/dashboard/admin',
    },
    {
        category: 'Orders',
        label: 'Orders',
        icon: 'material-symbols:shopping-cart',
        to: '/dashboard/admin/orders',
    },
    {
        category: 'Orders',
        label: 'My Orders',
        icon: 'material-symbols:shopping-cart-outline',
        to: '/dashboard/my-orders',
    },
    {
        category: 'Products',
        label: 'Products',
        icon: 'material-symbols:storefront',
        to: '/dashboard/admin/products',
    },
    {
        category: 'Products',
        label: 'Reviews',
        icon: 'material-symbols:rate-review',
        to: '/dashboard/admin/reviews',
    },
    {
        category: 'Administration',
        label: 'Marketplaces',
        icon: 'material-symbols:storefront',
        to: '/dashboard/admin/marketplaces',
    },
    {
        category: 'Administration',
        label: 'Users',
        icon: 'material-symbols:groups',
        to: '/dashboard/admin/users',
    },
    {
        category: 'Administration',
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
        label: 'Application Logs',
        icon: 'material-symbols:bug-report',
        to: '/dashboard/admin/logs',
    },
    {
        category: 'Settings',
        label: 'Backups',
        icon: 'material-symbols:cloud-download',
        to: '/dashboard/admin/backups',
    },
];

const userLinks = [
    {
        category: 'Dashboard',
        label: 'Dashboard',
        icon: 'material-symbols:dashboard',
        to: '/dashboard/user',
    },
    {
        category: 'Orders',
        label: 'My Orders',
        icon: 'material-symbols:shopping-cart',
        to: '/dashboard/my-orders',
    },
];

const groupedLinks = computed(() => {
    const links = useAuthStore().isAdmin ? adminLinks : userLinks;

    return links.reduce((groups, link) => {
        (groups[link.category] = groups[link.category] || []).push(link);

        return groups;
    }, {});
});
</script>
