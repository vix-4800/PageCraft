import type { Product } from './product';
import type { User } from './user';

export interface Review {
    id: number;
    user: User;
    rating: number;
    text: string;
    status: string;
    created_at: Date;
    product: Product;
    reactions: {
        likes: number;
        dislikes: number;
    };
}

export enum ReviewStatus {
    PENDING = 'pending',
    APPROVED = 'approved',
    REJECTED = 'rejected',
}
