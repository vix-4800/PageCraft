export interface SiteSetting {
    key: string;
    value: string;
    type: SettingType;
}

export enum SettingKey {
    Description = 'description',
    Keywords = 'keywords',
    Author = 'author',

    Email = 'email',
    Phone = 'phone',
    Address = 'address',

    SocialFacebook = 'social_facebook',
    SocialTwitter = 'social_twitter',
    SocialInstagram = 'social_instagram',
    SocialVk = 'social_vk',
    SocialYoutube = 'social_youtube',
    SocialTelegram = 'social_telegram',

    IsMaintenance = 'is_maintenance',
}

export enum SettingType {
    TEXT = 'text',
    BOOLEAN = 'boolean',
}
