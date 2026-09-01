<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class SiteSetting
{
    /**
     * Get one setting.
     */
    public static function get(
        string $key,
        mixed $default = null
    ): mixed {
        $row =
            Database::first(
                '
                SELECT
                    setting_value

                FROM site_settings

                WHERE setting_key = :setting_key

                LIMIT 1
                ',
                [
                    ':setting_key' =>
                        $key,
                ]
            );

        if (
            $row === null
        ) {
            return $default;
        }

        return $row['setting_value']
            ?? $default;
    }


    /**
     * Set one setting.
     *
     * All settings are stored as strings in the database.
     */
    public static function set(
        string $key,
        mixed $value
    ): void {
        /*
         * Convert all scalar values to strings before saving.
         *
         * This allows settings such as:
         *
         * true  -> "1"
         * false -> "0"
         * 5000  -> "5000"
         * "foo" -> "foo"
         *
         * while still allowing null.
         */
        if (
            $value === null
        ) {
            $stringValue = null;
        } elseif (
            is_bool($value)
        ) {
            $stringValue =
                $value
                    ? '1'
                    : '0';
        } else {
            $stringValue =
                (string) $value;
        }


        Database::execute(
            '
            INSERT INTO site_settings (
                setting_key,
                setting_value
            )

            VALUES (
                :setting_key,
                :setting_value
            )

            ON DUPLICATE KEY UPDATE
                setting_value =
                    VALUES(setting_value)
            ',
            [
                ':setting_key' =>
                    $key,

                ':setting_value' =>
                    $stringValue,
            ]
        );
    }


    /**
     * Get a boolean setting.
     *
     * Correctly handles:
     *
     * "1"
     * "0"
     * "true"
     * "false"
     * "yes"
     * "no"
     */
    public static function getBool(
        string $key,
        bool $default = false
    ): bool {
        $value =
            self::get(
                $key
            );

        if (
            $value === null
        ) {
            return $default;
        }


        if (
            is_bool($value)
        ) {
            return $value;
        }


        if (
            is_int($value)
            || is_float($value)
        ) {
            return (bool) $value;
        }


        $normalized =
            strtolower(
                trim(
                    (string) $value
                )
            );


        if (
            in_array(
                $normalized,
                [
                    '1',
                    'true',
                    'yes',
                    'on',
                    'enabled',
                ],
                true
            )
        ) {
            return true;
        }


        if (
            in_array(
                $normalized,
                [
                    '0',
                    'false',
                    'no',
                    'off',
                    'disabled',
                    '',
                ],
                true
            )
        ) {
            return false;
        }


        return $default;
    }


    /**
     * Get an integer setting.
     */
    public static function getInt(
        string $key,
        int $default = 0
    ): int {
        $value =
            self::get(
                $key
            );

        if (
            $value === null
            || $value === ''
        ) {
            return $default;
        }


        if (
            !is_numeric(
                $value
            )
        ) {
            return $default;
        }


        return (int) $value;
    }


    /**
     * Get a JSON setting as an array.
     *
     * @return array<string, mixed>|array<int, mixed>
     */
    public static function getJson(
        string $key,
        array $default = []
    ): array {
        $value =
            self::get(
                $key
            );

        if (
            !is_string($value)
            || trim($value) === ''
        ) {
            return $default;
        }


        try {
            $decoded =
                json_decode(
                    $value,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );
        } catch (
            \Throwable
        ) {
            return $default;
        }


        return is_array($decoded)
            ? $decoded
            : $default;
    }


    /**
     * Save an array as JSON.
     */
    public static function setJson(
        string $key,
        array $value
    ): void {
        $json =
            json_encode(
                $value,
                JSON_UNESCAPED_UNICODE
                | JSON_UNESCAPED_SLASHES
                | JSON_THROW_ON_ERROR
            );

        self::set(
            $key,
            $json
        );
    }
}