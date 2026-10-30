<?php

namespace Database\Seeders;

use App\Enums\ResumeEntryType;
use App\Models\Client;
use App\Models\Page;
use App\Models\PricingPlan;
use App\Models\ResumeEntry;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use Database\Seeders\Concerns\ImportsBundledAssets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds the site content that used to be hard-coded in the Blade views.
 *
 * Every table is only seeded while it is still empty, so running this
 * again never overwrites content that has since been edited in the CMS.
 * Images and files bundled in `public/` are copied onto the media disk so
 * they can be managed (and replaced) from the CMS like any upload.
 */
class ContentSeeder extends Seeder
{
    use ImportsBundledAssets;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedSettings();
        $this->seedPages();
        $this->seedServices();
        $this->seedPricingPlans();
        $this->seedResumeEntries();
        $this->seedSkills();
        $this->seedClients();
    }

    private function seedSettings(): void
    {
        $settings = [
            'site.name' => 'Fatakhuzaman',
            'person.full_name' => 'Muhamad Nur Fatakhuzaman',
            'person.short_name' => 'Fatah',
            'person.headline' => [
                'id' => 'Programmer dengan pengalaman 4+ tahun, sebelumnya di PT Astra Daihatsu Motor dan PT Metafora Indonesia Teknologi.',
                'en' => 'Programmer with 4+ years of experience, formerly at PT Astra Daihatsu Motor and PT Metafora Indonesia Teknologi.',
            ],
            'person.photo' => $this->importAsset('images/about/profile.png', 'profile'),
            'person.cv_file' => $this->importAsset('files/Muhamad-Nur-Fatakhuzaman_CV.pdf', 'files'),
            'person.available_for_work' => true,
            'contact.email' => 'muhamadnurfatakhuzaman@gmail.com',
            'contact.notification_email' => 'fatakhuzaman@gmail.com',
            'contact.phone' => '+6288226377174',
            'contact.whatsapp' => '6288226377174',
            'contact.address' => ['id' => 'Tegal, Indonesia', 'en' => 'Tegal, Indonesia'],
            'contact.map_url' => 'https://www.google.com/maps/place/Kabupaten+Tegal,+Jawa+Tengah',
            'social.instagram' => 'https://www.instagram.com/fatakhuzaman/',
            'social.linkedin' => 'https://www.linkedin.com/in/muhamad-nur-fatakhuzaman-079143205/',
            'social.github' => 'https://github.com/fatakhuzaman',
            'footer.cta_heading' => [
                'id' => 'Siap memulai proyek Anda dengan sentuhan ajaib?',
                'en' => 'Are You Ready to kickstart your project with a touch of magic?',
            ],
            'footer.cta_text' => [
                'id' => 'Hubungi saya dan mari wujudkan bersama ✨. Saya juga terbuka untuk peluang Full-time maupun Part-time untuk menghadirkan pengembangan software yang luar biasa.',
                'en' => "Reach out and let's make it happen ✨. I'm also available for Full-time or Part-time opportunities to push the boundaries of software development and deliver exceptional work.",
            ],
            'seo.default_og_image' => $this->importAsset('images/about/profile.jpg', 'seo'),
        ];

        if (Setting::query()->exists()) {
            return;
        }

        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }

    private function seedPages(): void
    {
        $pages = [
            'home' => [
                'title' => ['id' => 'Beranda', 'en' => 'Home'],
                'meta_title' => [
                    'id' => 'Fatakhuzaman — Jasa Pembuatan Website & Aplikasi',
                    'en' => 'Fatakhuzaman — Web & Application Developer',
                ],
                'meta_description' => [
                    'id' => 'Programmer berpengalaman 4+ tahun. Melayani jasa pembuatan website, aplikasi custom, ERP, dan konsultasi IT untuk UMKM hingga perusahaan.',
                    'en' => 'Programmer with 4+ years of experience building websites, custom applications, ERP software and IT consulting for SMEs and enterprises.',
                ],
                'content' => [
                    'id' => [
                        'hero' => [
                            'greeting' => 'Halo!',
                            'heading' => 'Saya Fatah, profesional dengan pengalaman lebih dari 4 tahun di bidang pengembangan aplikasi, pemrograman, dan IT.',
                        ],
                        'clients' => ['label' => 'Perusahaan tempat saya bekerja', 'heading' => '5+ Perusahaan Global'],
                    ],
                    'en' => [
                        'hero' => [
                            'greeting' => 'Hello There!',
                            'heading' => "I'm Fatah, a professional with over 4 years of experience in application development, programming, and IT.",
                        ],
                        'clients' => ['label' => 'Company I work', 'heading' => '5+ Global Companies'],
                    ],
                ],
            ],
            'about' => [
                'title' => ['id' => 'Tentang Saya', 'en' => 'About'],
                'meta_title' => [
                    'id' => 'Tentang Muhamad Nur Fatakhuzaman — Full Stack Developer',
                    'en' => 'About Muhamad Nur Fatakhuzaman — Full Stack Developer',
                ],
                'meta_description' => [
                    'id' => 'Pengalaman kerja, pendidikan, prestasi, dan keahlian Muhamad Nur Fatakhuzaman sebagai programmer dan full stack developer.',
                    'en' => 'Work experience, education, achievements and skills of Muhamad Nur Fatakhuzaman, programmer and full stack developer.',
                ],
                'content' => [
                    'id' => [
                        'intro' => [
                            'greeting' => 'Halo!',
                            'heading' => 'Saya Muhamad Nur Fatakhuzaman.',
                            'body' => "Saya seorang profesional dengan pengalaman lebih dari 4 tahun di bidang pengembangan aplikasi, pemrograman, dan IT, dengan pengalaman kerja sebelumnya di PT Astra Daihatsu Motor dan PT Metafora Indonesia Teknologi.\n\nSaya terlibat dalam membangun sistem digital internal serta berbagai proyek web di berbagai industri.\n\nSaat ini saya sedang menempuh semester 5 program Sarjana Teknologi Informasi. Ketertarikan saya pada pengembangan web dimulai sejak SMK jurusan Rekayasa Perangkat Lunak dan terus berkembang melalui pengalaman kerja dan studi.",
                        ],
                        'skills' => ['label' => 'Keahlian', 'heading' => 'Jelajahi Keahlian Saya'],
                    ],
                    'en' => [
                        'intro' => [
                            'greeting' => 'Hello There!',
                            'heading' => "I'm Muhamad Nur Fatakhuzaman.",
                            'body' => "I am a professional with over 4 years of experience in application development, programming, and IT, with previous roles at PT Astra Daihatsu Motor and PT Metafora Indonesia Teknologi.\n\nI've been involved in building internal digital systems and various web projects across different industries.\n\nCurrently, I'm in my 5th semester pursuing a Bachelor's in Information Technology. My passion for web development started back in vocational school with a major in Software Engineering and has grown through hands-on work and ongoing studies.",
                        ],
                        'skills' => ['label' => 'Pro Skills', 'heading' => "Let's Explore My Skills"],
                    ],
                ],
            ],
            'services' => [
                'title' => ['id' => 'Layanan', 'en' => 'Services'],
                'meta_title' => [
                    'id' => 'Layanan & Harga — Jasa Website, Aplikasi, ERP, Konsultan IT',
                    'en' => 'Services & Pricing — Web, Apps, ERP and IT Consulting',
                ],
                'meta_description' => [
                    'id' => 'Jasa pembuatan website, aplikasi mobile, aplikasi custom, software ERP, dan konsultasi IT dengan paket harga yang fleksibel.',
                    'en' => 'Website, mobile app, custom application, ERP software and IT consulting services with flexible pricing plans.',
                ],
                'content' => [
                    'id' => [
                        'services' => ['label' => 'Layanan', 'heading' => 'Layanan Berkualitas'],
                        'pricing' => ['label' => 'Harga', 'heading' => 'Paket Harga Fleksibel'],
                    ],
                    'en' => [
                        'services' => ['label' => 'Services', 'heading' => 'Quality Services'],
                        'pricing' => ['label' => 'Pricing', 'heading' => 'Flexible Pricing Plan'],
                    ],
                ],
            ],
            'works' => [
                'title' => ['id' => 'Portofolio', 'en' => 'Works'],
                'meta_title' => [
                    'id' => 'Portofolio Proyek — Fatakhuzaman',
                    'en' => 'Works & Projects — Fatakhuzaman',
                ],
                'meta_description' => [
                    'id' => 'Kumpulan proyek website dan aplikasi yang pernah saya kerjakan untuk klien dan perusahaan.',
                    'en' => "A selection of websites and applications I've built for clients and companies.",
                ],
                'content' => [
                    'id' => [
                        'header' => [
                            'heading' => 'Portofolio & Proyek',
                            'body' => 'Beberapa proyek yang saya kerjakan dengan sepenuh hati, masing-masing mencerminkan dedikasi saya pada setiap detail.',
                            'show_all' => 'Semua',
                        ],
                    ],
                    'en' => [
                        'header' => [
                            'heading' => 'Works & Projects',
                            'body' => 'Some of the projects I have crafted with love and dedication, each one reflecting the care I put into every detail.',
                            'show_all' => 'Show All',
                        ],
                    ],
                ],
            ],
            'blog' => [
                'title' => ['id' => 'Blog', 'en' => 'Blog'],
                'meta_title' => [
                    'id' => 'Blog — Tips Website, Aplikasi & Teknologi',
                    'en' => 'Blog — Web, Apps & Technology Insights',
                ],
                'meta_description' => [
                    'id' => 'Artikel seputar pembuatan website, pengembangan aplikasi, ERP, dan teknologi untuk bisnis.',
                    'en' => 'Articles about building websites, application development, ERP and technology for businesses.',
                ],
                'content' => [
                    'id' => ['header' => ['heading' => 'Blog', 'empty' => 'Segera Hadir']],
                    'en' => ['header' => ['heading' => 'Blog', 'empty' => 'Coming Soon']],
                ],
            ],
            'contact' => [
                'title' => ['id' => 'Kontak', 'en' => 'Contact'],
                'meta_title' => [
                    'id' => 'Hubungi Saya — Konsultasi Gratis Proyek Anda',
                    'en' => 'Contact — Let’s Talk About Your Project',
                ],
                'meta_description' => [
                    'id' => 'Hubungi Fatakhuzaman lewat formulir, WhatsApp, atau email untuk diskusi proyek website dan aplikasi Anda.',
                    'en' => 'Get in touch with Fatakhuzaman via the form, WhatsApp or email to discuss your website or application project.',
                ],
                'content' => [
                    'id' => [
                        'header' => ['label' => 'Kontak', 'heading' => 'Hubungi Saya!'],
                        'form' => [
                            'name' => 'Nama Lengkap',
                            'email' => 'Alamat Email',
                            'message' => 'Pesan Anda',
                            'submit' => 'Kirim Pesan',
                            'success' => 'Pesan terkirim! Saya akan segera membalas.',
                        ],
                    ],
                    'en' => [
                        'header' => ['label' => 'Contact', 'heading' => 'Get in Touch with Me!'],
                        'form' => [
                            'name' => 'Full Name',
                            'email' => 'Email Address',
                            'message' => 'Your Message',
                            'submit' => 'Send Me Message',
                            'success' => 'Message sent! I will get back to you soon.',
                        ],
                    ],
                ],
            ],
        ];

        if (Page::query()->exists()) {
            return;
        }

        foreach ($pages as $key => $attributes) {
            Page::create(['key' => $key, ...$attributes]);
        }
    }

    private function seedServices(): void
    {
        $services = [
            [
                'title' => ['id' => 'Pembuatan Website', 'en' => 'Web Development'],
                'icon' => 'ri-global-line',
            ],
            [
                'title' => ['id' => 'Pembuatan Aplikasi Mobile', 'en' => 'Mobile App Development'],
                'icon' => 'ri-smartphone-line',
            ],
            [
                'title' => ['id' => 'Pembuatan Aplikasi Custom', 'en' => 'Custom Application Development'],
                'excerpt' => [
                    'id' => 'Wujudkan ide Anda menjadi aplikasi web, mobile, dan desktop yang andal. Mulai sekarang dan bawa bisnis Anda ke level berikutnya!',
                    'en' => 'Transform your ideas into powerful web, mobile, and desktop apps. Get started now and take your business to the next level!',
                ],
                'icon' => 'ri-code-s-slash-line',
                'is_featured' => true,
            ],
            [
                'title' => ['id' => 'Software ERP', 'en' => 'ERP Software'],
                'excerpt' => [
                    'id' => 'Perkuat bisnis Anda dengan sistem ERP yang cerdas dan sesuai kebutuhan. Rapikan operasional, tingkatkan efisiensi—mulai perjalanan ERP Anda hari ini!',
                    'en' => 'Empower your business with a smart, tailored ERP system. Streamline operations, boost efficiency—start your ERP journey today!',
                ],
                'icon' => 'ri-stack-line',
                'is_featured' => true,
            ],
            [
                'title' => ['id' => 'Pembuatan Website WordPress', 'en' => 'WordPress Development'],
                'icon' => 'ri-wordpress-line',
            ],
            [
                'title' => ['id' => 'Desain UI/UX', 'en' => 'UI/UX Design'],
                'icon' => 'ri-pen-nib-line',
            ],
            [
                'title' => ['id' => 'Konsultan IT', 'en' => 'IT Consultant'],
                'excerpt' => [
                    'id' => 'Jadikan teknologi sebagai keunggulan kompetitif Anda. Saya siap mendampingi—mari bangun kesuksesan bersama!',
                    'en' => "Turn technology into your competitive advantage. I'm ready to guide you—let's build your success together!",
                ],
                'icon' => 'ri-lightbulb-line',
                'is_featured' => true,
            ],
        ];

        $this->createWhenEmpty(Service::class, array_map(fn (array $service): array => [
            'slug' => array_map(fn (string $title): string => Str::slug($title), $service['title']),
            ...$service,
        ], $services));
    }

    private function seedPricingPlans(): void
    {
        $sharedCta = ['id' => 'Pesan Sekarang', 'en' => 'Order Now'];

        $this->createWhenEmpty(PricingPlan::class, [
            [
                'name' => ['id' => 'Basic', 'en' => 'Basic'],
                'tagline' => ['id' => 'Paket Starter', 'en' => 'Starter Package'],
                'description' => ['id' => 'Untuk pelajar atau freelancer', 'en' => 'For students or freelancers'],
                'price' => 50,
                'currency' => 'USD',
                'features' => [
                    'id' => ['Aplikasi custom sederhana', 'Konsultasi 3 jam', 'Dukungan dasar', 'Modul ERP', 'Upgrade berkelanjutan'],
                    'en' => ['Simple Custom App', '3 Hours Consultation', 'Basic Support', 'ERP Module', 'Continuous Upgrades'],
                ],
                'cta_label' => $sharedCta,
            ],
            [
                'name' => ['id' => 'Growth', 'en' => 'Growth'],
                'tagline' => ['id' => 'Paket Bisnis', 'en' => 'Business Package'],
                'description' => ['id' => 'Cocok untuk UMKM', 'en' => 'Suitable for SMEs'],
                'price' => 300,
                'currency' => 'USD',
                'features' => [
                    'id' => ['Aplikasi custom menengah', 'Konsultasi 10 jam', 'Dukungan prioritas', '4 modul ERP', 'Upgrade berkelanjutan'],
                    'en' => ['Medium Custom App', '10 Hours Consultation', 'Priority Support', '4 ERP Modules', 'Continuous Upgrades'],
                ],
                'cta_label' => $sharedCta,
                'is_highlighted' => true,
            ],
            [
                'name' => ['id' => 'Ultimate', 'en' => 'Ultimate'],
                'tagline' => ['id' => 'Paket Enterprise', 'en' => 'Enterprise Package'],
                'description' => ['id' => 'Untuk perusahaan dan korporasi', 'en' => 'For enterprises or corporations'],
                'price' => 2500,
                'currency' => 'USD',
                'features' => [
                    'id' => ['Aplikasi custom tingkat lanjut', 'Konsultasi tanpa batas', 'Dukungan 24/7', 'Software ERP lengkap', 'Upgrade berkelanjutan'],
                    'en' => ['Advanced Custom App', 'Unlimited Consultation', '24/7 Support', 'Full ERP Software', 'Continuous Upgrades'],
                ],
                'cta_label' => $sharedCta,
            ],
        ]);
    }

    private function seedResumeEntries(): void
    {
        $this->createWhenEmpty(ResumeEntry::class, [
            [
                'type' => ResumeEntryType::Work,
                'title' => ['id' => 'Full Stack Developer', 'en' => 'Full Stack Developer'],
                'organization' => 'PT Metafora Indonesia Teknologi',
                'started_on' => '2023-01-01',
                'ended_on' => '2025-01-01',
            ],
            [
                'type' => ResumeEntryType::Work,
                'title' => ['id' => 'IT dan Programmer Officer', 'en' => 'IT and Programmer Officer'],
                'organization' => 'PT Astra Daihatsu Motor',
                'started_on' => '2020-01-01',
                'ended_on' => '2022-01-01',
            ],
            [
                'type' => ResumeEntryType::Education,
                'title' => ['id' => 'Teknologi Informasi', 'en' => 'Information Technology'],
                'organization' => 'Universitas Proklamasi 45',
                'started_on' => '2023-01-01',
                'ended_on' => null,
            ],
            [
                'type' => ResumeEntryType::Education,
                'title' => ['id' => 'Rekayasa Perangkat Lunak', 'en' => 'Software Engineering'],
                'organization' => 'SMKN 1 Slawi',
                'started_on' => '2017-01-01',
                'ended_on' => '2020-01-01',
            ],
            [
                'type' => ResumeEntryType::Internship,
                'title' => ['id' => 'IT dan Web Programmer', 'en' => 'IT and Web Programmer'],
                'organization' => 'CV Media Pratama Solusinet',
                'started_on' => '2019-06-01',
                'ended_on' => '2019-08-01',
                'date_precision' => 'month',
            ],
            [
                'type' => ResumeEntryType::Internship,
                'title' => ['id' => 'Web Programmer', 'en' => 'Web Programmer'],
                'organization' => 'Diskominfo Kabupaten Tegal',
                'started_on' => '2019-02-01',
                'ended_on' => '2019-04-01',
                'date_precision' => 'month',
            ],
            [
                'type' => ResumeEntryType::Achievement,
                'title' => ['id' => 'Juara 1 Quality Control Circle', 'en' => '1st Champion Quality Control Circle'],
                'organization' => 'ADM Convention QCCSS #36 Paint Division',
                'started_on' => '2022-02-01',
                'date_precision' => 'month',
            ],
            [
                'type' => ResumeEntryType::Achievement,
                'title' => ['id' => 'Juara 1 Suggestion System', 'en' => '1st Champion Suggestion System'],
                'organization' => 'ADM Convention QCCSS #36 Paint Division',
                'started_on' => '2022-01-01',
                'date_precision' => 'month',
            ],
        ]);
    }

    private function seedSkills(): void
    {
        $skills = [
            'PHP' => 95,
            'JavaScript' => 80,
            'Laravel' => 80,
            'CodeIgniter' => 95,
            'MySQL' => 95,
            'PostgreSQL' => 80,
            'HTML' => 99,
            'CSS' => 95,
        ];

        $this->createWhenEmpty(Skill::class, array_map(
            fn (string $name, int $proficiency): array => [
                'name' => $name,
                'proficiency' => $proficiency,
                'icon' => $this->importAsset('images/skills/'.strtolower($name).'.png', 'skills'),
            ],
            array_keys($skills),
            $skills,
        ));
    }

    private function seedClients(): void
    {
        $this->createWhenEmpty(Client::class, [
            ['name' => 'PT Astra Daihatsu Motor', 'logo' => $this->importAsset('images/client-logos/daihatsu.png', 'clients')],
            ['name' => 'PT Metafora Indonesia Teknologi', 'logo' => $this->importAsset('images/client-logos/idmetafora.png', 'clients')],
            ['name' => 'CV Media Pratama Solusinet', 'logo' => $this->importAsset('images/client-logos/mps.png', 'clients')],
            ['name' => 'Diskominfo Kabupaten Tegal', 'logo' => $this->importAsset('images/client-logos/diskominfo.png', 'clients')],
            ['name' => 'Kinz', 'logo' => $this->importAsset('images/client-logos/kinz.png', 'clients')],
        ]);
    }

    /**
     * Create the given rows, numbering their sort order, unless the
     * table already has content.
     *
     * @param  class-string<Model>  $model
     * @param  list<array<string, mixed>>  $rows
     */
    private function createWhenEmpty(string $model, array $rows): void
    {
        if ($model::query()->exists()) {
            return;
        }

        foreach ($rows as $index => $row) {
            $model::create(['sort_order' => $index + 1, ...$row]);
        }
    }
}
