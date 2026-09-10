<?php

namespace Database\Seeders;

use App\Models\SiteSection;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('cms') as $key => $definition) {
            SiteSection::firstOrCreate(['key' => $key], ['content' => $definition['defaults']]);
        }
    }
}
