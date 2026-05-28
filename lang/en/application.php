<?php

return [
    'model' => [
        'label' => 'Application',
        'plural_label' => 'Applications',
    ],
    'field' => [
        'priority' => [
            'label' => 'Priority',
            'type' => [
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
            ],
        ],
        'applicant' => [
            'name' => 'Applicant Name',
            'phone' => 'Applicant Phone Number',
            'email' => 'Applicant Email',
        ],
        'developer' => 'Developer',
        'property' => [
            'name' => 'Property / Cluster Name',
            'type' => 'Property Type',
            'block' => 'Block',
            'number' => 'Unit Number',
            'land_area' => 'Land Area',
            'building_area' => 'Building Area',
            'price' => 'Property Price',
            'price_range' => [
                'label' => 'Price Range',
                'minimum' => 'Minimum',
                'maximum' => 'Maximum',
            ],
            'price_range_from' => 'Minimum Price Range',
            'price_range_to' => 'Maximum Price Range',
        ],
        'down_payment_amount' => 'Down Payment Amount',
        'loan_amount' => 'Loan Amount',
        'notes' => 'Notes',
        'marketing_agent' => 'Marketing Agent',
        'payment_method' => 'Payment Method',
        'id_card' => 'ID Card',
        'down_payment_date' => 'Down Payment Date',
        'down_payment_proof' => 'Down Payment Proof',
        'bank_name' => 'Bank Name',
        'document_progress' => 'Document Progress',
        'credit_approval' => 'Credit Approval',
        'approval' => 'Approval',
        'approval_date' => 'Approval Date',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'akad_status' => 'Status Akad',
    ],
    'section' => [
        'applicant' => [
            'heading' => 'Applicant Information',
            'description' => 'Personal details of the credit loan applicant.',
        ],
        'property' => [
            'heading' => 'Property Information',
            'description' => 'Details of the property the applicant is interested in.',
        ],
        'credit' => [
            'heading' => 'Credit Information',
            'description' => 'Financing details and the proposed credit scheme.',
        ],
        'approval' => [
            'heading' => 'Status & Approval',
            'description' => 'Application progress and approval outcome.',
        ],
        'internal' => [
            'heading' => 'Internal Notes',
            'description' => 'Internal information visible only to the marketing team.',
        ],
    ],
];
