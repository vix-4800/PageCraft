export interface Page {
    label: string;
    icon: string;
    href: string;
}

export const SharedPages: Record<string, Page[]> = {
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

export const AdminPages: Record<string, Page[]> = {
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
