<?php

namespace MDQ\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MDQUserBundle extends Bundle
{
	public function getParent()
  {
    return 'FOSUserBundle';
  }
}
