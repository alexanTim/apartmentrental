<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();

        return Inertia::render('Rooms/Index', [
            'rooms' => $rooms
        ]);
    }

    public function create()
    {
        return Inertia::render('Rooms/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'room_number' => 'required|integer|min:1',
            'price'    => 'required|numeric|min:0',
            'status'   => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        return Inertia::render('Rooms/Edit', [
            'room' => $room
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'room_number' => 'required|integer|min:1',
            'price'    => 'required|numeric|min:0',
            'status'   => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
