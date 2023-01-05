<?php

declare(strict_types = 1);

namespace Liberty\FileSystem;

use Liberty\FileSystem\FileInfo;

/**
 * Интерфейс FileSystemInterface
 * @version 0.0.1
 * @package Liberty\FileSystem
 * @generated Зорин Алексей, please DO NOT EDIT!
 * @author Зорин Алексей <zorinalexey59292@gmail.com>
 * @copyright 2022 разработчик Зорин Алексей Евгеньевич.
 */
interface FileSystemInterface
{

    /**
     * Установить файл путь файла, дирректории или ссылки для дальнейшей работы
     * @param string $path
     * @return $this
     */
    public static function set(string $path): self;

    /**
     * Получить подробную информацию о файле, дирректории или ссылке
     * @return FileInfo|false Объект FileInfo в случае успеха или false если файл не существует или произошла ошибка
     */
    public function info(): FileInfo|false;

    /**
     * Установить права на файл, дирректорию или ссылку
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function chmod(): bool;

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
    public function touch(?int $mTime = null, ?int $aTime = null): bool;

    /**
     * Изменить группу файла, дирректории или ссылки
     * @param string|int $group Название или номер группы
     * @return bool  Вернет true в случае успеха, в противном случае false
     */
    public function chgrp(string|int $group): bool;

    /**
     * Изменить владельца файла, дирректории или ссылки
     * @param string|int $user Имя пользователя или число
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function chown(string|int $user): bool;

    /**
     * Проверка существования файла, дирректории или ссылки
     * @return bool Вернет true если файл существует, в противном случае false
     */
    public function has(): bool;

    /**
     * Создать файл, дирректорию или ссылку
     * @return  FileInfo|false Объект FileInfo в случае успеха, в противном случае false
     */
    public function create(): FileInfo|false;

    /**
     * Удалить файл, дирректорию или ссылку
     * @return bool Вернет true в случае успеха, в противном случае false
     */
    public function delete(): bool;

    /**
     * Переименвать файл, дирректорию или ссылку
     * @param string $newName Новое имя
     * @param int $this->permissions Новые права на файл
     * @return FileInfo|false Вернет объект FileInfo в случае успеха, в противном случае false
     */
    public function rename(string $newName): FileInfo|false;
}
