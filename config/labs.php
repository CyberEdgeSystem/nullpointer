<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CTF flag groups
    |--------------------------------------------------------------------------
    |
    | Flags are selected by the HTTP port where the lab is running. This lets
    | you reuse the same lab code for several CTF instances while giving each
    | port its own flag set. If the current port is not configured, the
    | "default" group is used.
    |
    | Example:
    | http://nullpointer.test:8000 -> flag_groups['8000']
    | http://nullpointer.test:9001 -> flag_groups['9001']
    |
    */

    'default_flag_group' => 'default',

    'flag_groups' => [
        'default' => [
            'product_filter' => 'flag{sqli_product_filter_unreleased}',
            'login_bypass' => 'flag{sqli_login_admin_bypass}',
            'stock_union' => 'flag{sqli_stock_union_admin_credentials}',
            'oracle_version' => 'flag{sqli_oracle_database_version}',
            'database_version' => 'flag{sqli_database_version_union}',
            'user_table_union' => 'flag{sqli_user_table_union_admin}',
            'column_count' => 'flag{sqli_union_column_count}',
            'column_text' => 'flag{sqli_union_column_text}',
            'table_data' => 'flag{sqli_retrieve_data_from_users}',
            'multiple_values_single_column' => 'flag{sqli_multiple_values_single_column}',
            'blind_conditional' => 'flag{sqli_blind_conditional_responses}',
        ],

        '8000' => [
            'product_filter' => 'flag{8000_product_filter_unreleased}',
            'login_bypass' => 'flag{8000_login_admin_bypass}',
            'stock_union' => 'flag{8000_stock_union_admin_credentials}',
            'oracle_version' => 'flag{8000_oracle_database_version}',
            'database_version' => 'flag{8000_database_version_union}',
            'user_table_union' => 'flag{8000_user_table_union_admin}',
            'column_count' => 'flag{8000_union_column_count}',
            'column_text' => 'flag{8000_union_column_text}',
            'table_data' => 'flag{8000_retrieve_data_from_users}',
            'multiple_values_single_column' => 'flag{8000_multiple_values_single_column}',
            'blind_conditional' => 'flag{8000_blind_conditional_responses}',
        ],

        '9001' => [
            'product_filter' => 'flag{9001_product_filter_unreleased}',
            'login_bypass' => 'flag{9001_login_admin_bypass}',
            'stock_union' => 'flag{9001_stock_union_admin_credentials}',
            'oracle_version' => 'flag{9001_oracle_database_version}',
            'database_version' => 'flag{9001_database_version_union}',
            'user_table_union' => 'flag{9001_user_table_union_admin}',
            'column_count' => 'flag{9001_union_column_count}',
            'column_text' => 'flag{9001_union_column_text}',
            'table_data' => 'flag{9001_retrieve_data_from_users}',
            'multiple_values_single_column' => 'flag{9001_multiple_values_single_column}',
            'blind_conditional' => 'flag{9001_blind_conditional_responses}',
        ],
    ],
];
