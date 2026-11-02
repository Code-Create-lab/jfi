<?php

namespace Database\Seeders;

use App\Enums\BearerLevel;
use App\Enums\DownloadCategory;
use App\Enums\Gender;
use App\Enums\NewsType;
use App\Enums\RegistrationStatus;
use App\Models\Banner;
use App\Models\CommunityCategory;
use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\Event;
use App\Models\InternationalPlayer;
use App\Models\News;
use App\Models\OfficeBearer;
use App\Models\Player;
use App\Models\StateAssociation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * One or two sample rows per table for local development and demos.
 * Not called from DatabaseSeeder: php artisan db:seed --class=DemoSeeder
 * Registration documents get small placeholder PDFs on the private disk so
 * downloads work in /admin; other file paths point to placeholders that do
 * not exist on disk.
 */
class DemoSeeder extends Seeder
{
    /**
     * Seed the demo data.
     */
    public function run(): void
    {
        $association = new StateAssociation([
            'name' => 'Maharashtra Jumpball Association',
            'state' => 'Maharashtra',
            'city' => 'Mumbai',
            'address' => 'Sample address, Mumbai',
            'pincode' => '400001',
            'email' => 'maharashtra@example.com',
            'phone' => '+91 00000 00001',
            'president_name' => 'Sample President',
            'secretary_name' => 'Sample Secretary',
            'society_registration_no' => 'MH/0000/2026',
            'terms_accepted_at' => now(),
        ]);
        $association->forceFill(['status' => RegistrationStatus::Approved, 'reviewed_at' => now()])->save();

        $association->documents()->create([
            'document_type' => 'registration_certificate',
            'file_path' => $this->samplePdf('registration-documents/associations/sample-registration-certificate.pdf', 'Sample society registration certificate'),
            'original_name' => 'registration-certificate.pdf',
        ]);

        // Pending application, to try Approve / Reject in /admin.
        $pendingAssociation = StateAssociation::query()->create([
            'name' => 'Karnataka Jumpball Association',
            'state' => 'Karnataka',
            'city' => 'Bengaluru',
            'email' => 'karnataka@example.com',
            'phone' => '+91 00000 00002',
            'president_name' => 'Sample President',
            'terms_accepted_at' => now(),
        ]);

        $pendingAssociation->documents()->create([
            'document_type' => 'authorization_letter',
            'file_path' => $this->samplePdf('registration-documents/associations/sample-authorization-letter.pdf', 'Sample authorization letter'),
            'original_name' => 'authorization-letter.pdf',
        ]);

        $player = new Player([
            'state_association_id' => $association->id,
            'name' => 'Aarav Sharma',
            'father_name' => 'Rajesh Sharma',
            'date_of_birth' => '2008-04-12',
            'gender' => Gender::Male,
            'email' => 'aarav.sharma@example.com',
            'phone' => '+91 00000 00011',
            'password' => 'password',
            'address' => 'Sample address',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'terms_accepted_at' => now(),
        ]);
        $player->forceFill(['status' => RegistrationStatus::Approved, 'reviewed_at' => now()])->save();

        $player->documents()->create([
            'document_type' => 'id_proof',
            'file_path' => $this->samplePdf('registration-documents/players/sample-id-proof.pdf', 'Sample ID proof'),
            'original_name' => 'id-proof.pdf',
        ]);

        Player::query()->create([
            'state_association_id' => $association->id,
            'name' => 'Priya Nair',
            'date_of_birth' => '2009-09-03',
            'gender' => Gender::Female,
            'email' => 'priya.nair@example.com',
            'phone' => '+91 00000 00012',
            'password' => 'password',
            'city' => 'Pune',
            'state' => 'Maharashtra',
            'terms_accepted_at' => now(),
        ]);

        $upcomingEvent = Event::query()->create([
            'title' => 'Senior National Jumpball Championship',
            'summary' => 'Senior men and women teams selected through state trials.',
            'description' => '<p>Sample event description.</p>',
            'venue' => 'Venue to be confirmed',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'start_date' => today()->addMonths(2),
            'end_date' => today()->addMonths(2)->addDays(2),
            'is_featured' => true,
        ]);

        $previousEvent = Event::query()->create([
            'title' => 'Junior National Jumpball Championship',
            'summary' => 'Junior boys and girls teams from affiliated states.',
            'description' => '<p>Sample event description.</p>',
            'venue' => 'Sample Sports Complex',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'start_date' => today()->subMonths(3),
            'end_date' => today()->subMonths(3)->addDays(2),
        ]);

        $previousEvent->results()->createMany([
            [
                'category' => 'Junior Boys',
                'position' => 1,
                'participant_name' => 'Maharashtra',
                'state_association_id' => $association->id,
                'score' => '21 - 17',
            ],
            [
                'category' => 'Junior Boys',
                'position' => 2,
                'participant_name' => 'Delhi',
                'score' => '17 - 21',
            ],
        ]);

        $gallery = $previousEvent->galleries()->create([
            'title' => 'Junior National Championship Photos',
        ]);

        $gallery->images()->createMany([
            ['image' => 'gallery/sample-1.jpg', 'caption' => 'Opening ceremony', 'sort_order' => 1],
            ['image' => 'gallery/sample-2.jpg', 'caption' => 'Junior Boys final', 'sort_order' => 2],
        ]);

        $previousEvent->videos()->create([
            'title' => 'Junior National Championship Highlights',
            'url' => 'https://www.youtube.com/watch?v=VIDEO_ID',
            'sort_order' => 1,
        ]);

        $player->certificates()->create([
            'event_id' => $previousEvent->id,
            'title' => 'Certificate of Merit',
            'achievement' => 'Winner - Junior Boys',
            'issued_on' => $previousEvent->end_date,
        ]);

        Banner::query()->create([
            'title' => 'Raising the Game Across India',
            'subtitle' => 'National championships, athlete registration and coaching pathways.',
            'image' => 'banners/sample-banner.jpg',
            'button_text' => 'Register',
            'button_url' => '/membership',
            'sort_order' => 1,
        ]);

        News::query()->create([
            'title' => 'National Championship Calendar Announced',
            'type' => NewsType::Announcement,
            'excerpt' => 'Dates and host states for the coming season.',
            'content' => '<p>Sample news content.</p>',
            'published_on' => today()->subDays(7),
        ]);

        News::query()->create([
            'title' => 'Junior National Championship Concludes',
            'type' => NewsType::PressRelease,
            'excerpt' => 'Maharashtra win the Junior Boys title.',
            'content' => '<p>Sample press release.</p>',
            'published_on' => $previousEvent->end_date->addDay(),
        ]);

        Download::query()->create([
            'title' => 'Official Rule Book',
            'category' => DownloadCategory::RuleBook,
            'description' => 'Sample rule book entry.',
            'file_path' => 'downloads/sample-rule-book.pdf',
            'published_on' => today()->subDays(7),
        ]);

        Download::query()->create([
            'title' => 'Championship Entry Circular',
            'category' => DownloadCategory::Circular,
            'file_path' => 'downloads/sample-circular.pdf',
            'published_on' => today()->subDays(7),
        ]);

        OfficeBearer::query()->create([
            'level' => BearerLevel::State,
            'state_association_id' => $association->id,
            'name' => 'Name to be confirmed',
            'designation' => 'Secretary',
            'sort_order' => 1,
        ]);

        InternationalPlayer::query()->create([
            'name' => 'Sample International Player',
            'country' => 'Nepal',
            'details' => 'Sample entry.',
            'sort_order' => 1,
        ]);

        $safety = CommunityCategory::query()->create([
            'name' => 'Player Safety',
            'short_description' => 'Guidance for safe training and competition.',
            'support_contact' => 'Federation helpline: to be confirmed',
            'sort_order' => 1,
        ]);

        $safety->posts()->create([
            'title' => 'Safe Play Guidelines',
            'content' => '<p>Sample guidelines.</p>',
            'sort_order' => 1,
        ]);

        $conduct = CommunityCategory::query()->create([
            'name' => 'Respectful Conduct',
            'short_description' => 'Expected conduct for athletes, coaches and officials.',
            'support_contact' => 'Committee contact: to be confirmed',
            'sort_order' => 2,
        ]);

        $conduct->posts()->create([
            'title' => 'Code of Conduct',
            'content' => '<p>Sample code of conduct.</p>',
            'sort_order' => 1,
        ]);

        ContactMessage::query()->create([
            'name' => 'Sample Visitor',
            'email' => 'visitor@example.com',
            'subject' => 'Registration query',
            'message' => 'Sample message asking how to register a district team.',
        ]);
    }

    /**
     * Writes a one-page placeholder PDF to the private disk and returns its path.
     */
    private function samplePdf(string $path, string $title): string
    {
        $text = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $title.' - demo file');
        $stream = "BT /F1 18 Tf 72 720 Td ({$text}) Tj ET";

        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            '<< /Length '.strlen($stream)." >>\nstream\n{$stream}\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1)." 0 obj\n{$object}\nendobj\n";
        }

        $xref = strlen($pdf);
        $pdf .= 'xref'."\n0 ".(count($objects) + 1)."\n0000000000 65535 f \n";

        foreach ($offsets as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= 'trailer << /Size '.(count($objects) + 1)." /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF";

        Storage::disk('local')->put($path, $pdf);

        return $path;
    }
}
