<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Slideshow;
use Image;
use File;
use Auth;

class SlideshowController extends Controller
{
    public function index()
    {
        $slideshow = Slideshow::paginate(5);
        $no = $slideshow->firstItem();
        return view('slideshow.index', compact('slideshow', 'no'));
    }

    public function store(Request $request)
    {
        $validator = request()->validate(['foto' => 'required']);

        if(!empty($request->file('foto')))
        {
          $gambar = $request->file('foto');
          foreach ($gambar as $key => $d)
          {
            $image = time().$d->getClientOriginalName();
            $d->move('images/slideshow/', $image);
            Image::make(public_path().'/images/slideshow/'.$image)->resize(800,350)->save();
            $data = $request->all();
            $data['image'] = $image;
            $data['user_id'] = Auth::user()->id;
            Slideshow::create($data);
          }
        }
        Flashy::success('Slideshow berhasil di tambahkan');
        return redirect('slideshow');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $slide = Slideshow::find($id);
        if($slide->publish == 'Y')  {
          $slide->publish = 'N';
          Flashy::info('Slideshow berhasil di non aktifkan');
        } else {
          $slide->publish = 'Y';
          Flashy::success('Slideshow berhasil aktifkan');
        }
        $slide->update();
        return redirect('slideshow');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function display()
    {
        $data = Slideshow::where('publish', 'Y')->get();
        return view('displaytempattidur.display', compact('data'));
    }
}
