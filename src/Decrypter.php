<?php

declare(strict_types=1);

namespace RedsysRest;

use stdClass;

class Decrypter
{
    public function decodeParameters(String $merchantParameters): stdClass
    {
        return json_decode(base64_decode($merchantParameters), false);
    }
}
