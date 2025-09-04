<?php
// 代码生成时间: 2025-09-04 10:46:45
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

// InventoryItem Model
class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';
    protected $fillable = ['name', 'quantity', 'price'];

    public function scopeActive(Builder $query)
    {
        return $query->where('quantity', '>', 0);
    }
}

// InventoryItemFactory Factory
class InventoryItemFactory extends Factory
{
    protected $model = InventoryItem::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 0, 100),
        ];    }
}

// InventoryItemSeeder Seeder
class InventoryItemSeeder extends Seeder
{
    public function run()
    {
        InventoryItemFactory::new()->count(50)->create();
    }
}

// InventoryController Controller
class InventoryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::active()->get();
        return view('inventory.index', ['items' => $items]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $item = InventoryItem::create($validated);
        return redirect()->route('inventory.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = InventoryItem::findOrFail($id);
        $item->update($validated);
        return redirect()->route('inventory.index');
    }

    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->delete();
        return redirect()->route('inventory.index');
    }
}

// Inventory migration
class CreateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}

// InventoryServiceProvider Service Provider
class InventoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadFactoriesFrom(__DIR__.'/database/factories');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}

// InventoryServiceProvider Facade
class InventoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'inventory';
    }
}

// InventoryServiceProvider Service
class InventoryService
{
    public function addItem($name, $quantity, $price)
    {
        return InventoryItem::create(['name' => $name, 'quantity' => $quantity, 'price' => $price]);
    }

    public function updateItem($id, $quantity)
    {
        $item = InventoryItem::findOrFail($id);
        $item->update(['quantity' => $quantity]);
        return $item;
    }

    public function deleteItem($id)
    {
        $item = InventoryItem::findOrFail($id);
        $item->delete();
        return $item;
    }
}