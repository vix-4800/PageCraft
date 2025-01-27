export interface Article {
    slug: string;
    title: string;
    content: string;
    author: string;
    status: ArticleStatus;
    description: string;
    image: string | File | null;
    created_at: Date;
}

export enum ArticleStatus {
    DRAFT = 'draft',
    PUBLISHED = 'published',
    ARCHIVED = 'archived',
}
