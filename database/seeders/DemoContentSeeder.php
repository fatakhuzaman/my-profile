<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\Concerns\ImportsBundledAssets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Placeholder projects and blog posts for previewing the site layout.
 *
 * Not called by DatabaseSeeder, so it never runs in production. Run it with
 * `php artisan db:seed --class=DemoContentSeeder`; records that already
 * exist (matched by their Indonesian slug) are left alone. Replace or
 * delete this content in the CMS before going live.
 */
class DemoContentSeeder extends Seeder
{
    use ImportsBundledAssets;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedProjects();
        $this->seedPosts();
    }

    private function seedProjects(): void
    {
        $webApp = $this->findOrCreateBySlug(ProjectCategory::class, ['id' => 'Aplikasi Web', 'en' => 'Web App']);
        $erp = $this->findOrCreateBySlug(ProjectCategory::class, ['id' => 'ERP', 'en' => 'ERP']);
        $website = $this->findOrCreateBySlug(ProjectCategory::class, ['id' => 'Website', 'en' => 'Website']);

        $projects = [
            [
                'title' => ['id' => 'Sistem Kasir & Inventaris Toko Retail', 'en' => 'Retail POS & Inventory System'],
                'excerpt' => [
                    'id' => 'Aplikasi kasir berbasis web yang terhubung langsung dengan stok gudang dan laporan penjualan harian.',
                    'en' => 'A web-based point of sale connected to warehouse stock and daily sales reports.',
                ],
                'body' => [
                    'id' => '<h2>Tantangan</h2><p>Toko mencatat penjualan dan stok di dua tempat berbeda, sehingga selisih stok baru ketahuan saat stock opname akhir bulan.</p><h2>Solusi</h2><p>Saya membangun aplikasi kasir berbasis Laravel yang mengurangi stok secara otomatis setiap transaksi, lengkap dengan notifikasi stok minimum dan laporan penjualan per kasir.</p><ul><li>Transaksi kasir dengan barcode scanner</li><li>Manajemen stok multi-gudang</li><li>Laporan harian, mingguan, dan bulanan</li></ul><h2>Hasil</h2><p>Waktu tutup kasir harian turun dari 45 menit menjadi kurang dari 10 menit, dan selisih stok berkurang drastis.</p>',
                    'en' => '<h2>Challenge</h2><p>The store recorded sales and stock in two separate places, so stock differences only surfaced during the monthly stock take.</p><h2>Solution</h2><p>I built a Laravel point of sale that deducts stock automatically on every transaction, with low-stock alerts and per-cashier sales reports.</p><ul><li>Checkout with a barcode scanner</li><li>Multi-warehouse stock management</li><li>Daily, weekly and monthly reports</li></ul><h2>Result</h2><p>Closing the till each day dropped from 45 minutes to under 10, and stock differences fell sharply.</p>',
                ],
                'role' => ['id' => 'Full Stack Development', 'en' => 'Full Stack Development'],
                'client_name' => 'Contoh Klien Retail',
                'year' => 2025,
                'cover' => 'images/projects/work1.jpg',
                'gallery' => ['images/projects/single-project1.jpg', 'images/projects/single-project2.jpg'],
                'categories' => [$webApp, $erp],
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => ['id' => 'Website Company Profile Bilingual', 'en' => 'Bilingual Company Profile Website'],
                'excerpt' => [
                    'id' => 'Website profil perusahaan dua bahasa yang cepat, mudah dikelola lewat CMS, dan dioptimasi untuk SEO.',
                    'en' => 'A fast, two-language company website that is easy to manage through a CMS and optimised for SEO.',
                ],
                'body' => [
                    'id' => '<h2>Tantangan</h2><p>Website lama lambat, sulit diperbarui, dan tidak muncul di hasil pencarian untuk layanan utama perusahaan.</p><h2>Solusi</h2><p>Website dibangun ulang dengan CMS sendiri, struktur URL yang rapi untuk bahasa Indonesia dan Inggris, serta optimasi kecepatan halaman.</p><h2>Hasil</h2><p>Skor performa mobile naik ke atas 90 dan halaman layanan mulai muncul di halaman pertama Google untuk kata kunci lokal.</p>',
                    'en' => '<h2>Challenge</h2><p>The old website was slow, hard to update and missing from search results for the company\'s main services.</p><h2>Solution</h2><p>The site was rebuilt with its own CMS, clean URLs for Indonesian and English, and page speed optimisation.</p><h2>Result</h2><p>The mobile performance score rose above 90 and service pages started ranking on Google\'s first page for local keywords.</p>',
                ],
                'role' => ['id' => 'Web Development & SEO', 'en' => 'Web Development & SEO'],
                'client_name' => 'Contoh Klien Manufaktur',
                'year' => 2024,
                'cover' => 'images/projects/work2.jpg',
                'gallery' => ['images/projects/single-project3.jpg'],
                'categories' => [$website],
                'published_at' => now()->subMonths(5),
            ],
            [
                'title' => ['id' => 'Dashboard Monitoring Produksi', 'en' => 'Production Monitoring Dashboard'],
                'excerpt' => [
                    'id' => 'Dashboard real-time untuk memantau target, hasil, dan kendala produksi di setiap lini.',
                    'en' => 'A real-time dashboard to track targets, output and downtime on every production line.',
                ],
                'body' => [
                    'id' => '<h2>Tantangan</h2><p>Data produksi dikumpulkan manual lewat spreadsheet, sehingga manajemen baru melihat masalah keesokan harinya.</p><h2>Solusi</h2><p>Operator mencatat hasil langsung dari tablet, dan data tampil di dashboard per lini lengkap dengan grafik pencapaian target.</p><h2>Hasil</h2><p>Kendala produksi bisa ditindaklanjuti di hari yang sama dan laporan bulanan tersusun otomatis.</p>',
                    'en' => '<h2>Challenge</h2><p>Production data was collected by hand in spreadsheets, so management only saw problems the next day.</p><h2>Solution</h2><p>Operators log output straight from a tablet, and each line shows up on a dashboard with target-achievement charts.</p><h2>Result</h2><p>Production issues are now handled the same day and monthly reports are generated automatically.</p>',
                ],
                'role' => ['id' => 'Pengembangan Aplikasi Custom', 'en' => 'Custom Application Development'],
                'client_name' => 'Contoh Klien Industri',
                'year' => 2023,
                'cover' => 'images/projects/work3.jpg',
                'gallery' => ['images/projects/single-project4.jpg'],
                'categories' => [$webApp],
                'published_at' => now()->subMonths(9),
            ],
        ];

        foreach ($projects as $index => $data) {
            if (Project::whereSlug(Str::slug($data['title']['id']), 'id')->exists()) {
                continue;
            }

            $project = Project::create([
                'title' => $data['title'],
                'slug' => array_map(Str::slug(...), $data['title']),
                'excerpt' => $data['excerpt'],
                'body' => $data['body'],
                'role' => $data['role'],
                'client_name' => $data['client_name'],
                'year' => $data['year'],
                'cover_image' => $this->importAsset($data['cover'], 'projects'),
                'gallery' => array_values(array_filter(array_map(
                    fn (string $image): ?string => $this->importAsset($image, 'projects/gallery'),
                    $data['gallery'],
                ))),
                'is_featured' => true,
                'sort_order' => $index + 1,
                'published_at' => $data['published_at'],
            ]);

            $project->categories()->sync(array_map(fn (ProjectCategory $category): int => $category->id, $data['categories']));
        }
    }

    private function seedPosts(): void
    {
        $webDevelopment = $this->findOrCreateBySlug(Category::class, ['id' => 'Pengembangan Web', 'en' => 'Web Development']);
        $business = $this->findOrCreateBySlug(Category::class, ['id' => 'ERP & Bisnis', 'en' => 'ERP & Business']);
        $seo = $this->findOrCreateBySlug(Category::class, ['id' => 'SEO', 'en' => 'SEO']);

        $laravel = $this->findOrCreateBySlug(Tag::class, ['id' => 'Laravel', 'en' => 'Laravel']);
        $umkm = $this->findOrCreateBySlug(Tag::class, ['id' => 'UMKM', 'en' => 'Small Business']);
        $performance = $this->findOrCreateBySlug(Tag::class, ['id' => 'Performa', 'en' => 'Performance']);

        $author = User::query()->orderBy('id')->first();

        $posts = [
            [
                'category' => $business,
                'tags' => [$umkm],
                'cover' => 'images/blog/blog1.jpg',
                'days_ago' => 3,
                'featured' => true,
                'title' => ['id' => 'Berapa Biaya Pembuatan Website untuk UMKM di 2026?', 'en' => 'How Much Does a Small Business Website Cost in 2026?'],
                'excerpt' => [
                    'id' => 'Rincian komponen biaya website UMKM, dari domain, hosting, desain, hingga perawatan, supaya Anda bisa menyusun anggaran dengan tepat.',
                    'en' => 'A breakdown of what a small business website costs, from domain and hosting to design and maintenance, so you can budget with confidence.',
                ],
                'body' => [
                    'id' => '<p>Biaya pembuatan website sangat bervariasi, tergantung kebutuhan bisnis Anda. Berikut komponen utama yang perlu dihitung.</p><h2>1. Domain dan hosting</h2><p>Domain .com atau .id dan hosting yang andal adalah biaya tahunan yang wajib ada. Pilih hosting dengan dukungan SSL dan backup otomatis.</p><h2>2. Desain dan pengembangan</h2><p>Landing page sederhana jauh lebih murah dibanding website dengan katalog produk, blog, dan CMS. Tentukan dulu fitur yang benar-benar Anda butuhkan.</p><h2>3. Konten dan SEO</h2><p>Website tanpa konten yang baik sulit ditemukan di Google. Anggarkan waktu atau biaya untuk menulis halaman layanan dan artikel.</p><h2>4. Perawatan</h2><p>Update keamanan, backup, dan perbaikan kecil sebaiknya dianggarkan sejak awal agar website tetap aman.</p>',
                    'en' => '<p>Website costs vary a lot depending on what your business needs. These are the main components to budget for.</p><h2>1. Domain and hosting</h2><p>A .com or local domain and reliable hosting are recurring yearly costs. Choose hosting with SSL and automatic backups.</p><h2>2. Design and development</h2><p>A simple landing page costs far less than a site with a product catalogue, blog and CMS. Decide which features you really need first.</p><h2>3. Content and SEO</h2><p>A website without good content is hard to find on Google. Budget time or money for service pages and articles.</p><h2>4. Maintenance</h2><p>Security updates, backups and small fixes should be budgeted from the start to keep the site safe.</p>',
                ],
            ],
            [
                'category' => $business,
                'tags' => [$umkm],
                'cover' => 'images/blog/blog2.jpg',
                'days_ago' => 12,
                'title' => ['id' => '5 Tanda Bisnis Anda Sudah Butuh Sistem ERP', 'en' => '5 Signs Your Business Needs an ERP System'],
                'excerpt' => [
                    'id' => 'Data tersebar di banyak spreadsheet dan laporan selalu terlambat? Bisa jadi sudah saatnya bisnis Anda memakai ERP.',
                    'en' => 'Data scattered across spreadsheets and reports that are always late? It may be time for your business to adopt ERP.',
                ],
                'body' => [
                    'id' => '<p>ERP (Enterprise Resource Planning) menyatukan data penjualan, stok, keuangan, dan produksi dalam satu sistem. Berikut tanda-tanda bisnis Anda membutuhkannya.</p><ul><li><strong>Data ganda di banyak tempat.</strong> Tim yang berbeda mencatat data yang sama di spreadsheet masing-masing.</li><li><strong>Laporan selalu terlambat.</strong> Laporan bulanan butuh berhari-hari untuk disusun.</li><li><strong>Stok sering tidak cocok.</strong> Selisih stok baru ketahuan saat stock opname.</li><li><strong>Sulit melacak pesanan.</strong> Pelanggan menanyakan status pesanan dan tidak ada yang tahu pasti.</li><li><strong>Bisnis sedang tumbuh.</strong> Proses manual yang dulu cukup kini memperlambat tim.</li></ul><p>Jika Anda mengalami tiga atau lebih tanda di atas, ERP yang disesuaikan dengan proses bisnis Anda bisa menghemat banyak waktu.</p>',
                    'en' => '<p>ERP (Enterprise Resource Planning) brings sales, stock, finance and production data into a single system. These are the signs your business needs one.</p><ul><li><strong>Duplicate data everywhere.</strong> Different teams record the same data in their own spreadsheets.</li><li><strong>Reports are always late.</strong> Monthly reports take days to put together.</li><li><strong>Stock never matches.</strong> Stock differences only show up during stock takes.</li><li><strong>Orders are hard to track.</strong> Customers ask for an order status and nobody knows for sure.</li><li><strong>The business is growing.</strong> Manual processes that used to work now slow the team down.</li></ul><p>If three or more of these sound familiar, an ERP tailored to your processes can save a lot of time.</p>',
                ],
            ],
            [
                'category' => $webDevelopment,
                'tags' => [$laravel],
                'cover' => 'images/blog/blog3.jpg',
                'days_ago' => 21,
                'title' => ['id' => 'Laravel vs WordPress: Mana yang Tepat untuk Website Anda?', 'en' => 'Laravel vs WordPress: Which Is Right for Your Website?'],
                'excerpt' => [
                    'id' => 'WordPress cepat untuk website konten, Laravel unggul untuk aplikasi dengan logika bisnis. Kenali perbedaannya sebelum memilih.',
                    'en' => 'WordPress is quick for content sites, Laravel shines for apps with business logic. Know the difference before you choose.',
                ],
                'body' => [
                    'id' => '<h2>Kapan memilih WordPress</h2><p>WordPress cocok untuk blog dan website company profile sederhana yang butuh cepat online, dengan banyak tema dan plugin siap pakai.</p><h2>Kapan memilih Laravel</h2><p>Laravel tepat untuk aplikasi dengan alur bisnis khusus, seperti sistem pemesanan, dashboard internal, atau integrasi dengan sistem lain.</p><h2>Pertimbangan lain</h2><ul><li>Keamanan: plugin WordPress yang tidak diperbarui sering menjadi celah.</li><li>Performa: aplikasi Laravel bisa dibuat sangat ringan karena hanya memuat yang dibutuhkan.</li><li>Biaya jangka panjang: fitur custom di WordPress bisa menjadi rumit dirawat.</li></ul>',
                    'en' => '<h2>When to choose WordPress</h2><p>WordPress suits blogs and simple company websites that need to go live quickly, with plenty of ready-made themes and plugins.</p><h2>When to choose Laravel</h2><p>Laravel is the right fit for applications with custom business flows, such as booking systems, internal dashboards or integrations with other systems.</p><h2>Other considerations</h2><ul><li>Security: outdated WordPress plugins are a common weak spot.</li><li>Performance: a Laravel app can be very lean because it only loads what it needs.</li><li>Long-term cost: custom features in WordPress can become hard to maintain.</li></ul>',
                ],
            ],
            [
                'category' => $seo,
                'tags' => [$performance],
                'cover' => 'images/projects/work4.jpg',
                'days_ago' => 34,
                'title' => ['id' => 'Cara Membuat Website yang Cepat dan Ramah SEO', 'en' => 'How to Build a Fast, SEO-Friendly Website'],
                'excerpt' => [
                    'id' => 'Kecepatan dan struktur halaman sangat memengaruhi peringkat di Google. Ini langkah praktis yang bisa langsung diterapkan.',
                    'en' => 'Speed and page structure strongly affect your Google ranking. Here are practical steps you can apply right away.',
                ],
                'body' => [
                    'id' => '<ol><li><strong>Render di server.</strong> Pastikan konten utama sudah ada di HTML, bukan dimuat belakangan oleh JavaScript.</li><li><strong>Kompres gambar.</strong> Gunakan format modern dan ukuran yang sesuai dengan tampilan.</li><li><strong>Satu H1 per halaman.</strong> Gunakan heading secara berurutan agar struktur mudah dipahami mesin pencari.</li><li><strong>Meta title dan description unik.</strong> Tulis untuk manusia, bukan hanya untuk mesin.</li><li><strong>URL yang rapi.</strong> Gunakan kata kunci yang jelas, misalnya /layanan/pembuatan-website.</li></ol><p>Dengan dasar yang benar, konten yang bagus akan jauh lebih mudah bersaing di hasil pencarian.</p>',
                    'en' => '<ol><li><strong>Render on the server.</strong> Make sure the main content is in the HTML rather than loaded later by JavaScript.</li><li><strong>Compress images.</strong> Use modern formats and sizes that match how they are displayed.</li><li><strong>One H1 per page.</strong> Use headings in order so search engines understand the structure.</li><li><strong>Unique meta titles and descriptions.</strong> Write them for people, not only for machines.</li><li><strong>Clean URLs.</strong> Use clear keywords, for example /services/web-development.</li></ol><p>With the right foundations, good content has a much easier time competing in search results.</p>',
                ],
            ],
            [
                'category' => $business,
                'tags' => [$umkm, $laravel],
                'cover' => 'images/projects/work5.jpg',
                'days_ago' => 47,
                'title' => ['id' => 'Mengapa Aplikasi Custom Lebih Hemat dalam Jangka Panjang', 'en' => 'Why Custom Software Saves Money in the Long Run'],
                'excerpt' => [
                    'id' => 'Biaya awal aplikasi custom memang lebih besar, tetapi proses yang efisien dan bebas biaya lisensi bisa membuatnya lebih hemat.',
                    'en' => 'Custom software costs more up front, but efficient processes and no licence fees can make it cheaper over time.',
                ],
                'body' => [
                    'id' => '<p>Banyak bisnis memulai dengan aplikasi siap pakai berlangganan bulanan. Seiring waktu, biaya lisensi per pengguna dan proses yang dipaksakan menyesuaikan aplikasi bisa menjadi mahal.</p><h2>Keuntungan aplikasi custom</h2><ul><li>Mengikuti alur kerja Anda, bukan sebaliknya.</li><li>Tidak ada biaya lisensi per pengguna.</li><li>Bisa dikembangkan bertahap sesuai pertumbuhan bisnis.</li><li>Data sepenuhnya milik Anda.</li></ul><h2>Kapan aplikasi siap pakai lebih tepat</h2><p>Untuk kebutuhan umum seperti email atau akuntansi standar, aplikasi siap pakai sering kali sudah cukup. Aplikasi custom paling bernilai untuk proses yang menjadi keunggulan bisnis Anda.</p>',
                    'en' => '<p>Many businesses start with off-the-shelf software on a monthly subscription. Over time, per-user licence fees and processes bent to fit the tool can become expensive.</p><h2>Benefits of custom software</h2><ul><li>It follows your workflow, not the other way around.</li><li>No per-user licence fees.</li><li>It can grow step by step with the business.</li><li>Your data is fully yours.</li></ul><h2>When off-the-shelf is better</h2><p>For common needs such as email or standard accounting, ready-made tools are often enough. Custom software adds the most value for the processes that set your business apart.</p>',
                ],
            ],
            [
                'category' => $webDevelopment,
                'tags' => [$performance],
                'cover' => 'images/projects/work6.jpg',
                'days_ago' => 63,
                'title' => ['id' => 'Checklist Sebelum Meluncurkan Website Baru', 'en' => 'Pre-Launch Checklist for a New Website'],
                'excerpt' => [
                    'id' => 'Daftar periksa singkat agar website baru Anda aman, cepat, dan siap diindeks Google sejak hari pertama.',
                    'en' => 'A short checklist so your new website is secure, fast and ready for Google from day one.',
                ],
                'body' => [
                    'id' => '<ul><li>SSL aktif dan semua halaman memakai HTTPS.</li><li>Formulir kontak sudah diuji dan email benar-benar terkirim.</li><li>Setiap halaman punya meta title dan description sendiri.</li><li>Sitemap dikirim ke Google Search Console.</li><li>Gambar sudah dikompres dan memiliki teks alternatif.</li><li>Halaman 404 ramah pengguna dan redirect dari URL lama sudah dipasang.</li><li>Backup otomatis berjalan.</li><li>Tampilan sudah dicek di ponsel, tablet, dan desktop.</li></ul>',
                    'en' => '<ul><li>SSL is active and every page uses HTTPS.</li><li>The contact form is tested and emails actually arrive.</li><li>Every page has its own meta title and description.</li><li>The sitemap is submitted to Google Search Console.</li><li>Images are compressed and have alt text.</li><li>A friendly 404 page exists and redirects from old URLs are in place.</li><li>Automatic backups are running.</li><li>The layout has been checked on phones, tablets and desktops.</li></ul>',
                ],
            ],
            [
                'category' => $seo,
                'tags' => [$performance],
                'cover' => 'images/projects/single-project.jpg',
                'days_ago' => 80,
                'title' => ['id' => 'Mengenal Core Web Vitals dan Dampaknya ke Ranking Google', 'en' => 'Understanding Core Web Vitals and Their Impact on Google Rankings'],
                'excerpt' => [
                    'id' => 'LCP, INP, dan CLS adalah tiga metrik pengalaman pengguna yang dipakai Google. Ini cara membaca dan memperbaikinya.',
                    'en' => 'LCP, INP and CLS are the three user-experience metrics Google uses. Here is how to read and improve them.',
                ],
                'body' => [
                    'id' => '<h2>LCP (Largest Contentful Paint)</h2><p>Mengukur seberapa cepat konten utama tampil. Targetkan di bawah 2,5 detik dengan mengoptimalkan gambar utama dan menghindari preloader.</p><h2>INP (Interaction to Next Paint)</h2><p>Mengukur seberapa cepat halaman merespons klik atau ketukan. Kurangi JavaScript yang berat agar halaman tetap responsif.</p><h2>CLS (Cumulative Layout Shift)</h2><p>Mengukur seberapa sering tata letak bergeser saat dimuat. Selalu tentukan ukuran gambar dan sediakan ruang untuk elemen yang dimuat belakangan.</p>',
                    'en' => '<h2>LCP (Largest Contentful Paint)</h2><p>Measures how quickly the main content appears. Aim for under 2.5 seconds by optimising the main image and avoiding preloaders.</p><h2>INP (Interaction to Next Paint)</h2><p>Measures how quickly the page responds to clicks or taps. Cut heavy JavaScript to keep the page responsive.</p><h2>CLS (Cumulative Layout Shift)</h2><p>Measures how much the layout jumps while loading. Always set image dimensions and reserve space for late-loading elements.</p>',
                ],
            ],
        ];

        foreach ($posts as $data) {
            if (Post::whereSlug(Str::slug($data['title']['id']), 'id')->exists()) {
                continue;
            }

            $post = Post::create([
                'user_id' => $author?->id,
                'category_id' => $data['category']->id,
                'title' => $data['title'],
                'slug' => array_map(Str::slug(...), $data['title']),
                'excerpt' => $data['excerpt'],
                'body' => $data['body'],
                'cover_image' => $this->importAsset($data['cover'], 'posts'),
                'is_featured' => $data['featured'] ?? false,
                'published_at' => now()->subDays($data['days_ago'])->setTime(9, 0),
            ]);

            $post->tags()->sync(array_map(fn (Tag $tag): int => $tag->id, $data['tags']));
        }
    }

    /**
     * Find a translatable record by its Indonesian slug, or create it.
     *
     * @template TModel of Model
     *
     * @param  class-string<TModel>  $model
     * @param  array<string, string>  $name  locale => name
     * @return TModel
     */
    private function findOrCreateBySlug(string $model, array $name): Model
    {
        $slugs = array_map(Str::slug(...), $name);

        return $model::whereSlug($slugs['id'], 'id')->first()
            ?? $model::create(['name' => $name, 'slug' => $slugs]);
    }
}
