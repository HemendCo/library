<?php

namespace Hemend\Library\Laravel\Traits;

use Hemend\Library as Libs;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait Media
{
    public function upload(UploadedFile|null $file, string $path, string $disk_name = 'public') : array|null
    {
        if($file instanceof UploadedFile && $file->isValid()) {
            $file_ext = strtolower($file->getClientOriginalExtension());
            $file_title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $ext = $file_ext ? '.' . $file_ext : '';

            $fp = Libs\Files::generateFilenameAndpath(Storage::disk($disk_name)->path($path));
            Storage::disk($disk_name)->put($path . $fp->path . $ext, File::get($file));

            $file_name = $fp->name . $ext;
            $file_path = str_replace('\\', '/', $fp->path) . $ext;

            $file_mime = $file->getMimeType();

            return [
                'file_name' => $file_name,
                'file_title' => $file_title,
                'file_ext' => $file_ext,
                'file_mime' => $file_mime,
                'file_path' => $file_path,
                'file_size' => $file->getSize()
            ];
        }

        return null;
    }
}
