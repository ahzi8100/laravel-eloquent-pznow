<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find('1');
        self::assertNotNull($product);

        $category = $product->category;
        assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
    }

    public function testHasOneOfMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        assertNotNull($category);

        $cheapestProduct = $category->cheapestProduct;
        assertNotNull($cheapestProduct);
        assertEquals('1', $cheapestProduct->id);

        $mostExpansiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpansiveProduct);
        assertEquals('2', $mostExpansiveProduct->id);
    }
}
