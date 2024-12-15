export interface ProductVariant {
    sku: string;
    price: number;
    image: string;
    stock: number;
    attributes: ProductVariantAttribute[];
}

export interface ProductVariantAttribute {
    name: string;
    value: string;
}
