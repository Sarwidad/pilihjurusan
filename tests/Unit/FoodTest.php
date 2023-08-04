<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateFood()
    {
        $foodData = [
            'name' => 'Rendang',
            'price' => 23000,
            'description' => 'Lorem ipsum dolor amet.',
        ];

        $food = Food::create($foodData);

        $this->assertDatabaseHas('foods', $foodData);
        $this->assertInstanceOf(Food::class, $food);
        $this->assertEquals($foodData['name'], $food->name);
        $this->assertEquals($foodData['price'], $food->price);
        $this->assertEquals($foodData['description'], $food->description);
    }

    public function testUpdateFood()
    {
        $food = Food::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'price' => 25000,
            'description' => 'Updated description.',
        ];

        $food->update($updatedData);

        $this->assertDatabaseHas('foods', $updatedData);
        $this->assertEquals($updatedData['name'], $food->name);
        $this->assertEquals($updatedData['price'], $food->price);
        $this->assertEquals($updatedData['description'], $food->description);
    }

    public function testDeleteFood()
    {
        $food = Food::factory()->create();

        $this->assertTrue($food->delete());
        $this->assertDatabaseMissing('foods', ['id' => $food->id]);
    }
}

