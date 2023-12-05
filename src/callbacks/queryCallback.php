<?php
namespace Pachel\dbClass\Callbacks;
use Pachel\dbClass\Traits\exec;
use Pachel\dbClass\Traits\getMethods;
use Pachel\dbClass\Traits\params;

class queryCallback extends CallbackBase{
    use getMethods;
    use exec;
    use params;
}