export const users_table = [
    {label: 'ID', key: 'id', type: 'default', action: null, limit: 40},
    {label: 'Name', key: 'name', type: 'link', action: 'show', limit: 40},
    {label: 'Username', key: 'username', type: 'link', action: 'telegram', limit: 100},
    {label: 'Telegram ID', key: 'telegram_id', type: 'default', action: null, limit: 40},
    {label: 'Premium', key: 'premium', type: 'checkbox', action: null, limit: 40},
    {label: 'Banned the Bot', key: 'delete', type: 'checkbox', action: null, limit: 40},
    {label: 'User Bots', key: 'bot_ids', type: 'arrayLink', action: 'showBot', limit: 40},
    {label: 'Delete', key: 'delete', type: 'button', action: 'delete', limit: 40},
];
