<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index(Request $request, $key = null)
    {
        $level = 1;
        $menus = $this->scanDirectory(resource_path('docs'), $level);

        if (empty($key)) {
            return Inertia::render('Docs', [
                'menus' => $menus
            ]);
        }

        $path = resource_path('docs/' . str_replace('_', '/', $key));

        if (!File::exists($path)) {
            return Inertia::render('Docs', [
                'menus' => $menus
            ]);
        }

        $jsonString = File::get($path);

        $data = json_decode($jsonString, true);
        $data['url'] = env('APP_URL');

        return Inertia::render('Docs', [
            'menus' => $menus,
            'data' => $data
        ]);
    }

    private function scanDirectory($dir, $level = 1)
    {
        $files = [];
        $scan = scandir($dir);
        foreach ($scan as $file) {
            if ($file === '.' || $file === '..') continue;
            $filepath = $dir . '/' . $file;
            if (is_dir($filepath)) {
                $files[] = [
                    'name' => $file,
                    'path' => Str::substr(str_replace('/', '_', str_replace(resource_path('docs'), '', $filepath)), 1),
                    'uuid' => Str::uuid(),
                    'type' => 'Dir',
                    'level' => $level,
                    'child' => $this->scanDirectory($filepath, $level + 1),
                ];
            } else {
                $files[] = [
                    'name' => pathinfo($file, PATHINFO_FILENAME),
                    'path' => Str::substr(str_replace('/', '_', str_replace(resource_path('docs'), '', $filepath)), 1),
                    'uuid' => Str::uuid(),
                    'type' => 'File',
                    'level' => $level,
                    'child' => [],
                ];
            }
        }

        return $files;
    }
}
