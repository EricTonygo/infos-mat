<?php

namespace NNGenie\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NNGenieUserBundle extends Bundle
{
	public function getParent() {
        
        return 'FOSUserBundle'; 
        
    }
}
