<template>
    <aside class="hidden rounded-lg lg:col-span-3 lg:block">
        <nav>
            <DashboardNavLink to="dashboard" label="Dashboard">
                <u-icon name="material-symbols:dashboard" size="20" />
            </DashboardNavLink>

            <hr class="h-5 border-0" />

            <div class="space-y-1.5">
                <DashboardNavLink to="sales" label="Sales" helper="0">
                    <u-icon name="material-symbols:shopping-cart" size="20" />
                </DashboardNavLink>

                <DashboardNavLink to="products" label="Products" helper="0">
                    <u-icon name="material-symbols:storefront" size="20" />
                </DashboardNavLink>
            </div>

            <hr class="h-5 border-0" />

            <div class="space-y-1.5">
                <DashboardNavLink to="users" label="Users" helper="0">
                    <u-icon name="material-symbols:groups" size="20" />
                </DashboardNavLink>

                <DashboardNavLink to="settings" label="Settings">
                    <u-icon
                        name="material-symbols:settings-outline"
                        size="20"
                    />
                </DashboardNavLink>
            </div>
        </nav>
    </aside>
</template>
