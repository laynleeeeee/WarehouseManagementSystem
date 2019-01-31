<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Loctation;
use Illuminate\Http\Request;

class LoctationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $loctation = Loctation::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $loctation = Loctation::latest()->paginate($perPage);
        }

        return view('admin.loctation.index', compact('loctation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.loctation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'category_name' => 'required'
		]);
        $requestData = $request->all();
        
        Loctation::create($requestData);

        return redirect('admin/loctation')->with('flash_message', 'Loctation added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $loctation = Loctation::findOrFail($id);

        return view('admin.loctation.show', compact('loctation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $loctation = Loctation::findOrFail($id);

        return view('admin.loctation.edit', compact('loctation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'category_name' => 'required'
		]);
        $requestData = $request->all();
        
        $loctation = Loctation::findOrFail($id);
        $loctation->update($requestData);

        return redirect('admin/loctation')->with('flash_message', 'Loctation updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Loctation::destroy($id);

        return redirect('admin/loctation')->with('flash_message', 'Loctation deleted!');
    }
}
