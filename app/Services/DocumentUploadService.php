<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentUploadService
{
    public function store(UploadedFile $file, int $dealId): array
    {
        $originalName = $file->getClientOriginalName();
        $storedName = $this->buildStoredName($originalName);
        $folder = "documents/{$dealId}";

        $path = $file->storeAs($folder, $storedName, 'public');

        return [
            'file_name' => $originalName,
            'file_path' => $path,
        ];
    }

    public function replace(UploadedFile $file, int $dealId, ?string $existingPath = null): array
    {
        if ($existingPath && Storage::disk('public')->exists($existingPath)) {
            Storage::disk('public')->delete($existingPath);
        }

        return $this->store($file, $dealId);
    }

    protected function buildStoredName(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $name = pathinfo($originalName, PATHINFO_FILENAME);

        return sprintf('%s_%s.%s',
            substr(str_replace([' ', '/'], '_', $name), 0, 100),
            uniqid(),
            $extension
        );
    }
}
