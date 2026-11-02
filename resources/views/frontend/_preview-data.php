<?php

/**
 * Design preview data for the frontend views.
 *
 * Views fall back to these unsaved models only when a variable is missing
 * (e.g. `$events ??= (require ...)['events']`). Once controllers pass real
 * data, delete this file and the fallback lines. Nothing here touches the
 * database. Names, dates and figures are samples, not federation records.
 */

use App\Enums\BearerLevel;
use App\Enums\DownloadCategory;
use App\Enums\NewsType;
use App\Enums\RegistrationStatus;
use App\Models\Banner;
use App\Models\Certificate;
use App\Models\CommunityCategory;
use App\Models\CommunityPost;
use App\Models\Download;
use App\Models\Event;
use App\Models\EventResult;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\InternationalPlayer;
use App\Models\News;
use App\Models\OfficeBearer;
use App\Models\Page;
use App\Models\Player;
use App\Models\StateAssociation;
use App\Models\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

$association = fn (string $state, string $city): StateAssociation => (new StateAssociation([
    'name' => $state.' Jumpball Association',
    'state' => $state,
    'city' => $city,
    'president_name' => 'To be confirmed',
    'secretary_name' => 'To be confirmed',
]))->forceFill(['status' => RegistrationStatus::Approved]);

$associations = collect([
    'maharashtra' => $association('Maharashtra', 'Mumbai'),
    'delhi' => $association('Delhi', 'New Delhi'),
    'karnataka' => $association('Karnataka', 'Bengaluru'),
    'tamil-nadu' => $association('Tamil Nadu', 'Chennai'),
    'west-bengal' => $association('West Bengal', 'Kolkata'),
    'uttar-pradesh' => $association('Uttar Pradesh', 'Lucknow'),
]);

$nationalBearers = collect([
    ['Rupesh Utam', 'President', 'rupesh-utam.webp', 'Pune, Maharashtra'],
    ['Ram Pravesh Kumar', 'Secretary General', 'ram-pravesh-kumar.webp', null],
    ['Rajesh Ranjan', 'Treasurer', 'rajesh-ranjan.webp', null],
])->map(fn (array $bearer, int $index): OfficeBearer => new OfficeBearer([
    'level' => BearerLevel::National,
    'name' => $bearer[0],
    'designation' => $bearer[1],
    'location' => $bearer[3],
    'photo' => 'assets/images/jfi/bearers/'.$bearer[2],
    'sort_order' => $index + 1,
]));

$stateBearers = $associations->only(['maharashtra', 'delhi', 'karnataka'])
    ->flatMap(fn (StateAssociation $stateAssociation): array => collect(['President', 'Secretary', 'Treasurer'])
        ->map(fn (string $designation): OfficeBearer => (new OfficeBearer([
            'level' => BearerLevel::State,
            'name' => 'Name to be confirmed',
            'designation' => $designation,
        ]))->setRelation('stateAssociation', $stateAssociation))
        ->all());

$players = collect([
    ['Aarav Sharma', 'maharashtra'], ['Priya Nair', 'maharashtra'], ['Rohan Verma', 'delhi'],
    ['Ananya Iyer', 'tamil-nadu'], ['Kabir Malhotra', 'delhi'], ['Meera Kulkarni', 'maharashtra'],
    ['Arjun Rao', 'karnataka'], ['Ritika Das', 'west-bengal'], ['Vikram Joshi', 'uttar-pradesh'],
    ['Fatima Khan', 'uttar-pradesh'],
])->map(fn (array $player, int $index): Player => (new Player(['name' => $player[0]]))
    ->forceFill([
        'registration_no' => sprintf('JFI-2026-%05d', $index + 1),
        'status' => RegistrationStatus::Approved,
    ])
    ->setRelation('stateAssociation', $associations[$player[1]]));

$internationalPlayers = collect([
    ['Bishal Thapa', 'Nepal'], ['Tanvir Ahmed', 'Bangladesh'],
    ['Kasun Perera', 'Sri Lanka'], ['Karma Dorji', 'Bhutan'],
])->map(fn (array $player, int $index): InternationalPlayer => new InternationalPlayer([
    'name' => $player[0],
    'country' => $player[1],
    'details' => 'Sample entry. Profile details are supplied by the federation.',
    'sort_order' => $index + 1,
]));

$result = fn (string $category, int $position, string $team, ?string $associationKey, string $score): EventResult => (new EventResult([
    'category' => $category,
    'position' => $position,
    'participant_name' => $team,
    'score' => $score,
]))->setRelation('stateAssociation', $associationKey ? $associations[$associationKey] : null);

