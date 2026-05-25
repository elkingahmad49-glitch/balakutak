<?php

namespace Tests\Feature;

use App\Models\ResearchService;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Event;

class SlugUniquenessTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_research_service_slug_uniqueness()
    {
        $research1 = ResearchService::create([
            'title' => 'Dinamika Pendidikan Karakter',
            'type' => 'research',
        ]);

        $research2 = ResearchService::create([
            'title' => 'Dinamika Pendidikan Karakter',
            'type' => 'community_service',
        ]);

        $this->assertEquals('dinamika-pendidikan-karakter', $research1->slug);
        $this->assertEquals('dinamika-pendidikan-karakter-2', $research2->slug);

        // Update to match
        $research3 = ResearchService::create([
            'title' => 'Judul Berbeda',
            'type' => 'research',
        ]);
        $research3->update(['title' => 'Dinamika Pendidikan Karakter']);
        $this->assertEquals('dinamika-pendidikan-karakter-3', $research3->slug);
    }

    public function test_page_slug_uniqueness()
    {
        $page1 = Page::create([
            'user_id' => $this->user->id,
            'title' => 'Tentang Kami',
            'content' => 'Konten tentang kami',
        ]);

        $page2 = Page::create([
            'user_id' => $this->user->id,
            'title' => 'Tentang Kami',
            'content' => 'Konten tentang kami 2',
        ]);

        $this->assertEquals('tentang-kami', $page1->slug);
        $this->assertEquals('tentang-kami-2', $page2->slug);

        // Update to match
        $page3 = Page::create([
            'user_id' => $this->user->id,
            'title' => 'Judul Halaman Berbeda',
            'content' => 'Konten',
        ]);
        $page3->update(['title' => 'Tentang Kami']);
        $this->assertEquals('tentang-kami-3', $page3->slug);
    }

    public function test_post_slug_uniqueness()
    {
        $post1 = Post::create([
            'user_id' => $this->user->id,
            'title' => 'Berita Utama Hari Ini',
            'content' => 'Konten berita 1',
            'type' => 'news',
            'status' => 'published',
        ]);

        $post2 = Post::create([
            'user_id' => $this->user->id,
            'title' => 'Berita Utama Hari Ini',
            'content' => 'Konten berita 2',
            'type' => 'news',
            'status' => 'published',
        ]);

        $this->assertEquals('berita-utama-hari-ini', $post1->slug);
        $this->assertEquals('berita-utama-hari-ini-2', $post2->slug);

        // Update to match
        $post3 = Post::create([
            'user_id' => $this->user->id,
            'title' => 'Judul Artikel Berbeda',
            'content' => 'Konten berita 3',
            'type' => 'news',
            'status' => 'published',
        ]);
        $post3->update(['title' => 'Berita Utama Hari Ini']);
        $this->assertEquals('berita-utama-hari-ini-3', $post3->slug);
    }

    public function test_event_slug_uniqueness()
    {
        $event1 = Event::create([
            'user_id' => $this->user->id,
            'title' => 'Workshop IT Modern 2026',
            'description' => 'Deskripsi event 1',
            'location' => 'Kampus Utama',
            'start_date' => now()->addDays(5),
        ]);

        $event2 = Event::create([
            'user_id' => $this->user->id,
            'title' => 'Workshop IT Modern 2026',
            'description' => 'Deskripsi event 2',
            'location' => 'Kampus Utama',
            'start_date' => now()->addDays(5),
        ]);

        $this->assertEquals('workshop-it-modern-2026', $event1->slug);
        $this->assertEquals('workshop-it-modern-2026-2', $event2->slug);

        // Update to match
        $event3 = Event::create([
            'user_id' => $this->user->id,
            'title' => 'Seminar Berbeda',
            'description' => 'Deskripsi',
            'location' => 'Online',
            'start_date' => now()->addDays(10),
        ]);
        $event3->update(['title' => 'Workshop IT Modern 2026']);
        $this->assertEquals('workshop-it-modern-2026-3', $event3->slug);
    }
}
