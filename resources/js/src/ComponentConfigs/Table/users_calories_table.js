export const users_calories_table = [
    {label: 'ID', key: 'id', type: 'default', action: null, limit: 40},
    {label: 'Name', key: 'name', type: 'link', action: 'show', limit: 40},
    {label: 'TG Username', key: 'username', type: 'link', action: 'telegram', limit: 100},
    {label: 'Calories Username', key: 'username_calories', type: 'default', action: null, limit: 100},
    {label: 'Email', key: 'email', type: 'default', action: null, limit: 100},
    {label: 'Telegram ID', key: 'telegram_id', type: 'default', action: null, limit: 40},
    {label: 'Premium', key: 'premium_calories', type: 'checkbox', action: null, limit: 40},
    {label: 'Source', key: 'source', type: 'default', action: null, limit: 40},
    {label: 'Banned the Bot', key: 'delete', type: 'checkbox', action: null, limit: 40},
    {label: 'Registration Date', key: 'created_at', type: 'default', action: null, limit: 40},
    {label: 'Delete', key: 'delete', type: 'button', action: 'delete', limit: 40},
];