$junior = (new Event([
    'title' => 'Junior National Jumpball Championship',
    'slug' => 'junior-national-jumpball-championship',
    'summary' => 'Junior boys and girls teams from affiliated state associations.',
    'description' => '<p>The Junior National Championship brings together junior teams selected through state trials. Results from this championship count towards national squad selection.</p><p>Matches are played under the current JFI rule book with accredited technical officials.</p>',
    'venue' => 'Venue to be confirmed',
    'city' => 'Mumbai',
    'state' => 'Maharashtra',
    'start_date' => today()->subMonths(3),
    'end_date' => today()->subMonths(3)->addDays(2),
]))->setRelation('results', collect([
    $result('Junior Boys', 1, 'Maharashtra', 'maharashtra', '21 - 17'),
    $result('Junior Boys', 2, 'Delhi', 'delhi', '17 - 21'),
    $result('Junior Boys', 3, 'Karnataka', 'karnataka', '19 - 15'),
    $result('Junior Boys', 4, 'Tamil Nadu', 'tamil-nadu', '15 - 19'),
    $result('Junior Girls', 1, 'Delhi', 'delhi', '18 - 16'),
    $result('Junior Girls', 2, 'Maharashtra', 'maharashtra', '16 - 18'),
    $result('Junior Girls', 3, 'West Bengal', 'west-bengal', '20 - 12'),
]));

$invitational = (new Event([
    'title' => 'Inter-State Jumpball Invitational',
    'slug' => 'inter-state-jumpball-invitational',
    'summary' => 'Open category teams from six state associations.',
    'description' => '<p>An open category invitational hosted with the state association. Sample description.</p>',
    'venue' => 'Venue to be confirmed',
    'city' => 'Bengaluru',
    'state' => 'Karnataka',
    'start_date' => today()->subMonths(7),
    'end_date' => today()->subMonths(7)->addDay(),
]))->setRelation('results', collect([
    $result('Open Men', 1, 'Karnataka', 'karnataka', '22 - 19'),
    $result('Open Men', 2, 'Maharashtra', 'maharashtra', '19 - 22'),
    $result('Open Men', 3, 'Uttar Pradesh', 'uttar-pradesh', '17 - 14'),
]));

$upcoming = collect([
    (new Event([
        'title' => 'Senior National Jumpball Championship',
        'slug' => 'senior-national-jumpball-championship',
        'summary' => 'Senior men and women teams selected through state trials.',
        'description' => '<p>The flagship event of the national calendar. Teams enter through their state association on the entry form issued with the championship circular.</p>',
        'venue' => 'Venue to be confirmed',
        'city' => 'New Delhi',
        'state' => 'Delhi',
        'start_date' => today()->addMonths(2),
        'end_date' => today()->addMonths(2)->addDays(2),
        'is_featured' => true,
    ]))->setRelation('results', collect()),
    (new Event([
        'title' => 'Sub-Junior National Jumpball Championship',
        'slug' => 'sub-junior-national-jumpball-championship',
        'summary' => 'Sub-junior boys and girls divisions with age verified at registration.',
        'description' => '<p>Sample description for the sub-junior championship.</p>',
        'venue' => 'Venue to be confirmed',
        'city' => 'Bhopal',
        'state' => 'Madhya Pradesh',
        'start_date' => today()->addMonths(4),
        'end_date' => today()->addMonths(4)->addDays(3),
        'is_featured' => true,
    ]))->setRelation('results', collect()),
]);

$previous = collect([$junior, $invitational]);

$news = collect([
    ['Entries Open for the Senior National Jumpball Championship', NewsType::Announcement, 3],
    ['Maharashtra Win the Junior Boys Title at the Junior Nationals', NewsType::PressRelease, 88],
    ['State Associations Invited to Complete Annual Affiliation', NewsType::News, 12],
    ['Revised Rule Book Published for the Coming Season', NewsType::Announcement, 20],
    ['Player Registration Now Open Online', NewsType::News, 30],
    ['Inter-State Invitational Concludes in Bengaluru', NewsType::PressRelease, 208],
])->map(fn (array $item): News => new News([
    'title' => $item[0],
    'slug' => Str::slug($item[0]),
    'type' => $item[1],
    'excerpt' => 'Sample summary of the update. The full text is published by the federation office.',
    'content' => '<p>This is sample article text used to preview the news layout. The federation office publishes the full announcement, including dates, eligibility and contact details.</p><h2>Key points</h2><ul><li>Entries are submitted through affiliated state associations.</li><li>Only registered players with a JFI Player ID are eligible.</li><li>Refer to the official circular in Downloads for full details.</li></ul><p>For questions, contact the federation office using the details on the Contact page.</p>',
    'published_on' => today()->subDays($item[2]),
]));

