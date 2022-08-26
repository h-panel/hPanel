<?php

namespace Pterodactyl\Http\Requests\Admin\Jexactyl;

use Illuminate\Validation\Rule;
use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class MailFormRequest extends AdminFormRequest
{
    /**
     * Return rules to validate mail settings POST data against.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mail:host' => 'required|string',
            'mail:port' => 'required|integer|between:1,65535',
            'mail:encryption' => ['present', Rule::in([null, 'tls', 'ssl'])],
            'mail:username' => 'nullable|string|max:191',
            'mail:password' => 'nullable|string|max:191',
            'mail:from:address' => 'required|string|email',
            'mail:from:name' => 'nullable|string|max:191',
        ];
    }

    /**
     * Override the default normalization function for this type of request
     * as we need to accept empty values on the keys.
     *
     * @param array $only
     *
     * @return array
     */
    public function normalize(array $only = null)
    {
        $keys = array_flip(array_keys($this->rules()));

        if (empty($this->input('mail:password'))) {
            unset($keys['mail:password']);
        }

        return $this->only(array_flip($keys));
    }
}
