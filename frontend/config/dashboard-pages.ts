export interface Page {
    label: string;
    icon: string;
    href: string;
}

export const SharedPages: Record<string, Page[]> = {
    'Мой аккаунт': [
        {
            label: 'Мои заказы',
            icon: 'material-symbols:shopping-cart',
            href: '/dashboard/my-orders',
        },
        {
            label: 'Мои отзывы',
            icon: 'material-symbols:rate-review',
            href: '/dashboard/my-reviews',
        },
        {
            label: 'Сохранённые адреса',
            icon: 'material-symbols:location-on',
            href: '/dashboard/my-addresses',
        },
    ],
    'Мои соцсети': [
        {
            label: 'Telegram',
            icon: 'mdi:telegram',
            href: '/dashboard/my-telegram',
        },
        // {
        //     label: 'Discord',
        //     icon: 'mdi:discord',
        //     href: '/dashboard/my-discord',
        // },
    ],
};

export const AdminPages: Record<string, Page[]> = {
    Магазин: [
        {
            label: 'Заказы',
            icon: 'material-symbols:shopping-cart',
            href: '/dashboard/admin/orders',
        },
        {
            label: 'Товары',
            icon: 'material-symbols:storefront',
            href: '/dashboard/admin/products',
        },
        {
            label: 'Купоны',
            icon: 'mdi:tag',
            href: '/dashboard/admin/coupons',
        },
    ],
    Контент: [
        {
            label: 'Статьи',
            icon: 'material-symbols:article',
            href: '/dashboard/admin/articles',
        },
    ],
    Маркетплейсы: [
        {
            label: 'Аккаунты',
            icon: 'material-symbols:storefront',
            href: '/dashboard/admin/marketplaces',
        },
    ],
    Управление: [
        {
            label: 'Пользователи',
            icon: 'material-symbols:groups',
            href: '/dashboard/admin/users',
        },
        {
            label: 'Статистика',
            icon: 'material-symbols:analytics',
            href: '/dashboard/admin/statistics',
        },
    ],
    'Обратная связь': [
        {
            label: 'Отзывы',
            icon: 'material-symbols:rate-review',
            href: '/dashboard/admin/reviews',
        },
        {
            label: 'Вопросы пользователей',
            icon: 'material-symbols:feedback',
            href: '/dashboard/admin/questions',
        },
        {
            label: 'FAQ',
            icon: 'material-symbols:question-mark',
            href: '/dashboard/admin/faq',
        },
    ],
    Кастомизация: [
        {
            label: 'Шаблоны',
            icon: 'material-symbols:design-services',
            href: '/dashboard/admin/templates',
        },
        {
            label: 'Шаблоны писем',
            icon: 'material-symbols:mail',
            href: '/dashboard/admin/email-templates',
        },
        {
            label: 'Баннер',
            icon: 'material-symbols:brand-awareness-rounded',
            href: '/dashboard/admin/banner',
        },
    ],
    Система: [
        {
            label: 'Настройки',
            icon: 'material-symbols:settings-outline',
            href: '/dashboard/admin/settings',
        },
        {
            label: 'Приложение',
            icon: 'material-symbols:extension',
            href: '/dashboard/admin/application',
        },
        {
            label: 'Терминал',
            icon: 'material-symbols:terminal',
            href: '/dashboard/admin/terminal',
        },
    ],
};
