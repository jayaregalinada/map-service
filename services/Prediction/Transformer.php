<?php

namespace Services\Prediction;

use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    public function transform(Prediction $prediction)
    {
        return $prediction->toArray();
    }
}
