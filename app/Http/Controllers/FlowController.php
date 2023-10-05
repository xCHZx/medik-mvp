<?php

namespace App\Http\Controllers;

use App\Models\Flow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $flows = Flow::where('userId', $user->id)->get();
            return view('dashboard.flow.index', compact('flow', 'user'));
        } catch (Exception $e) {
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.flow.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $flow = new Flow();
            $flow->name = $request->name;
            $flow->description = $request->description;
            $flow->userId = Auth::id();
            $flow->isActivated = false; // Valor inicial apagado
            $flow->save();

            return redirect()->route('flow.index')->with("action", "ok");
        } catch (Exception $e) {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Flow $flow)
    {
        return view('dashboard.flow.show', compact('flow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flow $flow)
    {
        return view('dashboard.flow.edit', compact('flow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flow $flow)
    {
        try {
            $flow->name = $request->name;
            $flow->description = $request->description;
            $flow->save();

            return redirect()->route('flow.index')->with("action", "ok");
        } catch (Exception $e) {
            abort(403);
        }
    }

    // Turn on/off
    public function toggle(Flow $flow)
    {
        try {
            $flow->isActivated = !$flow->isActivated; // Cambiar el estado
            $flow->save();

            return redirect()->route('flow.index')->with("action", "ok");
        } catch (Exception $e) {
            abort(403);
        }
    }
}
