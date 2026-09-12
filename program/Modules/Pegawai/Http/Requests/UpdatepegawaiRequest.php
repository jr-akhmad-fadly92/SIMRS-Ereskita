<?php

namespace Modules\Pegawai\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatepegawaiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'nama' => 'required',
          'tgllahir' => 'required',
          'tmplahir' => 'required',
          'kelamin' => 'required',
          'agama' => 'required',
          'alamat' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
