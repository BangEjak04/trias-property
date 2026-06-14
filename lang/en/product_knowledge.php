<?php

return [
    'model' => [
        'label' => 'Product Knowledge',
        'pluralLabel' => 'Product Knowledges',
    ],
    'field' => [
        'name' => 'Product Name',
        'url' => 'Link',
        'order' => 'Order',
        'is_active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'section' => [
        'information' => [
            'label' => 'Product Details',
            'description' => 'Product name and link that will be displayed on the dashboard.',
        ],
        'visibility' => [
            'label' => 'Visibility',
            'description' => 'Set the display order and active status of the product on the dashboard.',
        ],
    ],
    'filter' => [
        'is_active' => 'Visibility Status',
        'active' => 'Visible',
        'inactive' => 'Hidden',
    ],
];
