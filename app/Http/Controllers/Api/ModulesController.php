<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModulesRequest;
use App\Http\Requests\UpdateModulesRequest;
use App\Models\Modules;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ModulesController extends Controller
{
    public function index()
    {
        return response()->json(Modules::all(), 200);
    }

    public function activate($id)
    {
        $user = auth()->user();
        $module = Modules::find($id);

        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }
       $user->modules()->syncWithoutDetaching([
            $module->id => ['active' => true]
        ]);

        return response()->json(['message' => 'Module activated'], 200);
    }

    public function deactivate($id)
    {
        $user = auth()->user();
        $module = Modules::find($id);

        if (!$module) {
            return response()->json(['error' => 'Module not found'], 404);
        }

        $user->modules()->updateExistingPivot($module->id, ['active' => false]);

        return response()->json(['message' => 'Module deactivated'], 200);
    }
}

