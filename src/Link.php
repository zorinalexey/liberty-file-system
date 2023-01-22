<?php

declare(strict_types=1);

namespace Liberty\FileSystem;

/**
 * Класс Link
 * @version 0.0.1
 * @package Liberty\FileSystem
 * @generated Зорин Алексей, please DO NOT EDIT!
 * @author Зорин Алексей <zorinalexey59292@gmail.com>
 * @copyright 2022 разработчик Зорин Алексей Евгеньевич.
 */
final class Link implements FileSystemInterface
{

    use FileSystemTrait;

    /**
     * Создать символическую ссылку - true, или жёсткую ссылку - false.
     * @var bool
     */
    public bool $symlink = true;

    /**
     * Цель ссылки.
     * @var string|null
     */
    public string|null $target = null;

    /**
     * Переименовать ссылку
     * @param string $newName Новое имя
     * @return FileInfo|false
     */
    public function rename(string $newName): FileInfo|false
    {
        $newLink = self::set($newName);
        $newLink->target = $this->info()->linkTarget;
        $create = $newLink->create();
        if ($create && $this->delete()) {
            return $create;
        }
        return false;
    }

    /**
     * Создать ссылку
     * @return  FileInfo|false Объект FileInfo в случае успеха, в противном случае false
     * @noinspection NotOptimalIfConditionsInspection
     */
    public function create(): FileInfo|false
    {
        $dir = Dir::set(dirname($this->path));
        $dir->recursive = true;
        $dir->permissions = $this->permissions;
        $target = File::set($this->target)->info();
        if (!$this->has() and $dir->create() and $target) {
            if ($this->symlink) {
                symlink($target->realPath, $this->path);
            } else {
                link($target->realPath, $this->path);
            }
        }
        if ($this->has()) {
            return $this->info();
        }
        return false;
    }

    /**
     * Проверка существования ссылки
     * @return bool Вернет true если файл существует, в противном случае false
     */
    public function has(): bool
    {
        if (is_link($this->path)) {
            return true;
        }
        return false;
    }

    /**
     * Удалить ссылку
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->has()) {
            return unlink($this->path);
        }
        return true;
    }

}
