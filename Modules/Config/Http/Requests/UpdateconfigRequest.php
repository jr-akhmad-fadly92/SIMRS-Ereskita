<?php

namespace Modules\Config\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateconfigRequest extends FormRequest
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
			'alamat' => 'required',
			'website' => 'required',
			'email' => 'required|email',
			'logo' => 'sometimes|image',
			'bayardepan' => 'required',
			'kasirtindakan' => 'required',
			'antrianfooter' => 'required',
			'tahuntarif' => 'required',
			'panjangkodepasien' => 'required',
			'ipsep' => 'required',
			// start add
            'kota' => 'required',
            'pt' => 'required',
            'tlp' => 'required',
			// end add
            'usersep' => 'required',
			'ipinacbg' => 'required'
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
