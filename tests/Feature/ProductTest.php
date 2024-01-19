<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Tests\TestCase;
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
}
