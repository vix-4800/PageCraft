export interface SiteTemplate {
    block: string;
    template: string;
}

export enum TemplateBlock {
    Header = 'header',
    Footer = 'footer',
    ProductList = 'product_list',
    ProductDetail = 'product_detail',
    Cart = 'cart',
}
