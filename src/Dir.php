<?php

declare(strict_types=1);

namespace Liberty\FileSystem;

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
     * Рекурсивная работа с директорией
     * @var bool
     */
    public bool $recursive = false;

    /**
     * Создать директорию
     * @return  FileInfo|false Объект FileInfo в случае успеха, в противном случае false
     */
    public function create(): FileInfo|false
    {
        if ($this->has() || mkdir($concurrentDirectory = $this->path, $this->permissions, $this->recursive) || is_dir($concurrentDirectory)) {
            return FileInfo::instance($this->path);
        }
        return false;
    }

    /**
     * Проверка существования директории
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
     * Удалить директорию
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->recursive) {
            system("rm -r '" . $this->path . "'");
        } else {
            rmdir($this->path);
        }
        return !$this->has();
    }

    /**
     * Переименовать директорию
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
