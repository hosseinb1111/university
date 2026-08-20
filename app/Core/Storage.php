<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Storage
{
    /**
     * Get the configured upload directory.
     */
    public static function uploadDirectory(): string
    {
        $directory = trim(
            (string) config(
                'app.uploads.directory',
                'storage/uploads'
            )
        );

        if ($directory === '') {
            throw new RuntimeException(
                'Upload directory is not configured.'
            );
        }

        /*
         * Relative paths are resolved from the project root.
         *
         * Project structure:
         *
         * project/
         * ├── app/
         * ├── config/
         * ├── public/
         * └── storage/
         */
        if (
            !self::isAbsolutePath(
                $directory
            )
        ) {
            $directory =
                dirname(
                    __DIR__,
                    2
                )
                . DIRECTORY_SEPARATOR
                . $directory;
        }

        return rtrim(
            $directory,
            '/\\'
        );
    }

    /**
     * Ensure the upload directory exists.
     */
    public static function ensureUploadDirectory(): string
    {
        $directory =
            self::uploadDirectory();

        if (
            is_dir(
                $directory
            )
        ) {
            return $directory;
        }

        if (
            !mkdir(
                $directory,
                0755,
                true
            )
            && !is_dir(
                $directory
            )
        ) {
            throw new RuntimeException(
                'Unable to create upload directory.'
            );
        }

        /*
         * Best-effort permission.
         */
        @chmod(
            $directory,
            0755
        );

        return $directory;
    }

    /**
     * Store an uploaded file.
     *
     * @param array<string, mixed> $file
     * @param array<int, string> $allowedMimeTypes
     *
     * @return array{
     *     file_name: string,
     *     original_name: string,
     *     file_path: string,
     *     mime_type: string,
     *     file_size: int,
     *     width: int|null,
     *     height: int|null
     * }
     */
    public static function storeUploadedFile(
        array $file,
        array $allowedMimeTypes
    ): array {
        self::validateUploadArray(
            $file
        );

        $error =
            (int) (
                $file['error']
                ?? UPLOAD_ERR_NO_FILE
            );

        if (
            $error !== UPLOAD_ERR_OK
        ) {
            throw new RuntimeException(
                self::uploadErrorMessage(
                    $error
                )
            );
        }

        $temporaryPath =
            $file['tmp_name']
            ?? null;

        $originalName =
            $file['name']
            ?? null;

        if (
            !is_string(
                $temporaryPath
            )
            || $temporaryPath === ''
            || !is_uploaded_file(
                $temporaryPath
            )
        ) {
            throw new RuntimeException(
                'Uploaded file is not valid.'
            );
        }

        if (
            !is_string(
                $originalName
            )
            || trim(
                $originalName
            ) === ''
        ) {
            throw new RuntimeException(
                'Uploaded file has no valid name.'
            );
        }

        $fileSize =
            filesize(
                $temporaryPath
            );

        if (
            $fileSize === false
        ) {
            throw new RuntimeException(
                'Unable to determine uploaded file size.'
            );
        }

        $maxSize =
            (int) config(
                'app.uploads.max_file_size',
                10 * 1024 * 1024
            );

        if (
            $maxSize > 0
            && $fileSize > $maxSize
        ) {
            throw new RuntimeException(
                'Uploaded file is too large.'
            );
        }

        if (
            $allowedMimeTypes === []
        ) {
            throw new RuntimeException(
                'No upload MIME types are configured.'
            );
        }

        $mimeType =
            self::detectMimeType(
                $temporaryPath
            );

        $allowedMimeTypes =
            array_values(
                array_filter(
                    array_map(
                        static function (
                            mixed $value
                        ): ?string {
                            if (
                                !is_string(
                                    $value
                                )
                            ) {
                                return null;
                            }

                            $value =
                                strtolower(
                                    trim(
                                        $value
                                    )
                                );

                            return $value === ''
                                ? null
                                : $value;
                        },
                        $allowedMimeTypes
                    )
                )
            );

        if (
            !in_array(
                strtolower(
                    $mimeType
                ),
                $allowedMimeTypes,
                true
            )
        ) {
            throw new RuntimeException(
                'این نوع فایل مجاز نیست.'
            );
        }

        $extension =
            self::extensionForMime(
                $mimeType
            );

        if (
            $extension === null
        ) {
            throw new RuntimeException(
                'Unable to determine a safe file extension.'
            );
        }

        $directory =
            self::ensureUploadDirectory();

        $fileName =
            self::randomFileName(
                $extension
            );

        $targetPath =
            $directory
            . DIRECTORY_SEPARATOR
            . $fileName;

        if (
            !move_uploaded_file(
                $temporaryPath,
                $targetPath
            )
        ) {
            throw new RuntimeException(
                'Unable to save uploaded file.'
            );
        }

        @chmod(
            $targetPath,
            0644
        );

        $storedSize =
            filesize(
                $targetPath
            );

        if (
            $storedSize === false
        ) {
            /*
             * Best effort cleanup.
             */
            @unlink(
                $targetPath
            );

            throw new RuntimeException(
                'Unable to determine stored file size.'
            );
        }

        [
            $width,
            $height,
        ] = self::imageDimensions(
            $targetPath,
            $mimeType
        );

        return [
            'file_name' =>
                $fileName,

            'original_name' =>
                self::sanitizeOriginalName(
                    $originalName
                ),

            'file_path' =>
                $fileName,

            'mime_type' =>
                $mimeType,

            'file_size' =>
                (int) $storedSize,

            'width' =>
                $width,

            'height' =>
                $height,
        ];
    }

    /**
     * Delete a stored file safely.
     */
    public static function delete(
        string $relativePath
    ): bool {
        $relativePath =
            self::normalizeRelativePath(
                $relativePath
            );

        if (
            $relativePath === ''
        ) {
            return false;
        }

        $baseDirectory =
            realpath(
                self::ensureUploadDirectory()
            );

        if (
            $baseDirectory === false
        ) {
            return false;
        }

        $fullPath =
            $baseDirectory
            . DIRECTORY_SEPARATOR
            . str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                $relativePath
            );

        $realPath =
            realpath(
                $fullPath
            );

        if (
            $realPath === false
            || !is_file(
                $realPath
            )
        ) {
            return false;
        }

        if (
            !self::isPathInside(
                $baseDirectory,
                $realPath
            )
        ) {
            return false;
        }

        return @unlink(
            $realPath
        );
    }

    /**
     * Build a public media URL.
     */
    public static function publicUrl(
        string $relativePath
    ): string {
        $relativePath =
            self::normalizeRelativePath(
                $relativePath
            );

        if (
            $relativePath === ''
        ) {
            return View::url(
                '/'
            );
        }

        return View::url(
            '/media/'
            . rawurlencode(
                base64_encode(
                    $relativePath
                )
            )
        );
    }

    /**
     * Detect MIME type from the file contents.
     */
    private static function detectMimeType(
        string $path
    ): string {
        if (
            !class_exists(
                \finfo::class
            )
        ) {
            throw new RuntimeException(
                'PHP Fileinfo extension is required.'
            );
        }

        $finfo =
            new \finfo(
                FILEINFO_MIME_TYPE
            );

        $mime =
            $finfo->file(
                $path
            );

        if (
            !is_string(
                $mime
            )
            || trim(
                $mime
            ) === ''
        ) {
            throw new RuntimeException(
                'Unable to determine file MIME type.'
            );
        }

        return strtolower(
            trim(
                $mime
            )
        );
    }

    /**
     * Map MIME types to controlled extensions.
     */
    private static function extensionForMime(
        string $mime
    ): ?string {
        return match (
            strtolower(
                $mime
            )
        ) {
            'image/jpeg' =>
                'jpg',

            'image/png' =>
                'png',

            'image/webp' =>
                'webp',

            'application/pdf' =>
                'pdf',

            'application/msword' =>
                'doc',

            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' =>
                'docx',

            'application/vnd.ms-excel' =>
                'xls',

            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' =>
                'xlsx',

            'application/vnd.ms-powerpoint' =>
                'ppt',

            'application/vnd.openxmlformats-officedocument.presentationml.presentation' =>
                'pptx',

            default =>
                null,
        };
    }

    /**
     * Generate a cryptographically random filename.
     */
    private static function randomFileName(
        string $extension
    ): string {
        return bin2hex(
            random_bytes(
                24
            )
        )
        . '.'
        . $extension;
    }

    /**
     * Sanitize original filename for display/storage metadata.
     */
    private static function sanitizeOriginalName(
        string $name
    ): string {
        $name =
            basename(
                str_replace(
                    '\\',
                    '/',
                    $name
                )
            );

        $name =
            preg_replace(
                '/[^\p{L}\p{N}\.\-\_\(\)\[\] ]+/u',
                '-',
                $name
            )
            ?? '';

        $name =
            preg_replace(
                '/-+/u',
                '-',
                $name
            )
            ?? '';

        $name =
            trim(
                $name
            );

        return $name !== ''
            ? $name
            : 'file';
    }

    /**
     * Get image dimensions.
     *
     * @return array{0:int|null,1:int|null}
     */
    private static function imageDimensions(
        string $path,
        string $mime
    ): array {
        if (
            !str_starts_with(
                strtolower($mime),
                'image/'
            )
        ) {
            return [
                null,
                null,
            ];
        }

        $dimensions =
            @getimagesize(
                $path
            );

        if (
            !is_array(
                $dimensions
            )
            || !isset(
                $dimensions[0],
                $dimensions[1]
            )
        ) {
            return [
                null,
                null,
            ];
        }

        return [
            (int) $dimensions[0],
            (int) $dimensions[1],
        ];
    }

    /**
     * Validate PHP upload structure.
     *
     * @param array<string, mixed> $file
     */
    private static function validateUploadArray(
        array $file
    ): void {
        foreach (
            [
                'name',
                'type',
                'tmp_name',
                'error',
                'size',
            ]
            as $key
        ) {
            if (
                !array_key_exists(
                    $key,
                    $file
                )
            ) {
                throw new RuntimeException(
                    'Invalid upload data.'
                );
            }
        }

        if (
            is_array(
                $file['name']
            )
            || is_array(
                $file['tmp_name']
            )
        ) {
            throw new RuntimeException(
                'Multiple-file uploads are not supported here.'
            );
        }
    }

    /**
     * Convert PHP upload errors to readable messages.
     */
    private static function uploadErrorMessage(
        int $error
    ): string {
        return match ($error) {
            UPLOAD_ERR_INI_SIZE,
            UPLOAD_ERR_FORM_SIZE =>
                'فایل از اندازه مجاز بزرگ‌تر است.',

            UPLOAD_ERR_PARTIAL =>
                'آپلود فایل کامل نشده است.',

            UPLOAD_ERR_NO_FILE =>
                'فایلی انتخاب نشده است.',

            UPLOAD_ERR_NO_TMP_DIR =>
                'پوشه موقت آپلود وجود ندارد.',

            UPLOAD_ERR_CANT_WRITE =>
                'فایل روی سرور ذخیره نشد.',

            UPLOAD_ERR_EXTENSION =>
                'آپلود فایل توسط یک افزونه PHP متوقف شد.',

            default =>
                'خطای ناشناخته در آپلود فایل رخ داد.',
        };
    }

    /**
     * Normalize a relative path.
     */
    private static function normalizeRelativePath(
        string $path
    ): string {
        $path =
            str_replace(
                '\\',
                '/',
                trim(
                    $path
                )
            );

        $parts =
            explode(
                '/',
                $path
            );

        $safeParts = [];

        foreach (
            $parts
            as $part
        ) {
            if (
                $part === ''
                || $part === '.'
                || $part === '..'
            ) {
                continue;
            }

            $safeParts[] =
                $part;
        }

        return implode(
            '/',
            $safeParts
        );
    }

    /**
     * Determine whether a path is absolute.
     */
    private static function isAbsolutePath(
        string $path
    ): bool {
        if (
            str_starts_with(
                $path,
                '/'
            )
        ) {
            return true;
        }

        return preg_match(
            '/^[A-Za-z]:[\\\\\/]/',
            $path
        ) === 1;
    }

    /**
     * Make sure child path stays inside parent path.
     */
    private static function isPathInside(
        string $parent,
        string $child
    ): bool {
        $parent =
            rtrim(
                $parent,
                DIRECTORY_SEPARATOR
            )
            . DIRECTORY_SEPARATOR;

        $child =
            rtrim(
                $child,
                DIRECTORY_SEPARATOR
            )
            . DIRECTORY_SEPARATOR;

        return str_starts_with(
            $child,
            $parent
        );
    }
}