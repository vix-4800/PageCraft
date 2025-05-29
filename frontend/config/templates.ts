export interface TemplateOption {
    value: string;
    label: string;
    img: string;
}

export const TemplateConfig: Record<string, TemplateOption[]> = {
    header: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/header_default.png',
        },
        {
            value: 'minimalistic',
            label: 'Minimalistic',
            img: 'images/templates/header_minimalistic.png',
        },
        {
            value: 'luvu',
            label: 'Luvu',
            img: '',
        },
    ],
    footer: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/footer_default.png',
        },
        {
            value: 'minimalistic',
            label: 'Minimalistic',
            img: 'images/templates/footer_minimalistic.png',
        },
        {
            value: 'simple',
            label: 'Simple',
            img: 'images/templates/footer_simple.png',
        },
        {
            value: 'contact',
            label: 'Contact Details',
            img: 'images/templates/footer_contact.png',
        },
        {
            value: 'luvu',
            label: 'Luvu',
            img: '',
        },
    ],
    product_list: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/product_list_default.png',
        },
        {
            value: 'modern',
            label: 'Modern',
            img: 'images/templates/product_list_modern.png',
        },
        {
            value: 'compact',
            label: 'Compact',
            img: 'images/templates/product_list_compact.png',
        },
    ],
    product_detail: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/product_detail_default.png',
        },
        {
            value: 'modern',
            label: 'Modern',
            img: 'images/templates/product_detail_modern.png',
        },
    ],
    cart: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/cart_default.png',
        },
        {
            value: 'modern',
            label: 'Modern',
            img: 'images/templates/cart_modern.png',
        },
    ],
    contact: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/contact_default.png',
        },
    ],
    about: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/about_default.png',
        },
    ],
    article_list: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/article_list_default.png',
        },
    ],
    article_detail: [
        {
            value: 'default',
            label: 'Default',
            img: 'images/templates/article_detail_default.png',
        },
    ],
};
