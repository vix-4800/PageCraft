import type { ProductVariation } from './product';
import type { User } from './user';

export interface Order {
    id: number;
    user: User;
    status: OrderStatus;
    items: ProductVariation[];
    total: number;
    created_at: Date;
}

export enum OrderStatus {
    CREATED = 'created',
    PACKED = 'packed',
    PROCESSING = 'processing',
    DELIVERED = 'delivered',
    CANCELLED = 'cancelled',
}
