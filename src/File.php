<?php

declare(strict_types=1);

namespace Liberty\FileSystem;

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
    public mixed $content = null;

    /**
     * Перезаписать файл
     * @return FileInfo|false
     */
    public function rewrite(): FileInfo|false
    {
        $dir = Dir::set(dirname($this->path));
        $dir->recursive = true;
        $dir->permissions = $this->permissions;
        if ($this->has() && $this->delete()) {
            return $this->create();
        }
        return false;
    }

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
     * Удалить файл
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function delete(): bool
    {
        return ($this->has() && unlink($this->path));
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
        if (!$this->has() && $dir->create()) {
            file_put_contents($this->path, $this->content, LOCK_EX);
            $this->chmod();
            if ($this->has()) {
                return FileInfo::instance($this->path);
            }
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
     * Переименовать файл
     * @param string $newName Новое имя
     * @return FileInfo|false Вернет объект FileInfo в случае успеха, в противном случае false
     * @noinspection NotOptimalIfConditionsInspection
     */
    public function rename(string $newName): FileInfo|false
    {
        if ($newFile = $this->copy($newName) and $this->delete()) {
            return $newFile;
        }
        return false;
    }

    /**
     * Скопировать файл
     * @param string $path Путь к целевому файлу. Если $path является URL,
     * то операция копирования может завершиться ошибкой, если обёртка URL
     * не поддерживает перезаписывание существующих файлов.
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

}