$downloads = collect([
    ['Official Jumpball Rule Book (Current Edition)', DownloadCategory::RuleBook, 'rule-book-current.pdf', 20],
    ['Rule Book (Previous Edition)', DownloadCategory::RuleBook, 'rule-book-previous.pdf', 400],
    ['Circular: Senior National Championship Entries', DownloadCategory::Circular, 'circular-senior-nationals.pdf', 3],
    ['Notice: Annual Affiliation Deadline', DownloadCategory::Notice, 'notice-affiliation.pdf', 12],
    ['State Association Affiliation Form', DownloadCategory::Form, 'affiliation-form.pdf', 45],
    ['Code of Conduct for Athletes and Officials', DownloadCategory::Document, 'code-of-conduct.pdf', 60],
])->map(fn (array $item): Download => new Download([
    'title' => $item[0],
    'category' => $item[1],
    'description' => 'Sample description of the document.',
    'file_path' => 'downloads/'.$item[2],
    'published_on' => today()->subDays($item[3]),
]));

// Placeholder photos from the original template, used until the federation supplies its own.
$photos = [
    'assets/images/happy-athletic-women-having-fun-while-celebrating-E2UZM9M.jpg',
    'assets/images/multiracial-group-of-athletes-playing-paddle-tenni-SNHZS26.jpg',
    'assets/images/mixed-adult-couple-palying-padel-on-outdoor-court-TT64K26.jpg',
    'assets/images/happy-sportswomen-giving-high-five-after-playing-p-D8ZSZV5.jpg',
    'assets/images/black-athletic-woman-playing-padel-doubles-on-outd-8U5QAM8.jpg',
    'assets/images/multiracial-group-of-athletes-going-for-an-outdoor-ZAZBUZY-1024x683.jpg',
    'assets/images/young-athletic-woman-hitting-the-ball-while-playin-J9XJQ27.jpg',
    'assets/images/multiracial-group-of-happy-friends-leaving-the-cou-CNDKVTB.jpg',
    'assets/images/young-athletic-woman-playing-padel-doubles-on-outd-SKA9CG9.jpg',
    'assets/images/man-trying-to-reach-the-ball-playing-pickleball-9W7DN8G.jpg',
];

$banners = collect([5, 0, 2, 3])->map(fn (int $photo, int $index): Banner => new Banner([
    'title' => 'Home banner '.($index + 1),
    'image' => $photos[$photo],
    'sort_order' => $index + 1,
]));

$galleryImages = fn (int $count, array $captions, int $offset = 0): Collection => collect(range(1, $count))
    ->map(fn (int $number): GalleryImage => new GalleryImage([
        'image' => $photos[($number - 1 + $offset) % count($photos)],
        'caption' => $captions[($number - 1) % count($captions)],
        'sort_order' => $number,
    ]));

$galleries = collect([
    (new Gallery(['title' => 'Junior National Championship', 'slug' => 'junior-national-championship']))
        ->setRelation('event', $junior)
        ->setRelation('images', $galleryImages(8, ['Opening ceremony', 'Junior Boys semi-final', 'Junior Girls final', 'Medal presentation'])),
    (new Gallery(['title' => 'Inter-State Invitational', 'slug' => 'inter-state-invitational']))
        ->setRelation('event', $invitational)
        ->setRelation('images', $galleryImages(6, ['Team introductions', 'Open Men final', 'Prize distribution'], 3)),
    (new Gallery(['title' => 'Federation General Meeting', 'slug' => 'federation-general-meeting']))
        ->setRelation('event', null)
        ->setRelation('images', $galleryImages(4, ['State representatives', 'Address by the President'], 5)),
]);

$videos = collect([
    ['Junior National Championship: Final Highlights', $junior],
    ['Inter-State Invitational: Open Men Final', $invitational],
    ['How Jumpball Is Played', null],
    ['Message from the Federation', null],
])->map(fn (array $item): Video => (new Video([
    'title' => $item[0],
    'url' => 'https://www.youtube.com/watch?v=VIDEO_ID',
]))->setRelation('event', $item[1]));

$post = fn (string $title, ?string $document = null): CommunityPost => new CommunityPost([
    'title' => $title,
    'slug' => Str::slug($title),
    'content' => '<p>Sample guidance text. The federation publishes the approved wording for this section.</p><ul><li>Know who to contact before an event.</li><li>Report concerns to the contact listed on this page.</li></ul>',
    'document_path' => $document,
]);

