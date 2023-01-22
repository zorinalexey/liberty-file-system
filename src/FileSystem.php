<?php

namespace Liberty\FileSystem;

use Directory;

/**
 *
 */
abstract class FileSystem
{

    /**
     * Робота с файлом
     * @param string $path
     * @return File
     */
    public function file(string $path): File
    {
        return File::set($path);
    }

    /**
     * Работа с каталогом
     * @param string $path
     * @return Directory
     */
    public function dir(string $path): Dir
    {
        return Dir::set($path);
    }

    /**
     * Работа с сылкой
     * @param string $path
     * @return Link
     */
    public function link(string $path): Link
    {
        return Link::set($path);
    }

    /**
     * Получить информацию о файле
     * @param string $path
     * @return FileInfo
     */
    public function fileInfo(string $path): FileInfo
    {
        return FileInfo::instance($path);
    }

}