<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('books.reviews.create', ['book' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book): \Illuminate\Http\RedirectResponse
    {
        // 創建限制器的 key，包含用戶 ID 以確保每個用戶有獨立的限制
        $key = 'create-review::' . $book->id;

        // 嘗試執行評論創建邏輯，每小時限制 5 次
        $executed = RateLimiter::attempt(
            $key,
            $perHour = 5,
            function () use ($request, $book) {
                $data = $request->validate([
                    'review' => 'required|min:15',
                    'rating' => 'required|min:1|max:5|integer'
                ]);

                $book->reviews()->create($data);
            },
            $decaySeconds = 3600 // 1 小時後重置
        );

        if (!$executed) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput()
                ->withErrors(['rating' => sprintf('評論次數已達上限，請在 %d 分鐘後重試。', ceil($seconds / 60))]);
        }

        return redirect()->route('books.show', $book);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
