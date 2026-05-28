<?php

return [
    'model' => [
        'label' => 'Permohonan',
        'plural_label' => 'Permohonan',
    ],
    'field' => [
        'priority' => [
            'label' => 'Prioritas',
            'type' => [
                'low' => 'Rendah',
                'medium' => 'Sedang',
                'high' => 'Tinggi',
            ],
        ],
        'applicant' => [
            'name' => 'Nama Pemohon',
            'phone' => 'Nomor Telepon Pemohon',
            'email' => 'Email Pemohon',
        ],
        'developer' => 'Developer',
        'property' => [
            'name' => 'Nama Properti / Klaster',
            'type' => 'Tipe Properti',
            'block' => 'Blok',
            'number' => 'Nomor Unit',
            'land_area' => 'Luas Tanah',
            'building_area' => 'Luas Bangunan',
            'price' => 'Harga Properti',
            'price_range' => [
                'label' => 'Rentang Harga',
                'minimum' => 'Minimum',
                'maximum' => 'Maksimum',
            ],
            'price_range_from' => 'Rentang Harga Minimum',
            'price_range_to' => 'Rentang Harga Maksimum',
        ],
        'down_payment_amount' => 'Uang Muka',
        'loan_amount' => 'Nominal KPR',
        'notes' => 'Catatan',
        'marketing_agent' => 'Agen Marketing',
        'payment_method' => 'Metode Pembayaran',
        'id_card' => 'Kartu Tanda Penduduk',
        'down_payment_date' => 'Tanggal UTJ',
        'down_payment_proof' => 'Bukti UTJ',
        'bank_name' => 'Nama Bank',
        'document_progress' => 'Progres Dokumen',
        'credit_approval' => 'Persetujuan Kredit',
        'approval' => 'Persetujuan',
        'approval_date' => 'Tanggal Persetujuan',
        'created_at' => 'Dibuat Pada',
        'updated_at' => 'Diperbarui Pada',
        'akad_scheduled_at' => 'Jadwal Akad Kredit',
        'akad_location' => 'Lokasi Akad',
        'akad_location_placeholder' => 'Contoh: Kantor Cabang Surabaya Timur',
        'akad_status' => 'Status Akad',
    ],
    'section' => [
        'applicant' => [
            'heading' => 'Informasi Pemohon',
            'description' => 'Detail data diri pemohon pinjaman kredit.',
        ],
        'property' => [
            'heading' => 'Informasi Properti',
            'description' => 'Detail properti yang diminati oleh pemohon.',
        ],
        'credit' => [
            'heading' => 'Informasi Kredit',
            'description' => 'Detail pembiayaan dan skema kredit yang diajukan.',
        ],
        'approval' => [
            'heading' => 'Status & Persetujuan',
            'description' => 'Progres pengajuan dan hasil persetujuan.',
        ],
        'internal' => [
            'heading' => 'Catatan Internal',
            'description' => 'Informasi internal yang hanya dapat dilihat oleh tim marketing.',
        ],
        'akad' => [
            'heading' => 'Akad Kredit',
            'description' => 'Penjadwalan dan konfirmasi akad kredit.',
        ],
    ],
];
