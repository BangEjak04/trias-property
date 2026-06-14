<?php

return [
    'model' => [
        'label' => 'Produk Knowledge',
        'pluralLabel' => 'Produk Knowledge',
    ],
    'field' => [
        'name' => 'Nama Produk',
        'url' => 'Link',
        'order' => 'Urutan',
        'is_active' => 'Tampilkan',
        'created_at' => 'Dibuat Pada',
        'updated_at' => 'Diperbarui Pada',
    ],
    'section' => [
        'information' => [
            'label' => 'Detail Produk',
            'description' => 'Informasi nama produk dan tautan yang akan ditampilkan di dashboard.',
        ],
        'visibility' => [
            'label' => 'Visibilitas',
            'description' => 'Atur urutan tampil dan status aktif produk di dashboard.',
        ],
    ],
    'filter' => [
        'is_active' => 'Status Tampil',
        'active' => 'Tampil',
        'inactive' => 'Tidak Tampil',
    ],
];
