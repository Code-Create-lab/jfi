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
    | Public Site Navigation
    |--------------------------------------------------------------------------
    |
    | Shared by the header and the mobile menu. "active" lists route name
    | patterns that highlight the item; items with "children" render as
    | dropdowns. Covers the public pages listed in CLAUDE.md section 4.
    |
    */

    'navigation' => [
        ['label' => 'Home', 'route' => 'frontend.home', 'active' => ['frontend.home']],
        ['label' => 'About', 'active' => ['frontend.about.*', 'frontend.office-bearers.*'], 'children' => [
            ['label' => 'About the Federation', 'route' => 'frontend.about.federation'],
            ['label' => 'About Jumpball', 'route' => 'frontend.about.jumpball'],
            ['label' => "President's Message", 'route' => 'frontend.about.president'],
            ['label' => 'National Office Bearers', 'route' => 'frontend.office-bearers.national'],
            ['label' => 'State Office Bearers', 'route' => 'frontend.office-bearers.state'],
        ]],
        ['label' => 'Associations', 'active' => ['frontend.associations.*'], 'children' => [
            ['label' => 'Recognized Associations', 'route' => 'frontend.associations.index'],
            ['label' => 'Register an Association', 'route' => 'frontend.associations.register'],
        ]],
        ['label' => 'Players', 'active' => ['frontend.players.*', 'frontend.certificates.*'], 'children' => [
            ['label' => 'Player Registration', 'route' => 'frontend.players.register'],
            ['label' => 'Player Database', 'route' => 'frontend.players.index'],
            ['label' => 'International Players', 'route' => 'frontend.players.international'],
            ['label' => 'Certificates & Verification', 'route' => 'frontend.certificates.index'],
            ['label' => 'Player Login', 'route' => 'frontend.players.login'],
        ]],
        ['label' => 'Events', 'active' => ['frontend.events.*', 'frontend.results.*'], 'children' => [
            ['label' => 'Current Events', 'route' => 'frontend.events.current'],
            ['label' => 'Upcoming Events', 'route' => 'frontend.events.upcoming'],
            ['label' => 'Previous Events', 'route' => 'frontend.events.previous'],
            ['label' => 'Championship Results', 'route' => 'frontend.results.index'],
        ]],
        ['label' => 'Media', 'active' => ['frontend.news.*', 'frontend.gallery.*', 'frontend.videos', 'frontend.downloads', 'frontend.rule-book'], 'children' => [
            ['label' => 'News & Press Releases', 'route' => 'frontend.news.index'],
            ['label' => 'Photo Gallery', 'route' => 'frontend.gallery.index'],
            ['label' => 'Video Gallery', 'route' => 'frontend.videos'],
            ['label' => 'Downloads & Notices', 'route' => 'frontend.downloads'],
            ['label' => 'Rule Book', 'route' => 'frontend.rule-book'],
        ]],
        ['label' => 'Awareness', 'route' => 'frontend.community.index', 'active' => ['frontend.community.*']],
        ['label' => 'Contact', 'route' => 'frontend.contact', 'active' => ['frontend.contact']],
    ],

    /*
    |--------------------------------------------------------------------------
    | Inner Page Banner Photos
    |--------------------------------------------------------------------------
    |
    | Route name pattern => photo behind the page title (first match wins).
    | Pages without a match use the plain navy banner. Placeholder template
    | photos until the federation supplies its own.
    |
    */

    'page_banners' => [
        'frontend.about.*' => 'assets/images/multiracial-group-of-athletes-playing-paddle-tenni-SNHZS26.jpg',
        'frontend.office-bearers.*' => 'assets/images/multiracial-group-of-athletes-playing-paddle-tenni-SNHZS26.jpg',
        'frontend.associations.*' => 'assets/images/multiracial-group-of-happy-friends-leaving-the-cou-CNDKVTB.jpg',
        'frontend.players.*' => 'assets/images/young-athletic-woman-playing-padel-doubles-on-outd-SKA9CG9.jpg',
        'frontend.events.*' => 'assets/images/happy-athletic-women-having-fun-while-celebrating-E2UZM9M.jpg',
        'frontend.results.*' => 'assets/images/happy-athletic-women-having-fun-while-celebrating-E2UZM9M.jpg',
        'frontend.certificates.*' => 'assets/images/young-athletic-woman-hitting-the-ball-while-playin-J9XJQ27.jpg',
        'frontend.news.*' => 'assets/images/mixed-adult-couple-palying-padel-on-outdoor-court-TT64K26.jpg',
        'frontend.gallery.*' => 'assets/images/mixed-adult-couple-palying-padel-on-outdoor-court-TT64K26.jpg',
        'frontend.videos' => 'assets/images/mixed-adult-couple-palying-padel-on-outdoor-court-TT64K26.jpg',
        'frontend.downloads' => 'assets/images/black-athletic-woman-playing-padel-doubles-on-outd-8U5QAM8.jpg',
        'frontend.rule-book' => 'assets/images/black-athletic-woman-playing-padel-doubles-on-outd-8U5QAM8.jpg',
        'frontend.community.*' => 'assets/images/happy-sportswomen-giving-high-five-after-playing-p-D8ZSZV5.jpg',
        'frontend.contact' => 'assets/images/multiracial-group-of-athletes-going-for-an-outdoor-ZAZBUZY-1024x683.jpg',
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
