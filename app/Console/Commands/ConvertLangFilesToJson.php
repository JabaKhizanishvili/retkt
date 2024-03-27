<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertLangFilesToJson extends Command
{
    protected $signature = 'lang:to-json';

    protected $description = 'Convert PHP language files to JSON';

    public function handle()
    {
        $langPath = base_path('/lang');

        if (!File::exists($langPath)) {

        }

        // Iterate through language directories
        foreach (File::directories($langPath) as $langDirectory) {
            // Iterate through PHP language files
            foreach (File::files($langDirectory) as $phpFile) {
                $langArray = require $phpFile;
                $jsonFile = str_replace('.php', '.json', $phpFile);
                File::put($jsonFile, json_encode($langArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }

        $this->info('Conversion completed successfully.');
    }
}