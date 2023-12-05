<?php
namespace Pachel\dbClass\Callbacks;
use Pachel\dbClass\Traits\exec;
use Pachel\dbClass\Traits\getMethods;

class paramsCallback extends CallbackBase{
    use getMethods;
    use exec;
}