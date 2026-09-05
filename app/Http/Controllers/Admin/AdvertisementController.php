<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(15);
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        return view('admin.advertisements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'url' => ['nullable', 'url', 'max:500'],
            'placement' => ['required', 'in:header_top,sidebar,in_article,footer'],
            'status' => ['required', 'boolean'],
        ]);

        $ad = new Advertisement();
        $ad->title = $validated['title'];
        $ad->url = $validated['url'] ?? null;
        $ad->placement = $validated['placement'];
        $ad->status = $validated['status'];

        if ($request->hasFile('image')) {
            $ad->image = $request->file('image')->store('advertisements', 'public');
        }

        $ad->save();

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement created successfully.');
    }

    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'url' => ['nullable', 'url', 'max:500'],
            'placement' => ['required', 'in:header_top,sidebar,in_article,footer'],
            'status' => ['required', 'boolean'],
        ]);

        $advertisement->title = $validated['title'];
        $advertisement->url = $validated['url'] ?? null;
        $advertisement->placement = $validated['placement'];
        $advertisement->status = $validated['status'];

        if ($request->hasFile('image')) {
            if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
                Storage::disk('public')->delete($advertisement->image);
            }
            $advertisement->image = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement->save();

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement updated successfully.');
    }

    public function toggleStatus(Advertisement $advertisement)
    {
        $advertisement->status = !$advertisement->status;
        $advertisement->save();

        return back()->with('success', 'Advertisement status updated.');
    }

    public function trackClick(Advertisement $advertisement)
    {
        $advertisement->increment('clicks');

        if ($advertisement->url) {
            return redirect()->away($advertisement->url);
        }

        return redirect()->route('home');
    }

    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return back()->with('success', 'Advertisement deleted successfully.');
    }
}
