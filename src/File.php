<?php

declare(strict_types = 1);

namespace Liberty\FileSystem;

use Liberty\FileSystem\Dir;
use Liberty\FileSystem\FileInfo;
use Liberty\FileSystem\FileSystemInterface;

/**
 * Класс File
 * @version 0.0.1
 * @package Liberty\FileSystem
 * @generated Зорин Алексей, please DO NOT EDIT!
 * @author Зорин Алексей <zorinalexey59292@gmail.com>
 * @copyright 2022 разработчик Зорин Алексей Евгеньевич.
 */
final class File implements FileSystemInterface
{

    use FileSystemTrait;

    /**
     * Содержание файла
     * @var mixed
     */
    public $content = null;

    /**
     * Проверка существования файла
     * @return bool Вернет true если файл существует, в противном случае false
     */
    public function has(): bool
    {
        if (is_file($this->path)) {
            return true;
        }
        return false;
    }

    /**
     * Создать файл
     * @return  FileInfo|false Объект FileInfo в случае успеха, в противном случае false
     */
    public function create(): FileInfo|false
    {
        $dir = Dir::set(dirname($this->path));
        $dir->recursive = true;
        $dir->permissions = $this->permissions;
        if ( ! $this->has() AND $dir->create()) {
            file_put_contents($this->path, $this->content, LOCK_EX);
            $this->chmod();
            if ($this->has()) {
                return FileInfo::instance($this->path);
            }
        }
        return false;
    }

    /**
     * Перезаписать файл
     * @return FileInfo|false
     */
    public function rewrite(): FileInfo|false
    {
        $dir = Dir::set(dirname($this->path));
        $dir->recursive = true;
        $dir->permissions = $this->permissions;
        if ($this->has() AND $dir->create() AND $this->delete()) {
            return $this->create();
        }
        return false;
    }

    /**
     * Дописать данные в файл
     * @return FileInfo|false
     */
    public function append(): FileInfo|false
    {
        $dir = Dir::set(dirname($this->path));
        $dir->recursive = true;
        $dir->permissions = $this->permissions;
        if ($dir->create()) {
            file_put_contents($this->path, $this->content, LOCK_EX | FILE_APPEND);
            $this->chmod();
            if ($this->has()) {
                return FileInfo::instance($this->path);
            }
        }
        return false;
    }

    /**
     * Удалить файл
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function delete(): bool
    {
        if ($this->has()) {
            if (unlink($this->path)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Скопировать файл
     * @param string $path Путь к целевому файлу. Если $path является URL,
     * то операция копирования может завершиться ошибкой, если обёртка URL
     * не поддерживает перезаписывание существующих файлов.
     * @param int $this->permissions Новые права на файл
     * @return FileInfo|bool Вернет объект FileInfo в случае успеха, в противном случае false
     */
    public function copy(string $path): FileInfo|bool
    {
        $newFile = self::set($path);
        $newFile->permissions = $this->permissions;
        $newFile->content = $this->info()->content;
        $create = $newFile->create();
        if ($create) {
            return FileInfo::instance($path);
        }
        return false;
    }

    /**
     * Переименвать файл
     * @param string $newName Новое имя
     * @param int $this->permissions Новые права на файл
     * @return FileInfo|false Вернет объект FileInfo в случае успеха, в противном случае false
     */
    public function rename(string $newName): FileInfo|false
    {
        if ($this->copy($newName, $this->permissions) AND $this->delete()) {
            return true;
        }
        return false;
    }

}
