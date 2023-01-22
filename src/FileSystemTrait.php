<?php /** @noinspection ALL */

declare(strict_types=1);

namespace Liberty\FileSystem;

/**
 * Трейт FileSystemTrait
 * @version 0.0.1
 * @package Liberty\FileSystem
 * @generated Зорин Алексей, please DO NOT EDIT!
 * @author Зорин Алексей <zorinalexey59292@gmail.com>
 * @copyright 2022 разработчик Зорин Алексей Евгеньевич.
 */
trait FileSystemTrait
{

    /**
     * Хранение объектов инстансов
     * @var array
     */
    private static array $instance = [];
    /**
     * Права доступа к файлу, дирректории или ссылки
     * @var int
     */
    public int $permissions = 0777;
    /**
     * Путь файла, дирректории или ссылки
     * @var string|null
     */
    private ?string $path = null;

    /**
     * Установить файл путь файла, дирректории или ссылки для дальнейшей работы
     * @param string $path
     * @return $this
     */
    public static function set(string $path): self
    {
        if (!isset(self::$instance[$path])) {
            self::$instance[$path] = new self();
            self::$instance[$path]->path = $path;
        }
        return self::$instance[$path];
    }

    /**
     * Получить подробную информацию о файле, дирректории или ссылке
     * @return FileInfo|false
     */
    public function info(): FileInfo|false
    {
        if ($this->has()) {
            return FileInfo::instance($this->path);
        }
        return false;
    }

    /**
     * Установить права на файл, дирректорию или ссылку
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function chmod(): bool
    {
        if (chmod($this->path, $this->permissions)) {
            return true;
        }
        return false;
    }

    /**
     * Установить время доступа и модификации файла, дирректории или ссылки
     * @param int|null $mTime Время изменения. Если аргумент mtime равен null,
     * используется текущее системное время (time()).
     * @param int|null $aTime Если значение параметра не null, время доступа
     * указанного файла будет установлено в значение atime.
     * В обратном случае оно будет установлено в значение параметра mtime.
     * Если же оба этих параметра равны null, то будет использовано текущее
     * системное время.
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function touch(?int $mTime = null, ?int $aTime = null): bool
    {
        return (bool)touch($this->path, $mTime, $aTime);
    }

    /**
     * Изменить группу файла, дирректории или ссылки
     * @param string|int $group Название или номер группы
     * @return bool  Вернет true в случае успеха, в противном случае false
     */
    public function chgrp(string|int $group): bool
    {
        return chgrp($this->path, $group);
    }

    /**
     * Изменить владельца файла, дирректории или ссылки
     * @param string|int $user Имя пользователя или число
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function chown(string|int $user): bool
    {
        return chown($this->path, $user);
    }

}
