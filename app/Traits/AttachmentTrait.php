<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait AttachmentTrait
{
    /**
     * Store an attachment with a unique filename.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     */

    public function storeAttachment($file, $folder, $disk = 'public')
    {
        $filename = now()->format('YmdHisv') . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $path = $file->store($folder, $filename);

        return $path;
    }

    /**
     * Delete an attachment.
     *
     * @param string $filename
     * @param string $folder
     * @return bool
     */
    public function deleteAttachment($filename, $folder)
    {
        $path = "{$folder}/{$filename}";

        if (Storage::exists($path)) {
            return Storage::delete($path);
        }

        return false;
    }
}