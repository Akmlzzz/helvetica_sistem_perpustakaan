<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroBanner;

class HeroBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if any banners exist
        if (HeroBanner::count() > 0) {
            return;
        }

        HeroBanner::create([
            'title_img' => 'img/Gramedia_wordmark.svg', // Assuming this is in public/img, but Storage::url points to storage. We might need to copy or symlink. 
            // Wait, the controller stores in 'public/hero/...'.
            // If I seed manually, I should put paths that work with Storage::url().
            // Storage::url('path') usually maps to /storage/path.
            // If I use existing public images, I might need to copy them to storage/app/public/hero...
            // OR I can just use a full URL or path if I adjust the view.
            // But the view uses {{ Storage::url($banner->bg_img) }}.
            // So I MUST put files in storage/app/public/...
            
            // Let's create a seeder that copies files from public/img to storage/app/public/hero/seed/
            
            'bg_img' => 'hero/seed/bg-hero.png',
            'char_img' => 'hero/seed/char-hero.png',
            'synopsis' => 'Temukan ribuan koleksi buku digital terbaik hanya dalam genggaman Anda. Baca kapan saja, di mana saja.',
            'tags' => 'Populer,Edukasi,Terbaru',
            'target_link' => '#',
            'order_priority' => 1,
            'is_active' => true,
        ]);
    }
}
