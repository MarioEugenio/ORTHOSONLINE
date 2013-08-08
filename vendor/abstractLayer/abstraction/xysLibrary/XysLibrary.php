<?php

namespace abstraction\xysLibrary;

class XysLibrary
{
    /**
     * Acesso a classes externas
     *
     * @return \abstraction\xysLibrary\externals\XysLibraryExternals
     */
    public function externals ()
    {
        return new \abstraction\xysLibrary\externals\XysLibraryExternals();
    }

    /**
     * Acesso a classe de data
     *
     * @return \abstraction\xysLibrary\date\DateUtil
     */
    public function date ()
    {
        return new \abstraction\xysLibrary\date\DateUtil();
    }

    /**
     * acesso a classe de helpers
     *
     * @return \abstraction\xysLibrary\helpers\XysLibraryHelpers
     */
    public function helpers ()
    {
        return new \abstraction\xysLibrary\helpers\XysLibraryHelpers();
    }

    /**
     * acesso a classe de máscaras
     *
     * @return \abstraction\xysLibrary\mask\Mask
     */
    public function masks ()
    {
        return new \abstraction\xysLibrary\mask\Mask();
    }

    /**
     * acesso a classe de recaptcha
     *
     * @return \abstraction\xysLibrary\recaptcha\recaptcha
     */
    public function recaptcha ()
    {
        return new \abstraction\xysLibrary\recaptcha\Recaptchalib();
    }

    /**
     * acesso a classe de validação
     *
     * @return \abstraction\xysLibrary\validate\Validate
     */
    public function validates ()
    {
        return new \abstraction\xysLibrary\validate\Validate();
    }

    /**
     * acesso a classe de upload
     *
     * @param array $file
     * @return \abstraction\xysLibrary\upload\Upload
     */
    public function upload ($file)
    {
        return new \abstraction\xysLibrary\upload\Upload($file);
    }

    /**
     * acesso a classe de registro
     *
     * @return \abstraction\xysLibrary\Registry\Registry
     */
    public function registry ()
    {
        return new \abstraction\xysLibrary\Registry\Registry();
    }

    /**
     * acesso a classe de security
     *
     * @return \abstraction\xysLibrary\security\Security
     */
    public function security (\Symfony\Component\HttpFoundation\Request $request)
    {
        return new \abstraction\xysLibrary\security\Security($request);
    }

    /**
     * acesso a classe de security
     *
     * @return \abstraction\xysLibrary\setup\install
     */
    public function setup ($container)
    {
        return new \abstraction\xysLibrary\setup\Install($container);
    }

    public function utils ()
    {
        return new \abstraction\xysLibrary\utils\utils();
    }
}