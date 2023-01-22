<?php

declare(strict_types=1);

namespace Liberty\FileSystem;

use SplFileInfo;
use SplFileObject;

/**
 * Класс FileInfo
 * @version 0.0.1
 * @package Liberty\FileSystem
 * @generated Зорин Алексей, please DO NOT EDIT!
 * @author Зорин Алексей <zorinalexey59292@gmail.com>
 * @copyright 2022 разработчик Зорин Алексей Евгеньевич.
 */
final class FileInfo
{

    /**
     * Суффикс, который будет исключён из базового имени.
     * @var string|null
     */
    public static string|null $suffix = null;

    /**
     * Время последнего доступа к файлу в формате временной метки Unix
     * @var int
     */
    public int $aTime = 0;

    /**
     * Базовое имя файла, каталога или ссылки без информации о пути.
     * @var string|null
     */
    public string|null $baseName = null;

    /**
     * Время последнего изменения индексного дескриптора файла в формате временной метки Unix
     * @var int
     */
    public int $cTime = 0;

    /**
     * Расширение файла.
     * @var string|null
     */
    public string|null $extension = null;

    /**
     * Имя файла без информации о пути к нему.
     * @var string|null
     */
    public string|null $fileName = null;

    /**
     * Группа файла. Идентификатор группы возвращается в числовом формате.
     * @var int|false
     */
    public int|false $group = false;

    /**
     * Номер индексного дескриптора для объекта файловой системы.
     * @var int|false
     */
    public int|false $inode = false;

    /**
     * Целевой путь ссылки файловой системы в случае успешного выполнения или false
     * @var string|false
     */
    public string|false $linkTarget = false;

    /**
     * Время последнего изменения файла в формате временной метки Unix
     * @var int
     */
    public int $mTime = 0;

    /**
     * Идентификатор владельца файла в виде числа в случае успешного выполнения или false
     * @var int|false
     */
    public int|false $owner = false;

    /**
     * Путь к файлу, исключая имя файла и завершающий слеш.
     * @var string|null
     */
    public string|null $path = null;

    /**
     * Путь к файлу.
     * @var string|null
     */
    public string|null $pathName = null;

    /**
     * Список разрешений для файла в случае успешного выполнения или false
     * @var int|false
     */
    public int|false $permissionList = false;

    /**
     * Абсолютный путь к файлу
     * @var string|false
     */
    public string|false $realPath = false;

    /**
     * Размер файла в байтах.
     * @var int|false
     */
    public int|false $size = false;

    /**
     * Строка (string), представляющая тип элемента.
     * Возможны следующие значения: file, link, dir, block, fifo, char, socket или unknown.
     * @var string|false
     */
    public string|false $type = false;

    /**
     * True, если каталог или false, в противном случае.
     * @var bool
     */
    public bool $isDir = false;

    /**
     * True, если файл является исполняемым или false, в противном случае.
     * @var bool
     */
    public bool $isExecutable = false;

    /**
     * True, если файл существует и является обычным файлом (а не ссылкой), false в противном случае.
     * @var bool
     */
    public bool $isFile = false;

    /**
     * True, если файл является ссылкой или false, в противном случае.
     * @var bool
     */
    public bool $isLink = false;

    /**
     * True, если файл доступен для чтения или false, в противном случае.
     * @var bool
     */
    public bool $isReadable = false;

    /**
     * True, если файл доступен для записи или false, в противном случае.
     * @var bool
     */
    public bool $isWritable = false;

    /**
     * Контекст файла
     * @var mixed
     */
    public mixed $content = false;

    /**
     * Предоставление дополнительных методов для работы с файлом
     * @var SplFileObject|null
     */
    public SplFileObject|null $additionalFeatures = null;

    /**
     * Путь к файлу для получения информации
     * @var string|null
     */
    private string|null $filePath;

    /** @noinspection UnusedConstructorDependenciesInspection
     * @noinspection NotOptimalIfConditionsInspection
     */
    private function __construct(string $filePath)
    {
        set_exception_handler(function (Throwable $exception) {
            new FileSystemException($exception->getMessage(), $exception->getCode);
        });
        $this->filePath = $filePath;
        $spl = new SplFileInfo($this->filePath);
        $this->baseName = $spl->getBasename((string)self::$suffix);
        $this->extension = $spl->getExtension();
        $this->fileName = $spl->getFilename();
        $this->group = $spl->getGroup();
        $this->inode = $spl->getInode();
        $this->owner = $spl->getOwner();
        $this->path = $spl->getPath();
        $this->pathName = $spl->getPathname();
        $this->permissionList = $spl->getPerms();
        $this->realPath = $spl->getRealPath();
        $this->size = $spl->getSize();
        $this->type = $spl->getType();
        $this->isDir = $spl->isDir();
        $this->isExecutable = $spl->isExecutable();
        $this->isFile = $spl->isFile();
        $this->isLink = $spl->isLink();
        $this->isReadable = $spl->isReadable();
        $this->isWritable = $spl->isWritable();
        if ($this->isDir or $this->isFile or $this->isLink) {
            $this->aTime = $spl->getATime();
            $this->cTime = $spl->getCTime();
            $this->mTime = $spl->getMTime();
        }
        if ($this->isLink) {
            $this->linkTarget = $spl->getLinkTarget();
        }
        if (!$this->isDir) {
            $this->content = file_get_contents($this->realPath);
            $this->additionalFeatures = $spl->openFile('r+');
        }
    }

    public static function instance(string $filePath): self
    {
        return new self($filePath);
    }

    public function __toString(): string
    {
        return (string)$this->content;
    }

}
