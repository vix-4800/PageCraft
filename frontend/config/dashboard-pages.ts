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
    'My Socials': [
        {
            label: 'Telegram',
            icon: 'mdi:telegram',
            href: '/dashboard/my-telegram',
        },
        {
            label: 'Discord',
            icon: 'mdi:discord',
            href: '/dashboard/my-discord',
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
    Marketplaces: [
        {
            label: 'Accounts',
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
    System: [
        {
            label: 'Settings',
            icon: 'material-symbols:settings-outline',
            href: '/dashboard/admin/settings',
        },
        {
            label: 'Application',
            icon: 'material-symbols:extension',
            href: '/dashboard/admin/application',
        },
    ],
};
