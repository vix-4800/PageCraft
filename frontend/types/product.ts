export interface Product {
    name: string;
    slug: string;
    image: string | null | File;
    additional_images: string[];
    description: string;
    variations: ProductVariation[];
    reviews: {
        count: number;
        average: number;
        stars: {
            five_stars: number;
            four_stars: number;
            three_stars: number;
            two_stars: number;
            one_star: number;
        };
    };
    created_at: Date;
}

export interface ProductVariation {
    sku: string;
    price: number;
    image: string | null | File;
    stock: number;
    attributes: ProductVariantAttribute[];
    product: Product;
    quantity: number;
}

export interface ProductVariantAttribute {
    name: string;
    value: string;
}
