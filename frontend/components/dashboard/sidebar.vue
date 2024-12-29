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
                        <DashboardNavLink :to="link.to" :label="link.label">
                            <u-icon :name="link.icon" size="20" />
                        </DashboardNavLink>
                    </div>
                </div>
            </div>
        </nav>
    </aside>
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
        category: 'Orders',
        label: 'Products',
        icon: 'material-symbols:storefront',
        to: '/dashboard/admin/products',
    },
    {
        category: 'Administration',
        label: 'Users',
        icon: 'material-symbols:groups',
        to: '/dashboard/admin/users',
    },
    {
        category: 'Administration',
        label: 'Settings',
        icon: 'material-symbols:settings-outline',
        to: '/dashboard/admin/settings',
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
