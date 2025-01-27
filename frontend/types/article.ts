export interface Article {
    id: number;
    slug: string;
    title: string;
    content: string;
    author: string;
    status: ArticleStatus;
    image: string | File | null;
    created_at: Date;
}

export enum ArticleStatus {
    DRAFT = 'draft',
    PUBLISHED = 'published',
    ARCHIVED = 'archived',
}
