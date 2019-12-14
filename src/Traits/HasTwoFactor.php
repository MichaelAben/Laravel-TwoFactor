<?php

namespace MabenDev\TwoFactor\Traits;

use MabenDev\TwoFactor\Models\TwoFactor;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;

trait HasTwoFactor
{
    protected static $google2fa;

    protected static function getGoogleTwoFactor()
    {
        if(empty(self::$google2fa)) self::$google2fa = new Google2FA();
        return self::$google2fa;
    }

    public function twoFactor()
    {
        return $this->hasOne(TwoFactor::class);
    }

    public function hasTwoFactor()
    {
        return $this->twoFactor()->exists();
    }

    public function setupTwoFactor()
    {
        if($this->hasTwoFactor()) return false;
        if(TwoFactor::create([
            'user_id' => $this->id,
            'secret' => $this->generateSecret(),
        ])) return true;
    }

    public function checkCode($code)
    {
        return self::getGoogleTwoFactor()->verifyKey($this->twoFactor->secret, $code);
    }

    public function getQr()
    {
        if($this->twoFactor->setup === true) return null;

        $g2faUrl = self::getGoogleTwoFactor()->getQRCodeUrl(
            env('APP_NAME', 'Laravel'),
            env('APP_EMAIL', 'admin@example.com'),
            $this->twoFactor->secret
        );

        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(400),
                new ImagickImageBackEnd()
            )
        );

        return 'data:image/png;base64,' . base64_encode($writer->writeString($g2faUrl));
    }

    protected function generateSecret()
    {
        return self::getGoogleTwoFactor()->generateSecretKey();
    }
}
