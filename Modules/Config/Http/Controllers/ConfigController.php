<?php



namespace Modules\Config\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Routing\Controller;
use App\User;
use Modules\Role\Entities\Role;
use Auth;

use Modules\Config\Http\Requests\SaveconfigRequest;

use Modules\Config\Http\Requests\UpdateconfigRequest;

use Modules\Config\Entities\Config;

use Modules\Config\Entities\Tahuntarif;

use Image;

use MercurySeries\Flashy\Flashy;



class ConfigController extends Controller

{

    public function index()

    {

        if(Config::count() >= 1){

          return $this->show();

        }

        $config = Config::count();

        return view('config::index', compact('config'));

    }



    public function create()

    {

        $tahun = Tahuntarif::pluck('tahun','id');

        return view('config::create', compact('tahun'));

    }



    public function store(SaveconfigRequest $request)

    {

      if(!empty($request->file('logo'))){

          $image = time().$request->file('logo')->getClientOriginalName();

          $request->file('logo')->move('images/', $image);

          $img = Image::make(public_path().'/images/'.$image)->resize(300,196);

          $img->save();

      }else{

        $image = '';

      }

      $data = $request->all();

      $data['logo'] = $image;

      Config::create($data);

      Flashy::success('Konfigurasi sukses di tambahkan');

      return redirect()->route('config');

    }



    public function show()

    {

      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
        $config = Config::find(1);

        return view('config::show', compact('config'));
        
      }else{
        return redirect('/dashboard');
      }

        

    }



    public function edit()

    {
      if(strtolower(Auth::user()->role()->first()->name)=='administrator' )
      {
        $config = Config::find(1);

        $tahun = Tahuntarif::pluck('tahun','id');

        return view('config::edit', compact('config','tahun'));

      }else{
        return redirect('/dashboard');
      }

        
    }



    public function update(Request $request, $id)

    {

		$config = Config::find($id);

		if(!empty($request->file('logo'))){

      $image       = $request->file('logo');

      $filename    = $image->getClientOriginalName();



      $image_resize = Image::make($image->getRealPath());              

      $image_resize->resize(300,196);

      $image_resize->save(public_path('/laravel/images/' .$filename));

      /*

      $file = $request->file('logo');

      $image = time().$file->getClientOriginalName();

      $tujuan_upload = public_path().'/images';

      $file->move($tujuan_upload,$image);*/



		}else{

      $image = $config->logo;

      $filename = $image;

		}

	  $data = $request->all();

		$data['logo'] = $filename;

    $config->update($data);

  

		Flashy::info('Konfigurasi sukses di update');

		return redirect()->route('config');

    }



    public function destroy()

    {

    }

}

