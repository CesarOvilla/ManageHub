<?php

namespace App\Traits;

use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait HandlesUserSettings
{
    public $settings = [];

    /**
     * Cargar todas las configuraciones del usuario.
     */
    public function loadSettings()
    {
        $this->settings = UserSetting::where('user_id', Auth::user()->id)
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Cargar una configuración específica por clave.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getSetting($key)
    {
        return $this->settings[$key] ?? null;
    }

    public function getSettingByUser($user_id, $key)
    {
        return UserSetting::where('user_id', $user_id)
            ->where('key', $key)
            ->value('value');
    }

    /**
     * Guardar o actualizar una configuración.
     *
     * @param string $key
     * @param mixed $value
     */
    public function saveSetting($key, $value)
    {
        UserSetting::updateOrCreate(
            ['user_id' => Auth::user()->id, 'key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value]
        );

        // Actualizar la configuración en el array local
        $this->settings[$key] = $value;
    }

    /**
     * Olvidar una configuración específica.
     *
     * @param string $key
     */
    public function forgetSetting($key)
    {
        UserSetting::where('user_id', Auth::user()->id)
            ->where('key', $key)
            ->delete();

        unset($this->settings[$key]);
    }

    /**
     * Olvidar todas las configuraciones del usuario.
     */
    public function forgetAllSettings()
    {
        UserSetting::where('user_id', Auth::user()->id)->delete();
        $this->settings = [];
    }
}
