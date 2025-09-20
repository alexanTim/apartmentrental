<?php 
namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return Inertia::render('Sliders/Index', compact('sliders'));
    }

    public function store(Request $request)
    {
      Log::info('Storing new slider', ['request' => $request->all()]);
       try {
        //code...
          $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'url' => 'nullable|url',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            // Log the validation errors
            Log::warning('Slider validation failed', [
                'errors' => $validator->errors()->all(),
                'input' => $request->all()
            ]);

            // Redirect back with errors
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $imagePath = $request->file('image')->store('sliders', 'public');

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'url' => $request->url,
            'order' => $request->order ?? 0,
            'status' => $request->status ?? true,
        ];

      
        Slider::create($data);

        return redirect()->back()->with('success', 'Slider added successfully.');
       } catch (\Throwable $th) {
          throw $th;
       }
        
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slider->image);
            $slider->image = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($request->only('title','subtitle','url','order','status'));

        return redirect()->back()->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image);
        $slider->delete();
        return redirect()->back()->with('success', 'Slider deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->sliders as $s) {
            Slider::where('id', $s['id'])->update(['order' => $s['order']]);
        }
        return redirect()->back()->with('success', 'Slider order updated.');
    }

    public function updateImage(Request $request, Slider $slider)
    {
        $request->validate(['image' => 'required|image|max:2048']);
        Storage::disk('public')->delete($slider->image);
        $slider->update(['image' => $request->file('image')->store('sliders', 'public')]);
        return redirect()->back()->with('success', 'Image updated.');
    }

}
