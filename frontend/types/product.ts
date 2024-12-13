import type { ProductVariant } from './product_variant';

export interface Product {
    name: string;
    slug: string;
    image: string;
    description: string;
    variations: ProductVariant[];
    created_at: Date;
}
