<?php

namespace App\Classes;


//use Intervention\Image\ImageManagerStatic as Image;

class FileOperations
{




    public static function StoreFileAs($directory, $uploadedFile, $newFileName){
        return $uploadedFile->storeAs($directory, self::NewFileNameWithExtension($uploadedFile, $newFileName));
    }

    public static function StoreFile($directory, $uploadedFile){
        return $uploadedFile->store($directory);
    }

    public static function NewFileNameWithExtension($uploadedFile, $newFileName){
        return self::SlugifyFileName($newFileName).self::AddExtension($uploadedFile);
    }

    public static function SlugifyFileName($newFileName){
        return str_slug($newFileName, '-');
    }

    public static function AddExtension($uploadedFile){
        return '.'.$uploadedFile->extension();
    }

  /*  public static function ResizeImage($width, $height, $path){
        Image::make('storage/'.$path)->resize($width, $height)->save('storage/'.$path);
    }*/

    public static function TinifyImg($directory , $requestFile){
     
        $fileNameWithExtintion = $requestFile->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExtintion ,PATHINFO_FILENAME);

        $extintion = $requestFile->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extintion;
        $requestFile->storeAs($directory , $fileNameToStore);
        $filePath = public_path('storage/'.$directory.'/'.$fileNameToStore);
        try {
         
            \Tinify\setKey(env("TINIFY_KEY"));
            $source = \Tinify\fromFile($filePath);
            $source->toFile($filePath);
            return $fileNameToStore;
        } catch(\Tinify\AccountException $e) {
            dd("The error message is: " . $e->getMessage());
            // Verify your API key and account limit.
        } catch(\Tinify\ClientException $e) {
            // Check your source image and request options.
            dd("The error message is: " . $e->getMessage());
        } catch(\Tinify\ServerException $e) {
            // Temporary issue with the Tinify API.
            dd("The error message is: " . $e->getMessage());
        } catch(\Tinify\ConnectionException $e) {
            // A network connection error occurred.
            dd("The error message is: " . $e->getMessage());
        } catch(Exception $e) {
            // Something else went wrong, unrelated to the Tinify API.
            dd("The error message is: " . $e->getMessage());
        }
      
         
      
    }
}
