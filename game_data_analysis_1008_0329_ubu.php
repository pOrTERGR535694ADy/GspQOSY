<?php
// 代码生成时间: 2025-10-08 03:29:21
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameData;
use Exception;

class GameDataAnalysisController extends Controller
{
    /**
     * Display a listing of the game data.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Validate the request parameters
            $validated = $request->validate([
                'game_id' => 'required|integer|exists:games,id',
            ]);

            // Retrieve game data based on the game_id
            $gameData = GameData::where('game_id', $validated['game_id'])->get();

            // Return the game data in JSON format
            return response()->json($gameData);

        } catch (Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['error' => 'Failed to retrieve game data'], 500);
        }
    }

    /**
     * Store a new piece of game data.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request parameters
            $validated = $request->validate([
                'game_id' => 'required|integer|exists:games,id',
                'data' => 'required|array',
            ]);

            // Create a new game data entry
            $gameData = new GameData();
            $gameData->game_id = $validated['game_id'];
            $gameData->data = json_encode($validated['data']);
            $gameData->save();

            // Return the newly created game data entry
            return response()->json($gameData);

        } catch (Exception $e) {
            // Return an error response if something goes wrong
            return response()->json(['error' => 'Failed to store game data'], 500);
        }
    }
}

// Define the Game model
class Game extends Model
{
    protected $fillable = ['name', 'description'];
}

// Define the GameData model
class GameData extends Model
{
    protected $fillable = ['game_id', 'data'];
}
