export interface SiteSetting {
    key: string;
    value: string;
}

export enum SettingKey {
    SiteName = 'site_name',
    SiteDescription = 'site_description',
    SiteKeywords = 'site_keywords',
    SiteAuthor = 'site_author',
    SiteEmail = 'site_email',
    SitePhone = 'site_phone',
    SiteAddress = 'site_address',
}
