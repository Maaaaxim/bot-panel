export const rows_request = [
    {
        label: 'Name', key: 'name', type: 'default', emit_name: null, placeholder: 'enter name', action: null,
        required: true
    },
    {
        label: 'Token', key: 'token', type: 'default', emit_name: null, placeholder: 'enter token', action: null,
        required: true
    },
    {
        label: 'Webhook', key: 'web_hook', type: 'default', emit_name: null, placeholder: 'enter webhook', action: null,
        required: true
    },
    {
        label: 'Bot Type',
        key: 'type_id',
        type: 'dropdown',
        emit_name: null,
        placeholder: 'select type',
        action: null
    },
    {
        label: 'Managers',
        key: 'managers',
        type: 'multiple_dropdown',
        emit_name: null,
        placeholder: 'select managers',
        action: null
    },
    {label: 'Active', key: 'active', type: 'checkbox', emit_name: null, placeholder: 'is the bot active', action: null},
    {
        label: 'Actions', key: 'actions', type: 'buttons', emit_name: null, placeholder: null,
        options: [
            {text: 'Save', button_type: 'default', action: 'submit'},
            {text: 'Delete', button_type: 'danger', action: 'delete'},
        ]
    }
];
