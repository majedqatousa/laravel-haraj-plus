<?php


namespace App\Http\Services;


use App\Classes\FileOperations;
use App\Http\Repositories\MainReopsitory;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{

    private $imageDirectory = 'products';

    public function __construct(product $product)
    {


        $this->repo = new MainReopsitory($product);
    }


    public function deactivate($id)
    {

        if ($this->repo->get($id)->is_valid)
            $this->repo->update($id, ['is_valid' => 0]);

        else
            $this->repo->update($id, ['is_valid' => 1]);
    }
    public function storeproduct(Request $request)
    {
        $requestData = $request->all();
        $arr = explode("<a", $request->description);
        for ($i = 0; $i < count($arr); $i++) {
            if ($i == 0)
                continue;
            // request()->getHost()
            $arr[$i] = (strpos($arr[$i], 'haraj-plus.sa')) ? $arr[$i] : " rel='nofollow' target='_blank'" . $arr[$i];
        }
        $result = implode("<a", $arr);
        $requestData['description'] = $result;
        unset($requestData['image']);
        $url = $requestData['video'];
        if ($url) {
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
            isset($my_array_of_vars['v']) ? $video_id = $my_array_of_vars['v'] : $video_id = null;
            // $requestData['video'] = "<iframe width=\"853\" height=\"480\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
            $requestData['video'] = $video_id;
        }

        //dd($request);
       
        // $requestData['main_image'] = FileOperations::StoreFileAs($this->imageDirectory, $request->main_image, str::random(8));
        $fileNameWithExtintion = $request->file('main_image')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExtintion ,PATHINFO_FILENAME);

        $extintion = $request->file('main_image')->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extintion;
        $request->file('main_image')->storeAs('products' , $fileNameToStore);
        $filePath = public_path('storage/products/'.$fileNameToStore);

        $requestData['main_image'] = FileOperations::TinifyImg($this->imageDirectory, $request->file('main_image'));

        $requestData['user_id'] = auth()->id();

        //   dd($requestData);
        //dd($requestData);
        $requestData['user_promoted'] = auth()->user()->is_promoted;
        $product = $this->repo->store($requestData);
        //    dd('dfds');0


        if (request()->hasFile('image')) {
            foreach (request('image') as $img) {
                //dd($img);
                $product->images->create([
                    'path' => FileOperations::TinifyImg($this->imageDirectory, $img)
                ]);
            }
        }
    }

    public function getproducts()
    {
        return $this->repo->getall();
    }
    public function getproduct($id)
    {
        return $this->repo->get($id);
    }

    public function updateproduct($id, Request $request)
    {

        $requestData = $request->all();
        $requestData['is_valid'] = 3;
        if ($request->has('video')) {

            $url = $requestData['video'];
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                $video_id = $my_array_of_vars['v'];
                $requestData['video'] = "<iframe width=\"853\" height=\"480\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
            }
        }
        $arr = explode("<a", $request->description);
        for ($i = 0; $i < count($arr); $i++) {
            if ($i == 0)
                continue;
            // request()->getHost()
            $arr[$i] = (strpos($arr[$i], 'haraj-plus.sa')) ? $arr[$i] : " rel='nofollow' target='_blank'" . $arr[$i];
        }
        $result = implode("<a", $arr);
        $requestData['description'] = $result;
        // if(filter_var($url, FILTER_VALIDATE_URL)){
        //     parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        //     $video_id = $my_array_of_vars['v'];
        //     $requestData['video'] = "<iframe width=\"853\" height=\"480\" src=\"https://www.youtube.com/embed/$video_id\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
        // }



        //dd($requestData);
        unset($requestData['image']);
        $product = $this->repo->get($id);


        if ($request->has('main_image')) {
            // Stroge::delete($product->main_image);
            $requestData['main_image'] = FileOperations::StoreFileAs($this->imageDirectory, $request->main_image, str::random(8));
        }


        if ($request->deleted_ids) {
            $deletedImages = explode(',', $request->deleted_ids);
            foreach ($deletedImages as $image) {
                Image::find($image)->delete();
            }
        }


        //dd($deletedImages);



        $product = $this->repo->update($id, $requestData);


        if (request()->hasFile('image')) {


            foreach (request('image') as $img) {

                $product->images->create([
                    'path' => FileOperations::StoreFileAs($this->imageDirectory, $img, str::random(8))
                ]);
            }
        }
    }

    public function getMore($id)
    {
        return $this->repo->getMore($id);
    }


    public function deleteProduct($id)
    {
        $product = $this->repo->get($id);
        if ($product->image != null)
            Storage::delete($product->image);

        $this->repo->delete($id);
    }
    public function getStatus()
    {
    }
}
