export interface SiteTemplate {
    block: string;
    template: string;
}

export enum TemplateBlock {
    Header = 'header',
    Footer = 'footer',
    ProductList = 'product_list',
    ProductView = 'product_view',
    Cart = 'cart',
}
