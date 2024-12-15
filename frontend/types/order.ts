import type { ProductVariant } from './product_variant';
import type { User } from './user';

export interface Order {
    user: User;
    status: OrderStatus;
    items: ProductVariant[];
}

export enum OrderStatus {
    PENDING = 'pending',
    PROCESSING = 'processing',
    DELIVERED = 'delivered',
    CANCELLED = 'cancelled',
}
