<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

class Session {
    public function __construct(SessionBackend $backend) {
        $this->backend = $backend;
    }

    public function open() : void {
        $this->backend->open();
        $this->data = $this->backend->getData();
    }

    public function close() : void {
        $this->backend->setData($this->data);
        $this->backend->close();
        $this->data = NULL;
    }

    public function abort() : void {
        $this->backend->abort();
        $this->data = NULL;
    }

    public function destroy() : void {
        $this->backend->destroy();
        $this->data = NULL;
    }

    public function migrate(bool $delete_old_session = FALSE) : void {
        $this->backend->migrate($delete_old_session);
    }

    public function isActive() : bool {
        return $this->backend->isActive();
    }

    public function getId() : string {
        return $this->backend->getId();
    }

    public function setId(string $id) : void {
        $this->backend->setId($id);
    }

    public function getName() : string {
        return $this->backend->getName();
    }

    public function setName(string $name) : void {
        $this->backend->setName($name);
    }

    public function has($key) : bool {
        return array_key_exists($key, $this->data);
    }

    public function get($key) {
        return $this->data[$key] ?? NULL;
    }

    public function set($key, $value) : void {
        $this->data[$key] = $value;
    }

    public function getData() : array {
        return $this->data;
    }

    public function setData(array $data) : void {
        $this->data = $data;
    }

    public function addData(array $data) : void {
        $this->data = $data + $this->data;
    }

    /** @var SessionBackend */
    private $backend;

    /** @var array */
    private $data;
}