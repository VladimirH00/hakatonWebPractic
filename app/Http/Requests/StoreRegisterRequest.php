<?php

namespace App\Http\Requests;


use Illuminate\Support\Str;

class StoreRegisterRequest extends AbstractBaseApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['slug' => Str::slug($this->get('name'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:20', 'unique:App\Models\Ar\Team,name'],
            'slug' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'unique:App\Models\Ar\Team,email'],
            'login' =>  ['required', 'string', 'max:70', 'unique:App\Models\Ar\Team,login'],
            'password' => ['required', 'string', 'min:8'],
            'icon' => ['required', 'file', 'max:20480'],
        ];
    }


    /**
     * Получить пользовательские имена атрибутов для формирования ошибок валидатора.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Название',
            'slug' => 'Слаг',
            'email' => 'Эл. почта',
            'login' => 'Логин',
            'password' => 'Пароль',
            'icon' => 'Иконка',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            '*.required' => 'Поле является обязательным',
            '*.numeric' => 'Поле должно быть числом',
            '*.max' => 'Поле не должно быть больше :max символов',
            '*.size' => 'Поле должно быть длинной равной :size символам',
            '*.date_format' => 'Некорректный формат поля',
            '*.string' => 'Поле должно быть строкой',
            '*.email' => 'Поле содержит не корректный формат почты',
            '*.regex' => 'Поле введенно некорректно',
            'password.min' => 'Пароль должен состоять минимум из 8 символов',
            'files.*.mimes' => 'Доступные форматы для файлов: jpg,jpeg,png,doc,docx,pdf,xls,xlsx,zip',
            'files.*.max' => 'Файл не должен быть больше больше 20 Мб ',
        ];
    }
}
