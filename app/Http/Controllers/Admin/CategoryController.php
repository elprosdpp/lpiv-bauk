<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

//use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use \RouterOS\Client;
use RouterOS\Exceptions\BadCredentialsException;
use RouterOS\Exceptions\ClientException;
use RouterOS\Exceptions\ConfigException;
use RouterOS\Exceptions\ConnectException;
use RouterOS\Exceptions\QueryException;
use \RouterOS\Query;


class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:category list', ['only' => ['index', 'show']]);
        $this->middleware('can:category create', ['only' => ['create', 'store']]);
        $this->middleware('can:category edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:category delete', ['only' => ['destroy']]);

    }

    /**
     * @throws ClientException
     * @throws ConnectException
     * @throws QueryException
     * @throws BadCredentialsException
     * @throws ConfigException
     */
    public function index(): Response
    {
//        $client = new Client([
//            'host' => '172.16.0.1',
//            'user' => 'admin',
//            'pass' => 'bptik@unw2023',
//            'port' => 8728,
//        ]);

//        $query =
//            (new Query('/interface/monitor-traffic'))
//                ->equal('interface', 'ether1')
//                ->equal('once');

//        $query = new Query('/system/resource/cpu/print');

        // Send query and read response from RouterOS
//        $response = $client->query($query)->read();
//        response()->json($response);
//        dd($response);

//        dd($response);

        $category = DB::table('categories')->when(Request::input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Category/Index', [
            'category' => $category,
            'filters' => Request::only(['search']),
//            'response' => $response,
            'can' => [
                'create' => Auth::user()->can('category create'),
                'edit' => Auth::user()->can('category edit'),
                'delete' => Auth::user()->can('category delete'),
            ]
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        //Create Model Eloquent
        Category::create($request->validated());

        return to_route('category.index')->with("message", "Data Kategori Berhasil Ditambah");
    }

    public function edit($id): Response
    {
        //Get Data By ID
        $allCategory = Category::all();
        $getCategory = $allCategory->find($id);

        return Inertia::render('Admin/Category/Edit', [
            'getCategory' => $getCategory,
        ]);
    }

    public function update(CategoryRequest $request, $id): RedirectResponse
    {
        //Get Data By ID
        $allCategory = Category::all();
        $getCategory = $allCategory->find($id);

        //Update Data By ID
        $getCategory->update($request->validated());
        return to_route('category.index')->with("message", "Data Kategori Berhasil Diubah");
    }

    public function destroy($id): RedirectResponse
    {
        //Get Data By ID
        $allCategory = Category::all();
        $getCategory = $allCategory->find($id);

        //Delete Category By ID
        $getCategory->delete();
        return back()->with('message', "Data Kategory Berhasil Dihapus");
    }


}
