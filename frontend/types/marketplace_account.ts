export interface MarketplaceAccount {
    id: number;
    name: string;
    marketplace: string;
    settings: MarketplaceAccountSetting[];
    created_at: Date;
}

export interface MarketplaceAccountSetting {
    id: number;
    key: string;
    value: string;
}
