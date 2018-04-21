<?php
declare(strict_types=1);

namespace Miklcct\ThinPhpApp\Http;

class NativeSessionBackend implements SessionBackend {
    public function open() {
        if (!session_start()) {
            throw new SessionException('Cannot start session', SessionException::OPEN_FAILED);
        }
    }

    public function close() {
        session_write_close();
    }

    public function abort() {
        if (!session_abort()) {
            throw new SessionException('Cannot abort session', SessionException::ABORT_FAILED);
        }
    }

    public function destroy() {
        if (!session_destroy()) {
            throw new SessionException('Cannot destroy session', SessionException::DESTROY_FAILED);
        }
    }

    public function migrate(bool $delete_old_session = FALSE) {
        if (!session_regenerate_id($delete_old_session)) {
            throw new SessionException('Cannot migrate session', SessionException::MIGRATE_FAILED);
        }
    }

    public function isActive() : bool {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function getId() : string {
        return session_id();
    }

    public function setId(string $id) {
        session_id($id);
    }

    public function getName() : string {
        return session_name();
    }

    public function setName(string $name) {
        session_name($name);
    }

    public function getData() : array {
        return $_SESSION;
    }

    public function setData(array $session) {
        $_SESSION = $session;
    }
}