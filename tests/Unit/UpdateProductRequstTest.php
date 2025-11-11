<?php

namespace Tests\Unit;

use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateProductRequstTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'description' => 'hello world',
            'price' => 1000,
            'stock' => 10,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->passes());
    }

    public function test_name_is_required()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'description' => 'hello world',
            'price' => 1000,
            'stock' => 10,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_price_is_required()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'description' => 'hello world',
            'stock' => 10,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    public function test_stock_is_required()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'description' => 'hello world',
            'price' => 1000,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('stock', $validator->errors()->toArray());
    }

    public function test_is_published_is_required()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'description' => 'hello world',
            'price'=> 1000,
            'stock' => 10,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('is_published', $validator->errors()->toArray());
    }

    public function test_name_must_not_be_exceed_255_characters()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => str_repeat('a', 256),
            'price'=> 1000,
            'stock' => 10,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }

    public function test_price_must_be_integer()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'price'=> 'not_number',
            'stock' => 10,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    public function test_stock_must_be_integer()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'price'=> 1000,
            'stock' => 'not_number',
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('stock', $validator->errors()->toArray());
    }

    public function test_is_published_must_be_boolean()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'price'=> 1000,
            'stock' => 10,
            'is_published' => 'not_boolean',
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('is_published', $validator->errors()->toArray());
    }

    public function test_price_must_not_be_negative()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'price'=> -1,
            'stock' => 10,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    public function test_price_can_be_zero()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'price'=> 0,
            'stock' => 10,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_stock_must_not_be_negative()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'price'=> 1000,
            'stock' => -1,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('stock', $validator->errors()->toArray());
    }

    public function test_stock_can_be_zero()
    {
        $request = new UpdateProductRequest();

        $validData = [
            'name' => 'test name',
            'price'=> 1000,
            'stock' => 0,
            'is_published' => true,
        ];

        $validator = Validator::make($validData, $request->rules());

        $this->assertFalse($validator->fails());
    }
}
