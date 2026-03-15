<?php

namespace App\Events;

use App\Models\Result;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResultPublished
{
    use Dispatchable, SerializesModels;

    public $result;

    public function __construct(Result $result)
    {
        $this->result = $result;
    }
}