$categories = collect([
    ['Player Safety', 'Guidance for safe training, travel and competition.', [$post('Safe Play Guidelines', 'community/safe-play-guidelines.pdf'), $post('Travel and Accommodation at Events'), $post('Medical Emergencies at Venues')]],
    ['Prevention of Sexual Harassment', 'How the federation protects athletes and officials, and who to contact.', [$post('Our Commitment'), $post('Committee Contact and Process', 'community/committee-process.pdf')]],
    ['Respectful Conduct', 'Expected conduct for athletes, coaches, officials and spectators.', [$post('Code of Conduct', 'community/code-of-conduct.pdf'), $post('Conduct at Venues')]],
    ['Fair Play and Anti-Doping', 'Awareness on fair competition and clean sport.', [$post('Fair Play Principles'), $post('Anti-Doping Awareness')]],
])->map(fn (array $item, int $index): CommunityCategory => (new CommunityCategory([
    'name' => $item[0],
    'slug' => Str::slug($item[0]),
    'short_description' => $item[1],
    'description' => '<p>'.$item[1].' This section is for information only. Sample text.</p>',
    'support_contact' => "Federation office: +91 00000 00000\nEmail: info@example.com",
    'sort_order' => $index + 1,
]))->setRelation('posts', collect($item[2])));

$pages = collect([
    'about-federation' => new Page([
        'slug' => 'about-federation',
        'title' => 'About the Federation',
        'subtitle' => 'The national governing body for Jumpball in India.',
        'content' => '<h2>Overview</h2><p>The Jumpball Federation of India sets the rules, sanctions competition and builds the structures the sport needs to grow, from school and district level through to the national team. Sample text: the federation supplies the final wording.</p><h2>Objectives</h2><ul><li>Promote and develop Jumpball across every state and union territory.</li><li>Conduct national championships and maintain official results.</li><li>Register players and recognize state associations.</li><li>Maintain the official rule book and standards of play.</li></ul><h2>Mission</h2><p>To give every player in India a fair, well-organised route from local competition to national selection.</p><h2>Vision</h2><p>A strong national Jumpball community with recognized associations in every state.</p>',
    ]),
    'about-jumpball' => new Page([
        'slug' => 'about-jumpball',
        'title' => 'About Jumpball',
        'subtitle' => 'An introduction to the sport.',
        'content' => '<h2>The game</h2><p>Sample introduction to Jumpball. The federation supplies the approved description of the sport, its history and how it is played.</p><h2>Categories</h2><p>Competitions are organised in sub-junior, junior and senior categories for men and women.</p><h2>Rules</h2><p>Matches are played under the official JFI rule book, available on the Rule Book page.</p>',
    ]),
    'president-message' => new Page([
        'slug' => 'president-message',
        'title' => "President's Message",
        'subtitle' => 'A message from the President of the Jumpball Federation of India.',
        'content' => '<p>Sample message text. The President\'s message is supplied by the federation and published here unchanged.</p><blockquote>Every player deserves a clear and fair route to represent their state and their country.</blockquote><p>Our focus is on strong state associations, transparent selection and well-run championships.</p>',
    ]),
    'privacy-policy' => new Page([
        'slug' => 'privacy-policy',
        'title' => 'Privacy Policy',
        'subtitle' => 'How the federation handles personal information.',
        'content' => '<p>Placeholder. The federation will supply the approved privacy policy text.</p><h2>Information we collect</h2><p>Placeholder text.</p><h2>How information is used</h2><p>Placeholder text.</p><h2>Contact</h2><p>Placeholder text.</p>',
    ]),
    'terms-and-conditions' => new Page([
        'slug' => 'terms-and-conditions',
        'title' => 'Terms & Conditions',
        'subtitle' => 'Terms for using this website and its services.',
        'content' => '<p>Placeholder. The federation will supply the approved terms and conditions.</p><h2>Use of this website</h2><p>Placeholder text.</p><h2>Registrations</h2><p>Placeholder text.</p>',
    ]),
]);

$certificate = (new Certificate([
    'title' => 'Certificate of Merit',
    'achievement' => 'Winner - Junior Boys',
    'issued_on' => $junior->end_date,
]))->forceFill([
    'certificate_no' => 'JFI-C-2026-00001',
    'verification_code' => 'SAMPLE',
])->setRelation('player', $players->first())->setRelation('event', $junior);

return [
    'banners' => $banners,
    // Home page counters: approved associations, approved players and events held (sample figures).
    'stats' => ['associations' => 28, 'players' => 1500, 'championships' => 12],
    'associations' => $associations->values(),
    'nationalBearers' => $nationalBearers,
    'stateBearers' => $stateBearers,
    'players' => $players,
    'internationalPlayers' => $internationalPlayers,
    'upcoming' => $upcoming,
    'current' => collect(),
    'previous' => $previous,
    'news' => $news,
    'downloads' => $downloads,
    'galleries' => $galleries,
    'videos' => $videos,
    'categories' => $categories,
    'pages' => $pages,
    'certificate' => $certificate,
    'contact' => [
        'email' => 'info@example.com',
        'phone' => '+91 00000 00000',
        'address' => 'Address to be confirmed',
    ],
];
