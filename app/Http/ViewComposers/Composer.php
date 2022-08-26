<?php

namespace Pterodactyl\Http\ViewComposers;

use Illuminate\Container\Container;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class Composer
{
    private SettingsRepositoryInterface $settings;

    /**
     * Types of value that can be retrieved from the database
     * when loading configured settings for the UI.
     */
    public const TYPE_BOOL = 0;
    public const TYPE_INT = 1;
    public const TYPE_STR = 2;

    /**
     * Composer constructor.
     */
    public function __construct()
    {
        Container::getInstance()->call([$this, 'loadDependencies']);
    }

    /**
     * Perform dependency injection of certain classes needed for core functionality
     * without littering the constructors of classes that extend this abstract.
     */
    public function loadDependencies(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get the setting from the database and cast it to the correct type.
     */
    protected function setting(string $data, string $type)
    {
        $setting = $this->settings->get('jexactyl::' . $data, false);

        if ($data == 'logo') {
            return $this->settings->get('settings::app:logo', 'https://cdn.discordapp.com/attachments/987734229469253674/1012679062889697330/Purple_Dark_Blue_Modern_Letter_H_Logo_Technology.png');
        }

        switch ($type) {
            case 1:
                return (int) $setting;
            case 2:
                return (string) $setting;
            case 0:
                return filter_var($setting, FILTER_VALIDATE_BOOLEAN);
            default:
                return $setting;
        }

        return null;
    }
}
