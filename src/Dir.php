<?php

declare(strict_types = 1);

namespace Liberty\FileSystem;

use Liberty\FileSystem\FileSystemTrait;
use Liberty\FileSystem\FileSystemInterface;

/**
 * Класс Dir
 * @version 0.0.1
 * @package Liberty\FileSystem
 * @generated Зорин Алексей, please DO NOT EDIT!
 * @author Зорин Алексей <zorinalexey59292@gmail.com>
 * @copyright 2022 разработчик Зорин Алексей Евгеньевич.
 */
final class Dir implements FileSystemInterface
{

    use FileSystemTrait;

    /**
     * Рекурсивная работа с дирректорией
     * @var bool
     */
    public bool $recursive = false;

    /**
     * Создать дирректорию
     * @return  FileInfo|false Объект FileInfo в случае успеха, в противном случае false
     */
    public function create(): FileInfo|false
    {
        if ($this->has()) {
            return FileInfo::instance($this->path);
        }
        if ( ! $this->has() && mkdir($this->path, $this->permissions, $this->recursive)) {
            return FileInfo::instance($this->path);
        }
        return false;
    }

    /**
     * Удалить дирректорию
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->recursive) {
            system("rm -r '" . $this->path . "'");
        } else {
            rmdir($this->path);
        }
        return ! $this->has();
    }

    /**
     * Проверка существования дирректории
     * @return bool Вернет true если файл существует, в противном случае false
     */
    public function has(): bool
    {
        if (is_dir($this->path)) {
            return true;
        }
        return false;
    }

    /**
     * Переименовать дирректорию
     * @param string $newName Новое имя
     * @return FileInfo|false
     */
    public function rename(string $newName): FileInfo|false
    {
        if (rename($this->path, $newName)) {
            return FileInfo::instance($newName);
        }
        return false;
    }

}
