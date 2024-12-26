export interface Product {
    name: string;
    slug: string;
    image: string;
    additional_images: string[];
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
    product: Product;
}

export interface ProductVariantAttribute {
    name: string;
    value: string;
}
