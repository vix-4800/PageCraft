import type { ProductVariation } from './product';
import type { User } from './user';

export interface Order {
    user: User;
    status: OrderStatus;
    items: ProductVariation[];
    total: number;
    created_at: Date;
}

export enum OrderStatus {
    PENDING = 'pending',
    PROCESSING = 'processing',
    DELIVERED = 'delivered',
    CANCELLED = 'cancelled',
}
