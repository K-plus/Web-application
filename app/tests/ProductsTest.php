<?php

class ProductsTest extends ApiTester {

    /** @test */
    public function it_fetches_a_single_product()
    {
        $this->make('Kplus\Models\Product');

        $product = $this->getJson('api/v1/product/1')->data;

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($product, 'name', 'price', 'ean', 'stock');
    }

    /** @test */
    public function it_searches_a_single_product()
    {
        Kplus\Models\Product::create([
            'name' => 'Half stokbrood',
            'price' => 120,
            'ean' => '0000000000123',
            'stock' => 45
        ]);

        $product = $this->getJson('api/v1/product/search/stokbrood')->data[0];

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($product, 'name', 'price', 'ean', 'stock');
    }

    protected function getStub()
    {
        $name = $this->fake->sentence(2);

        return [
            'name' => substr($name, 0, strlen($name) - 1),
            'price' => $this->fake->randomNumber(4),
            'ean' => $this->fake->ean13,
            'stock' => 10,
        ];
    }

}
