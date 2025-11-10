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
}
