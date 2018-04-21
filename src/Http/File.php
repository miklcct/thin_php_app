<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

class File {
    public function __construct(string $key, array $data) {
        if ($data['error']) {
            throw new UploadException($key, $data['error']);
        }
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->size = $data['size'];
        $this->tmpName = $data['tmp_name'];
    }

    /** @var string */
    private $name;
    /** @var string */
    private $type;
    /** @var int */
    private $size;
    /** @var string */
    private $tmpName;
}