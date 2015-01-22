<?php

class ProductsTest extends ApiTester {

    /** @test */
	public function it_fetches_products()
    {
        $this->make('Product');

        $this->getJson('api/v1/products');

        $this->assertResponseOk();

    }

    /** @test */
    public function it_fetches_a_single_product()
    {
        $this->make('Product');

        $product = $this->getJson('api/v1/products/1')->data;

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($product, 'name', 'price', 'ean');

    }

    protected function getStub()
    {
        $name = $this->fake->sentence(2);

        return [
            'name' => substr($name, 0, strlen($name) - 1),
            'price' => $this->fake->randomNumber(4),
            'ean' => $this->fake->ean13
        ];
    }

}
