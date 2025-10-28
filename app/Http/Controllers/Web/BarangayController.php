<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Web\PurokController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\Barangay;
use App\Models\Midwife;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class BarangayController extends Controller
{
    /**
     * Display a paginated and searchable list of barangays for the web view.
     */
    public function listView(Request $request)
    {
        $query = Barangay::withCount([
            'puroks as puroks_count' => function ($q) {
                $q->withoutGlobalScopes()->where('puroks.status', 'active');
            },
        ])
        ->where('barangays.status', 'active');

        // --- Search ---
        $query->when($request->filled('search'), function ($q) use ($request) {
            $searchTerm = $request->input('search');
            return $q->where('barangays.name', 'like', "%{$searchTerm}%");
        });

        // --- Sorting ---
        $filter = $request->input('filter', 'alpha_asc');
        if ($filter === 'alpha_asc') {
            $query->orderBy('barangays.name', 'asc');
        } elseif ($filter === 'alpha_desc') {
            $query->orderBy('barangays.name', 'desc');
        } elseif ($filter === 'puroks_count') {
            $query->orderBy('puroks_count', 'desc');  // 👈 Sort by purok count
        }

        // --- Date Sorting ---
        $dateSort = $request->input('sort_date');
        if ($dateSort === 'week') {
            $query->where('barangays.created_at', '>=', now()->subWeek());
        } elseif ($dateSort === 'month') {
            $query->where('barangays.created_at', '>=', now()->subMonth());
        } elseif ($dateSort === 'year') {
            $query->where('barangays.created_at', '>=', now()->subYear());
        }

        // Handle newest/oldest separately if needed
        if ($dateSort === 'newest') {
            $query->orderBy('barangays.created_at', 'desc');
        } elseif ($dateSort === 'oldest') {
            $query->orderBy('barangays.created_at', 'asc');
        }

        $barangays = $query->paginate(15)->appends($request->query());

        // --- Count residents separately ---
        $barangays->getCollection()->transform(function ($barangay) {
            $barangay->residents_count = DB::table('residents')
                ->join('families', 'residents.family_id', '=', 'families.id')
                ->join('households', 'families.household_id', '=', 'households.id')
                ->join('puroks', 'households.purok_id', '=', 'puroks.id')
                ->where('puroks.brgy_id', $barangay->id)
                ->where('residents.status', 'active')
                ->count();
            
            return $barangay;
        });

        // 👇 Sort by residents_count after fetching (since it's appended)
        if ($filter === 'residents_count') {
            $sorted = $barangays->getCollection()->sortByDesc('residents_count')->values();
            $barangays->setCollection($sorted);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($barangays);
        }

        return view('mho.barangay-list', compact('barangays'));
    }

    public function index()
    {
        return Barangay::withCount(['puroks', 'residents'])->get();
    }
    
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => [
            'required', 'string', 'max:255',
            Rule::unique('barangays', 'name'),
        ],
    ]);

    // Create the new barangay
    $barangay = Barangay::create([
        'name' => $validated['name'],
        'user_id' => Auth::id(),
    ]);

    // Create default medicines for this barangay
    $defaultMedicines = [
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Calcium Carbonate',
            'generic_name' => 'Calcium Carbonate',
            'category' => 'cc',
            'form' => 'Tablet',
            'description' => 'Calcium carbonate is a dietary supplement used when the amount of calcium taken in the diet is not enough. Calcium is needed by the body for healthy bones, muscles, nervous system, and heart. Calcium carbonate also is used as an antacid to relieve heartburn, acid indigestion, and upset stomach.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Tetanus Diphteria',
            'generic_name' => 'Tetanus and Diphtheria',
            'category' => 'tt/td',
            'form' => 'Vaccine',
            'description' => 'The tetanus-diphtheria (Td) vaccine protects against two serious bacterial infections and is recommended for all children 7 years and older and adults',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Albendazole 400mg',
            'generic_name' => null,
            'category' => 'deworming',
            'form' => 'Tablet',
            'description' => 'For Deworming',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Vitamin A',
            'generic_name' => 'Vitamin A',
            'category' => 'vit-a',
            'form' => 'Tablet',
            'description' => 'Vitamin A is an essential fat-soluble vitamin crucial for vision, immune function, reproduction, and cellular communication. It comes in two forms: preformed vitamin A (retinoids) from animal sources like liver and eggs, and provitamin A carotenoids from plant sources like carrots and sweet potatoes, which the body converts into vitamin A. Vitamin A supports healthy skin, mucous membranes, and organs like the heart, lungs, and eyes.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Iodine',
            'generic_name' => 'Iodine',
            'category' => 'iodine',
            'form' => 'Tablet',
            'description' => 'Strong iodine is used to treat overactive thyroid, iodine deficiency, and to protect the thyroid gland from the effects of radiation from radioactive forms of iodine.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Iron with Folic Acid',
            'generic_name' => 'Iron with Folic Acid',
            'category' => 'iron-w-fa',
            'form' => 'Tablet',
            'description' => 'used to treat or prevent low iron in the body. It is used to treat low folate levels. It is Used to help growth and good health.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'BCG Vaccine',
            'generic_name' => 'bacille Calmette-Guérin',
            'category' => 'bcg',
            'form' => 'Vaccine',
            'description' => 'The BCG (bacille Calmette-Guérin) vaccine is used primarily to prevent tuberculosis (TB), especially in infants and children in countries with high TB rates. It is administered as a single dose, typically shortly after birth, and can also be used in adults at high risk of TB exposure or for treating certain types of bladder cancer. The vaccine is made from a weakened strain of Mycobacterium bovis and can cause a temporary sore or scar at the injection site, though complications are rare.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Hepatitis B Birth Dose Vaccine',
            'generic_name' => 'Hepa B BD',
            'category' => 'hepa-b-bd',
            'form' => 'Vaccine',
            'description' => 'Hepatitis B vaccine birth dose is a shot given to infants within 24 hours of birth. This vaccine is crucial for protecting newborns from acquiring the Hepatitis B virus (HBV) during delivery, which can lead to a high risk of chronic infection and severe liver disease later in life. The birth dose is the first step in a vaccination series that provides lifelong protection against Hepatitis B.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Diphtheria, Tetanus, Pertussis , Hepatitis B, and Haemophilus Influenzae Type B Vaccine',
            'generic_name' => 'DTP-HepB-Hib',
            'category' => 'dpt-hepb-hib',
            'form' => 'Vaccine',
            'description' => 'DTP-HepB-Hib is a pentavalent vaccine that protects against five diseases: diphtheria, tetanus, pertussis (whooping cough), HepB (hepatitis B), and Hib (Haemophilus influenzae type b). It is a combination vaccine, meaning a single shot provides protection against all five illnesses, which is commonly used in public immunization programs',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Oral Polio Vaccine',
            'generic_name' => 'OPV',
            'category' => 'opv',
            'form' => 'Tablet',
            'description' => 'OPV stands for Oral Polio Vaccine, which is a vaccine given in the form of oral drops to prevent poliomyelitis. It contains a live, weakened version of the poliovirus and has been instrumental in global polio eradication efforts because it induces immunity in the gut, which helps stop the spread of the virus.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Pneumococcal conjugate vaccine',
            'generic_name' => 'PCV',
            'category' => 'pcv',
            'form' => 'Vaccine',
            'description' => 'Pneumococcal conjugate vaccine helps protect against bacteria that cause pneumococcal disease. There are four pneumococcal conjugate vaccines (PCV13, PCV15, PCV20, and PCV21). The different vaccines are recommended for different people based on their age and medical status.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Multiple Micronutrient Powder',
            'generic_name' => 'MNP',
            'category' => 'mnp',
            'form' => 'Capsule',
            'description' => 'MNPs are single-dose, shelf-stable sachets containing essential vitamins and minerals, designed to be sprinkled onto complementary foods at the point of use to address micronutrient deficiencies in vulnerable populations like infants and young children.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'MMR Vaccine',
            'generic_name' => 'MMR',
            'category' => 'mmr',
            'form' => 'Vaccine',
            'description' => 'The MMR vaccine is a combination vaccine that protects against three serious viral infections: measles, mumps, and rubella. It contains weakened live viruses that stimulate the immune system to create protection without causing the full illness. A two-dose schedule is recommended for children, typically given between 12–15 months and 4–6 years of age.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'Iron for Kids',
            'generic_name' => 'Iron',
            'category' => 'iron',
            'form' => 'Capsule',
            'description' => 'Iron supplements may be necessary for breastfed babies at 4 months old or preterm babies starting as early as 2 weeks, but only under the guidance of a healthcare professional, as formula-fed babies typically get enough iron from fortified formula. Supplements are also crucial for premature infants who might not have received sufficient iron in utero.',
        ],
        [
            'default_status' => 1,
            'status' => 'active',
            'added_by' => Auth::id(),
            'medicine_name' => 'IPV (Inactivated Polio Vaccine)',
            'generic_name' => 'IPV',
            'category' => 'ipv',
            'form' => 'Vaccine',
            'description' => 'The IPV (Inactivated Polio Vaccine) is an injectable vaccine that protects against polio by using a killed virus.',
        ],
    ];

    // Insert medicines with the barangay ID
    foreach ($defaultMedicines as $medicine) {
        Medicine::create(array_merge($medicine, ['brgy_id' => $barangay->id]));
    }

    // CREATE DEFAULT DAILY ACTIVITIES
    $defaultActivities = [
        [
            'day' => 'Monday',
            'brgy_id' => $barangay->id,
            'icon_id' => null,
            'updated_by' => Auth::id(),
            'activities' => json_encode([]),
        ],
        [
            'day' => 'Tuesday',
            'brgy_id' => $barangay->id,
            'icon_id' => null,
            'updated_by' => Auth::id(),
            'activities' => json_encode([]),
        ],
        [
            'day' => 'Wednesday',
            'brgy_id' => $barangay->id,
            'icon_id' => null,
            'updated_by' => Auth::id(),
            'activities' => json_encode([]),
        ],
        [
            'day' => 'Thursday',
            'brgy_id' => $barangay->id,
            'icon_id' => null,
            'updated_by' => Auth::id(),
            'activities' => json_encode([]),
        ],
        [
            'day' => 'Friday',
            'brgy_id' => $barangay->id,
            'icon_id' => null,
            'updated_by' => Auth::id(),
            'activities' => json_encode([]),
        ],
        [
            'day' => 'Saturday',
            'brgy_id' => $barangay->id,
            'icon_id' => null,
            'updated_by' => Auth::id(),
            'activities' => json_encode([]),
        ],
        [
            'day' => 'Sunday',
            'brgy_id' => $barangay->id,
            'icon_id' => null,
            'updated_by' => Auth::id(),
            'activities' => json_encode([]),
        ],
    ];

    // Insert daily activities
    foreach ($defaultActivities as $activity) {
        DailyActivities::create($activity);
    }

    return response()->json([
        'message' => 'Barangay added successfully with default medicines and daily activities!',
        'barangay' => $barangay
    ], 201);
}


    // No changes needed here! This method already works with the new route.
    public function show(Barangay $barangay)
    {
        // Load barangay with its puroks
        $barangay->load('puroks');

        // Query for the current midwife assigned to this barangay
        $midwife = Midwife::with('user')
            ->where('brgy_id', $barangay->id)
            ->where('status', 'active') // optional filter
            ->first();

        // Add counts (still sample/random for now)
        $barangay->residents_count  = rand(1200, 4500);
        $barangay->households_count = rand(300, 800);
        $barangay->families_count   = rand(350, 950);

        // Assign midwife (will be null if none is found)
        $barangay->assigned_midwife = $midwife ? $midwife->name : null;

        \Log::info('Assigned midwife: ' . ($barangay->assigned_midwife ?? 'None'));

        // Call PurokController to get purok data
        $purokController = new PurokController();
        $puroks = $purokController->getByBarangay($barangay);

        return view('mho.spec-barangay', compact('barangay', 'puroks'));
    }


    public function update(Request $request, Barangay $barangay)
    {
        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('barangays', 'name')->ignore($barangay->id),
            ],
        ]);

        // Update barangay
        $barangay->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'Barangay updated successfully!',
            'barangay' => $barangay
        ]);
    }

    public function deactivate(Request $request, Barangay $barangay)
    {
        $barangay->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'message' => 'Barangay set to inactive successfully.'
        ]);
    }

    
}