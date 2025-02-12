export interface SiteTemplate {
    name: TemplateBlock;
    title: string;
    description: string;
    template: string;
    is_visible: boolean;
}

export enum TemplateBlock {
    Header = 'header',
    Footer = 'footer',
    ProductList = 'product_list',
    ProductDetail = 'product_detail',
    Cart = 'cart',
    Contact = 'contact',
    About = 'about',
    ArticleList = 'article_list',
    ArticleDetail = 'article_detail',
}
