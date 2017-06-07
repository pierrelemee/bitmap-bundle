<?php

namespace Bitmap\Bundle\BitmapBundle;

use Bitmap\Bundle\BitmapBundle\DependencyInjection\BitmapExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle.
 *
 * @author Pierre Lemée <pierre@pierrelemee.fr>
 */
class BitmapBundle extends Bundle
{
    public function boot()
    {
        // TODO find a way to be smarter than this brutal service initialization
        $this->container->get('bitmap');
    }

    public function getContainerExtension()
    {
        return new BitmapExtension();
    }
}
