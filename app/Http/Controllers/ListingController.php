<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all
    public function index(){
        return view('listings.index', [
            'heading' => 'Heading Listings',
            'listings'=> Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // Show single Listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing'=> $listing
        ]);
    }
    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){
        $formields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags'=> 'required',
            'description'=> 'required'
        ]);

        if($request->hasFile('logo')) {
            $formields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formields['user_id'] = auth()->id();

        Listing::create($formields);

        return redirect('/')->with('message', 'Listing Created!');
    }

    public function edit(Listing $listing){
        return view('listings.edit', [
            'listing'=> $listing
        ]);
    }

    public function update(Request $request, Listing $listing){
        if($listing -> user_id != auth()->id()){
            abort(403, 'Unauthorized');
        }
        $formields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags'=> 'required',
            'description'=> 'required'
        ]);

        if($request->hasFile('logo')) {
            $formields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formields);

        return back()->with('message', 'Listing Updated!');
    }

    public function destroy(Listing $listing){
        if($listing -> user_id != auth()->id()){
            abort(403, 'Unauthorized');
        }
        $listing->delete();

        return redirect('/')->with('message', 'Listing Deleted!');
    }
    public function manage(){
        return view('listings.manage', ['listings'=> auth()->user()->listings()->get()]);
    }

}
