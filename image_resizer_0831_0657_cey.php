<?php
// 代码生成时间: 2025-08-31 06:57:08
use Illuminate\Http\Request;
use App\Services\ImageResizerService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageResizerController extends Controller
{
    /**
     * Handle the image resizing request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resize(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            'target_width' => 'required|integer',
            'target_height' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $images = $request->input('images', []);
        $targetWidth = $request->input('target_width');
        $targetHeight = $request->input('target_height');

        // Create an instance of the ImageResizerService
        $imageResizer = new ImageResizerService();

        // Resize the images
        $resizedImages = $imageResizer->resizeMultipleImages($images, $targetWidth, $targetHeight);

        // Check if resizing was successful
        if ($resizedImages === false) {
            return response()->json(['error' => 'Failed to resize images.'], 500);
        }

        // Return the resized images as a JSON response
        return response()->json(['resized_images' => $resizedImages], 200);
    }
}

class ImageResizerService
{
    /**
     * Resize multiple images.
     *
     * @param array $images Array of image paths
     * @param int $targetWidth Target width for the images
     * @param int $targetHeight Target height for the images
     * @return array|bool
     */
    public function resizeMultipleImages(array $images, int $targetWidth, int $targetHeight)
    {
        foreach ($images as $imagePath) {
            $resizedImagePath = $this->resizeSingleImage($imagePath, $targetWidth, $targetHeight);
            if ($resizedImagePath === false) {
                return false;
            }
        }

        return $images; // Returning the original paths, assuming they are updated
    }

    /**
     * Resize a single image.
     *
     * @param string $imagePath The path to the image file
     * @param int $targetWidth Target width for the image
     * @param int $targetHeight Target height for the image
     * @return string|bool The path to the resized image or false on failure
     */
    protected function resizeSingleImage(string $imagePath, int $targetWidth, int $targetHeight)
    {
        try {
            $image = Image::make($imagePath);
            $image->resize($targetWidth, $targetHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $resizedImagePath = $this->saveResizedImage($image, $imagePath);
            return $resizedImagePath;
        } catch (\Exception $e) {
            // Handle the exception, log error, etc.
            return false;
        }
    }

    /**
     * Save the resized image to storage.
     *
     * @param \Intervention\Image\Image $image The Intervention image object
     * @param string $originalPath The original image path
     * @return string|bool The path to the saved resized image or false on failure
     */
    protected function saveResizedImage($image, $originalPath)
    {
        try {
            $resizedImagePath = basename($originalPath);
            $image->save($resizedImagePath);

            return $resizedImagePath;
        } catch (\Exception $e) {
            // Handle the exception, log error, etc.
            return false;
        }
    }
}
