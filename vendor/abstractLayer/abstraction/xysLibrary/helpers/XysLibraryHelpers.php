<?php

namespace abstraction\xysLibrary\helpers;

class XysLibraryHelpers
{
    /**
     * acesso ao helper de Chart
     *
     * @return \abstraction\xysLibrary\helpers\Chart
     */
    public function chart ()
    {
        return new Chart();
    }

    public function wizard ($idContainer = NULL, $initial = NULL)
    {
        return new Wizard($idContainer, $initial);
    }

    public function guid ()
    {
        return new Guid ();
    }

}