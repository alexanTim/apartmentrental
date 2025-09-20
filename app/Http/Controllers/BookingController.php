<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Carbon\Carbon;

class BookingController extends Controller
{
        /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $tenatId = $request->tenant_id ?: null;

         // If creating a new tenant along with booking
         if ($request->has(['frontend_create_tenant'])) {       
            $request->validate([
                'name' => 'required|string|max:100',               
                'email' => 'required|email|max:255',
                'room_id'   => 'required|exists:rooms,id',
                'telephone' => 'required|digits:11',
                'length_stay' => 'required|digits_between:1,24',                
                'stay_type' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!in_array($value, ['transient', 'monthly'])) {
                            $fail('The stay type must be either transient or monthly.');
                        }
                    },
                ],
                'start_date'=> [
                    'required',
                    'date',
                       function ($attribute, $value, $fail) use ($request) {
                        // Check if stay type is transient → must have end_date after start_date
                        if (strtotime($value) < strtotime(date('Y-m-d'))) {
                            return $fail('The start date must be today or a future date.');
                        }
                    }
                ],
            ]);

            $arraydata = [
                'name' => $request->name,               
                'email' => $request->email,
                'telephone' => $request->telephone,
                'length_stay' => $request->length_stay,
                'stay_type' => $request->stay_type,
            ];  
            
            // Check if tenant already exists by email or phone
            $tenant = Tenant::where('email', $arraydata['email'])
                ->orWhere('phone', $arraydata['telephone'])
                ->orWhere('name', $arraydata['name'])
                ->first();

            if (!$tenant) {
                // Create new tenant if not found
                $tenant = Tenant::create([
                    'name'  => $request->name,
                    'email' => $arraydata['email'] ?? null,
                    'phone' => $arraydata['telephone'] ?? null,
                ]);
            }

            $tenatId = $tenant->id;

             if($request->room_id){
                $getPrice = Room::where('id', $request->room_id)->first();
                $pricePerUnit = $getPrice->price;
            }

            $Data = [
                'tenant_id'   => $tenatId,
                'room_id'     => $request->room_id,        
                'length_stay' => $request->length_stay ?: null,
                'rent_type'   => $request->stay_type ?: null,
                'start_date'  => $request->start_date,
                'end_date'    => $request->end_date ?: null,
                'total_price' => $pricePerUnit?: 0, // Placeholder price
                'status'      => 'Pending', // Default status
                'open_ended'  => $request->open_ended ?: false,
                'notes'       => '',
            ];

        } else {
            // Validate incoming request data            
            $request->validate([
                'tenant_id' => 'required|exists:tenants,id',
                'room_id'   => 'required|exists:rooms,id',
                'stay_type' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!in_array($value, ['transient', 'monthly'])) {
                            $fail('The stay type must be either transient or monthly.');
                        }
                    },
                ],
                'start_date'=> [
                    'required',
                    'date',
                       function ($attribute, $value, $fail) use ($request) {
                        // Check if stay type is transient → must have end_date after start_date
                        if (strtotime($value) < strtotime(date('Y-m-d'))) {
                            return $fail('The start date must be today or a future date.');
                        }
                    }
                ],
                'end_date'  => [
                    'nullable',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        // Check if stay type is transient → must have end_date after start_date
                        if ($request->stay_type === 'transient') {
                            if (!$value) {
                                return $fail('End date is required for transient stays.');
                            }
                            if (strtotime($value) < strtotime($request->start_date)) {
                                return $fail('The end date must be after or equal to the start date.');
                            }
                        }

                        // If stay type is monthly and not open-ended → must also have valid end_date
                        if ($request->stay_type === 'monthly' && !$request->open_ended) {
                            if (!$value) {
                                return $fail('End date is required for monthly stays without open-ended option.');
                            }
                            if (strtotime($value) < strtotime($request->start_date)) {
                                return $fail('The end date must be after or equal to the start date.');
                            }


                        }
                    },
                ],
            ]);

            // Create booking linked to tenant
            if($request->room_id){
                $getPrice = Room::where('id', $request->room_id)->first();
                $pricePerUnit = $getPrice->price;
            }

            $Data = [
                'tenant_id'   => $tenatId,
                'room_id'     => $request->room_id,        
                'length_stay' => $request->length_stay ?: null,
                'rent_type'   => $request->stay_type ?: null,
                'start_date'  => $request->start_date,
                'end_date'    => $request->end_date ?: null,
                'total_price' => $pricePerUnit?: 0,
                'status'      => $request->status ?? 'Pending',
                'open_ended'  => $request->open_ended ?? false,
                'notes'       => $request->notes ?? null,
            ];
        }   
        
        Booking::create( $Data );

        if($request->create_booking){
            // Flash message back to Inertia page
            return redirect('/')->with('success', 'Booking submitted successfully!');    
        }else{
            $bookings = Booking::with('tenant', 'room')->get(); 
            // Return Inertia page with bookings
            return Inertia::render('Bookings/Index', [
                'bookings' => $bookings
            ]);
        }
    }

    public function create()
    {
        $tenants = Tenant::all();
        $rooms = Room::whereDoesntHave('bookings', function ($query) {
            $query->whereIn('status', ['pending', 'confirmed', 'checked_in']);
        })->get();

        return Inertia::render('Bookings/Create',[
            'tenants' => $tenants,
            'rooms' => $rooms,
        ]);
    }

    public function index()
    {
        // Fetch all bookings
        $bookings = Booking::with('tenant', 'room')->paginate(10)  ->withQueryString();

        // Return Inertia page with bookings
        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        try {
            //code...
            $data = $request->validate([
                'tenant_id' => 'required|exists:tenants,id',
                'room_id'   => 'required|exists:rooms,id',
                'stay_type' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!in_array($value, ['transient', 'monthly'])) {
                            $fail('The stay type must be either transient or monthly.');
                        }
                    },
                ],
                'start_date'=> [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        // Check if stay type is transient → must have end_date after start_date
                        if (strtotime($value) < strtotime(date('Y-m-d'))) {
                            return $fail('The start date must be today or a future date.');
                        }
                    }
                ],
                'end_date'  => [
                    'nullable',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        // Check if stay type is transient → must have end_date after start_date
                        if ($request->stay_type === 'transient') {
                            if (!$value) {
                                return $fail('End date is required for transient stays.');
                            }
                            if (strtotime($value) < strtotime($request->start_date)) {
                                return $fail('The end date must be after or equal to the start date.');
                            }
                        }

                        // If stay type is monthly and not open-ended → must also have valid end_date
                        if ($request->stay_type === 'monthly' && !$request->open_ended) {
                            if (!$value) {
                                return $fail('End date is required for monthly stays without open-ended option.');
                            }
                            if (strtotime($value) < strtotime($request->start_date)) {
                                return $fail('The end date must be after or equal to the start date.');
                            }
                        }
                    },
                ],
            ]);

            $data = [
                'tenant_id'   => $request->tenant_id,
                'room_id'     => $request->room_id,     
                'length_stay' => $request->length_stay ?: null,
                'rent_type'   => $request->stay_type ?: null,   
                'start_date'  => $request->start_date,
                'end_date'    => $request->end_date ?: null,
                'total_price' => $request->total_price?: 0, // Placeholder price
                'status'      => $request->status ?? 'Pending', // Default status
                'notes'       => $request->notes ?? null,
            ];
            
            $booking->fill($data);
            $booking->save();

            return redirect()->route('bookings.index')->with('success', 'Room updated successfully.');
        } catch (\Throwable $th) {
           throw $th;
        }
        
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    public function edit(Booking $booking)
    {
        $booking = Booking::with('tenant', 'room')->find($booking->id);
        $rooms = Room::all();
        $tenants = Tenant::all();
        return Inertia::render('Bookings/Edit', [
            'booking' => $booking,
            'rooms' => $rooms,
            'tenants' => $tenants,
        ]);
    }

    public function mainpage()
    {
        $rooms = Room::with(['bookings' => function ($q) {
            $q->where('status', '!=', 'Cancelled')
            ->whereDate('start_date', '>=', Carbon::today()); // only future or today
        }])->get();

        return Inertia::render('FrontPage', [
            'rooms' => $rooms,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
   
    }

    public function saveAbandoned(Request $request)
    {
        $booking = Booking::create([
            'guest_name' => $request->guest_name ?? 'Anonymous',
            'guest_email' => $request->guest_email,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $request->total_price ?? 0,
            'status' => 'abandoned', // mark as abandoned
        ]);

        return redirect()->back()->with('success', 'Reservation saved as abandoned.');
    }

}