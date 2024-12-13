import type { ProductVariantAttribute } from './product_variant_attribute';

export interface ProductVariant {
    sku: string;
    price: number;
    attributes: ProductVariantAttribute[];
}
