<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

interface SessionBackend {
    public function open();
    public function close();
    public function abort();
    public function destroy();
    public function migrate(bool $delete_old_session = FALSE);
    public function isActive() : bool;
    public function getId() : string;
    public function setId(string $id);
    public function getName() : string;
    public function setName(string $name);
    public function getData() : array;
    public function setData(array $data);
}