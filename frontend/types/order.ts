import type { ProductVariation } from './product';
import type { User } from './user';

export interface Order {
    id: number;
    user: User;
    status: OrderStatus;
    items: ProductVariation[];
    sub_total: number;
    tax: number;
    shipping: number;
    total: number;
    note: string | null;
    created_at: Date;
}

export enum OrderStatus {
    CREATED = 'created',
    PACKED = 'packed',
    PROCESSING = 'processing',
    DELIVERED = 'delivered',
    CANCELLED = 'cancelled',
}
