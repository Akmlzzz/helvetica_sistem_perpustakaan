<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Support\Str;

class DocsController extends Controller
{
    protected $docsPath;

    public function __construct()
    {
        $this->docsPath = resource_path('docs');
        if (!File::exists($this->docsPath)) {
            File::makeDirectory($this->docsPath, 0755, true);
        }
    }

    public function index()
    {
        return redirect()->route('admin.docs.show', 'introduction');
    }

    public function show($slug)
    {
        $filePath = $this->docsPath . '/' . $slug . '.md';

        if (!File::exists($filePath)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $markdown = File::get($filePath);

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $htmlContent = $converter->convert($markdown)->getContent();

        // Process HTML to add ID to headings and extract TOC
        $toc = [];
        $htmlContent = preg_replace_callback('/<h([2-3])>(.*?)<\/h\1>/', function ($matches) use (&$toc) {
            $level = (int)$matches[1];
            $title = strip_tags($matches[2]);
            $slugId = 'content-' . Str::slug($title);
            
            $toc[] = [
                'level' => $level,
                'title' => $title,
                'slug' => $slugId,
            ];

            return "<h{$level} id=\"{$slugId}\">{$matches[2]}</h{$level}>";
        }, $htmlContent);

        $navigation = $this->getNavigation();

        return view('admin.docs.index', compact('htmlContent', 'toc', 'navigation', 'slug'));
    }

    private function getNavigation()
    {
        $files = File::files($this->docsPath);
        $nav = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'md') {
                $filename = $file->getFilenameWithoutExtension();
                $title = ucwords(str_replace('-', ' ', $filename));
                $nav[] = [
                    'slug' => $filename,
                    'title' => $title,
                ];
            }
        }
        
        $sectionMap = [
            'Panduan Sistem' => [
                'introduction',
                'logika-autentikasi-akses',
                'fitur-dashboard-profil',
                'manajemen-pengguna',
            ],
            'Manajemen Koleksi' => [
                'manajemen-buku',
            ],
            'Sirkulasi & Transaksi' => [
                'logika-peminjaman-pengembalian',
                'fitur-perpanjangan-pinjaman',
                'logika-pembayaran-denda',
            ],
            'Fitur Anggota' => [
                'logika-koleksi-ulasan',
                'fitur-kartu-anggota-digital',
                'fitur-pengajuan-buku',
            ],
            'Fitur Admin & Lanjutan' => [
                'fitur-laporan-export',
                'fitur-banner-music-player',
                'fitur-ai-chatbot',
                'fitur-autosync-google-sheets',
            ],
        ];

        $navBySections = [];
        $mappedSlugs = [];

        foreach ($sectionMap as $sectionTitle => $slugs) {
            $sectionItems = [];
            foreach ($slugs as $slug) {
                foreach ($nav as $item) {
                    if ($item['slug'] === $slug) {
                        $sectionItems[] = $item;
                        $mappedSlugs[] = $slug;
                        break;
                    }
                }
            }
            if (!empty($sectionItems)) {
                $navBySections[$sectionTitle] = $sectionItems;
            }
        }

        // Tampung dokumen yang tidak masuk ke section manapun
        $unmapped = array_filter($nav, fn($item) => !in_array($item['slug'], $mappedSlugs));
        if (!empty($unmapped)) {
            $navBySections['Lainnya'] = array_values($unmapped);
        }

        return $navBySections;
    }
}
