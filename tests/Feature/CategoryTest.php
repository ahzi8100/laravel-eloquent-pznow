<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $result = $category->save();

        self::assertTrue($result);
    }

    public function testInsertMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i"
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);

        $total = Category::count();
        self::assertEquals(10, $total);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::find("FOOD");

        self::assertNotNull($category);
        assertEquals('FOOD', $category->id);
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        $category->name = "Food Updated";

        $result = $category->update();
        assertTrue($result);
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i"
            ];
        }

        $result = Category::insert($categories);
        assertTrue($result);

        Category::whereNull('description')->update([
            'description' => 'Updated'
        ]);

        $total = Category::where('description', '=', 'Updated')->count();
        assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        $result = $category->delete();
        assertTrue($result);

        $total = Category::count();
        assertEquals(0, $total);
    }

    public function testCreate()
    {
        $request = [
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food Category'
        ];

        $category = new Category($request);
        $category->save();

        self::assertNotNull($category->id);

    }

    public function testGlobalScope()
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "Food";
        $category->description = "Food Category";
        $category->is_active = false;
        $category->save();

        $category = Category::find("FOOD");
        self::assertNull($category);

        $category = Category::withoutGlobalScopes([IsActiveScope::class])->find("FOOD");
        assertNotNull($category);
    }

    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        assertNotNull($category);

        $product = $category->products;
        self::assertNotNull($product);
        self::assertCount(1, $product);
    }


}
