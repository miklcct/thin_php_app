<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

use RuntimeException;
use Throwable;

class UploadException extends RuntimeException {
    const MESSAGES = [
        UPLOAD_ERR_OK => 'The file is successfully uploaded.',
        UPLOAD_ERR_INI_SIZE => 'The file size exceeded upload_max_filesize in PHP configuration',
        UPLOAD_ERR_FORM_SIZE => 'The file size exceeded MAX_FILE_SIZE in the form.',
        UPLOAD_ERR_PARTIAL => 'The file is only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file is uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'The temporary folder is missing.',
        UPLOAD_ERR_CANT_WRITE => 'The uploaded file cannot be written.',
        UPLOAD_ERR_EXTENSION => 'An extension has stopped the file upload.',
    ];

    public function __construct(string $key, int $code = 0, Throwable $previous = NULL) {
        parent::__construct("Failed uploading $key: " . self::MESSAGES[$code], $code, $previous);
        $this->key = $key;
    }

    public function getKey() : string {
        return $this->key;
    }

    /** @var string */
    private $key;
}