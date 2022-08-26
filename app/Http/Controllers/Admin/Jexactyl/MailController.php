<?php

namespace Pterodactyl\Http\Controllers\Admin\Jexactyl;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prologue\Alerts\AlertsMessageBag;
use Illuminate\Contracts\Console\Kernel;
use Pterodactyl\Notifications\MailTested;
use Illuminate\Support\Facades\Notification;
use Pterodactyl\Exceptions\DisplayException;
use Pterodactyl\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\Encrypter;
use Pterodactyl\Providers\SettingsServiceProvider;
use Pterodactyl\Http\Requests\Admin\Jexactyl\MailFormRequest;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class MailController extends Controller
{
    /**
     * @var \Prologue\Alerts\AlertsMessageBag
     */
    private $alert;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    private $config;

    /**
     * @var \Illuminate\Contracts\Encryption\Encrypter
     */
    private $encrypter;

    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $kernel;

    /**
     * @var \Pterodactyl\Contracts\Repository\SettingsRepositoryInterface
     */
    private $settings;

    /**
     * MailController constructor.
     */
    public function __construct(
        AlertsMessageBag $alert,
        ConfigRepository $config,
        Encrypter $encrypter,
        Kernel $kernel,
        SettingsRepositoryInterface $settings
    ) {
        $this->alert = $alert;
        $this->config = $config;
        $this->encrypter = $encrypter;
        $this->kernel = $kernel;
        $this->settings = $settings;
    }

    /**
     * Render UI for editing mail settings. This UI should only display if
     * the server is configured to send mail using SMTP.
     */
    public function index(): View
    {
        return view('admin.jexactyl.mail', [
            'disabled' => $this->config->get('mail.driver') !== 'smtp',
        ]);
    }

    /**
     * Handle request to update SMTP mail settings.
     *
     * @throws DisplayException
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function update(MailFormRequest $request): Response
    {
        if ($this->config->get('mail.driver') !== 'smtp') {
            throw new DisplayException('This feature is only available if SMTP is the selected email driver for the Panel.');
        }

        $values = $request->normalize();
        if (array_get($values, 'mail:password') === '!e') {
            $values['mail:password'] = '';
        }

        foreach ($values as $key => $value) {
            if (in_array($key, SettingsServiceProvider::getEncryptedKeys()) && !empty($value)) {
                $value = $this->encrypter->encrypt($value);
            }

            $this->settings->set('settings::' . $key, $value);
        }

        $this->kernel->call('queue:restart');

        return response('', 204);
    }

    /**
     * Submit a request to send a test mail message.
     */
    public function test(Request $request): Response
    {
        try {
            Notification::route('mail', $request->user()->email)
                ->notify(new MailTested($request->user()));
        } catch (Exception $exception) {
            return response($exception->getMessage(), 500);
        }

        return response('', 204);
    }
}
