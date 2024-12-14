<template>
    <aside class="hidden rounded-lg lg:col-span-3 lg:block">
        <nav>
            <DashboardNavLink to="dashboard" label="Dashboard">
                <u-icon name="material-symbols:dashboard" size="20" />
            </DashboardNavLink>

            <hr class="h-5 border-0" />

            <div class="space-y-1.5">
                <DashboardNavLink to="sales" label="Sales" helper="14k">
                    <u-icon name="material-symbols:shopping-cart" size="20" />
                </DashboardNavLink>

                <DashboardNavLink to="products" label="Products" helper="150">
                    <u-icon name="material-symbols:storefront" size="20" />
                </DashboardNavLink>
            </div>

            <hr class="h-5 border-0" />

            <div class="space-y-1.5">
                <DashboardNavLink to="users" label="Users" helper="150">
                    <u-icon name="material-symbols:groups" size="20" />
                </DashboardNavLink>

                <DashboardNavLink
                    to="page-configuration"
                    label="Page Configuration"
                >
                    <u-icon
                        name="material-symbols:settings-outline"
                        size="20"
                    />
                </DashboardNavLink>
            </div>

            <hr class="h-5 border-0" />

            <div class="space-y-1.5">
                <DashboardNavLink to="account" label="Account">
                    <u-icon name="material-symbols:account-circle" size="20" />
                </DashboardNavLink>

                <button
                    class="flex w-full bg-indigo-50 gap-2 rounded-md px-2.5 py-2 text-sm text-slate-900 font-semibold"
                    type="button"
                    @click="useAuthStore().logout"
                >
                    <u-icon name="material-symbols:logout" size="20" />
                    <span>Logout</span>
                </button>
            </div>
        </nav>
    </aside>
</template>
