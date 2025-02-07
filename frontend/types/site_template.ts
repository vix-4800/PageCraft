export interface SiteTemplate {
    block: TemplateBlock;
    template: string;
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
