<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Абстрактный класс для обработки исключений
 */
abstract class AbstractBaseException extends \Exception
{
    /**
     * Отчитаться об исключении.
     *
     * @return void
     */
    public function report()
    {
        Log::error($this->message);
    }

    /**
     * Преобразовать исключение в HTTP-ответ.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request)
    {
        return response()->json(['msg' => $this->message], $this->code);
    }
}
