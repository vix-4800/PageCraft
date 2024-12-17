export interface Product {
    name: string;
    slug: string;
    image: string;
    description: string;
    variations: ProductVariation[];
    created_at: Date;
}

export interface ProductVariation {
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
