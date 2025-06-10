export interface TemplateOption {
    value: string;
    label: string;
    img: string;
}

export const TemplateConfig: Record<string, TemplateOption[]> = {
    header: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/header_default.png',
        },
        {
            value: 'minimalistic',
            label: 'Минималистичный',
            img: 'images/templates/header_minimalistic.png',
        },
        {
            value: 'luvu',
            label: 'Luvu', // Если это название шаблона/бренда — не переводится.
            img: '',
        },
        {
            value: 'photograph',
            label: 'Фотография',
            img: '',
        },
    ],
    footer: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/footer_default.png',
        },
        {
            value: 'minimalistic',
            label: 'Минималистичный',
            img: 'images/templates/footer_minimalistic.png',
        },
        {
            value: 'simple',
            label: 'Простой',
            img: 'images/templates/footer_simple.png',
        },
        {
            value: 'contact',
            label: 'Контактные данные',
            img: 'images/templates/footer_contact.png',
        },
        {
            value: 'luvu',
            label: 'Luvu',
            img: '',
        },
        {
            value: 'photograph',
            label: 'Фотография',
            img: '',
        },
    ],
    product_list: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/product_list_default.png',
        },
        {
            value: 'modern',
            label: 'Современный',
            img: 'images/templates/product_list_modern.png',
        },
        {
            value: 'compact',
            label: 'Компактный',
            img: 'images/templates/product_list_compact.png',
        },
    ],
    product_detail: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/product_detail_default.png',
        },
        {
            value: 'modern',
            label: 'Современный',
            img: 'images/templates/product_detail_modern.png',
        },
    ],
    cart: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/cart_default.png',
        },
        {
            value: 'modern',
            label: 'Современный',
            img: 'images/templates/cart_modern.png',
        },
    ],
    contact: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/contact_default.png',
        },
    ],
    about: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/about_default.png',
        },
    ],
    article_list: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/article_list_default.png',
        },
    ],
    article_detail: [
        {
            value: 'default',
            label: 'По умолчанию',
            img: 'images/templates/article_detail_default.png',
        },
    ],
};
