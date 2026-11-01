<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Registration Number Prefixes
    |--------------------------------------------------------------------------
    |
    | Player IDs are generated as "{prefix}-{year}-{id}", e.g. JFI-2026-00001.
    | Certificate numbers follow the same pattern, e.g. JFI-C-2026-00001.
    |
    */

    'player_id_prefix' => 'JFI',

    'certificate_prefix' => 'JFI-C',

    /*
    |--------------------------------------------------------------------------
    | Initial Admin Account
    |--------------------------------------------------------------------------
    |
    | Read once by AdminUserSeeder. Outside the local environment both values
    | must be set in .env, otherwise no admin account is created.
    |
    */

    'admin' => [
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Indian States and Union Territories
    |--------------------------------------------------------------------------
    */

    'states' => [
        'Andhra Pradesh',
        'Arunachal Pradesh',
        'Assam',
        'Bihar',
        'Chhattisgarh',
        'Goa',
        'Gujarat',
        'Haryana',
        'Himachal Pradesh',
        'Jharkhand',
        'Karnataka',
        'Kerala',
        'Madhya Pradesh',
        'Maharashtra',
        'Manipur',
        'Meghalaya',
        'Mizoram',
        'Nagaland',
        'Odisha',
        'Punjab',
        'Rajasthan',
        'Sikkim',
        'Tamil Nadu',
        'Telangana',
        'Tripura',
        'Uttar Pradesh',
        'Uttarakhand',
        'West Bengal',
        'Andaman and Nicobar Islands',
        'Chandigarh',
        'Dadra and Nagar Haveli and Daman and Diu',
        'Delhi',
        'Jammu and Kashmir',
        'Ladakh',
        'Lakshadweep',
        'Puducherry',
    ],

    /*
    |--------------------------------------------------------------------------
    | Registration Document Types
    |--------------------------------------------------------------------------
    |
    | Keys are stored in registration_documents.document_type. These are
    | placeholders: confirm the final document list with the client.
    |
    */

    'player_document_types' => [
        'id_proof' => 'ID Proof',
        'age_proof' => 'Age Proof',
    ],

    'association_document_types' => [
        'registration_certificate' => 'Society Registration Certificate',
        'authorization_letter' => 'Authorization Letter',
    ],

];
