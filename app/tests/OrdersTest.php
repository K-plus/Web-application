<?php

class OrdersTest extends ApiTester {

    /** @test */
    public function it_deletes_a_product_to_cart()
    {
        Kplus\Models\Product::create([
            'name' => 'Half stokbrood',
            'price' => 120,
            'ean' => '0000000000123',
            'stock' => 45
        ]);

        Kplus\Models\User::create([
            'name' => 'Pietje Puk',
            'email' => 'pietje@puk.nl',
            'password' => Hash::make('1234')
        ]);

        Kplus\Models\Cart::create([
            'user_id' => 1
        ]);

        Kplus\Models\CartLine::create([
            'cart_id' => 1,
            'product_id' => 1,
            'qty' => 5,
        ]);

        Auth::loginUsingId(1);

        $this->postJson('api/v1/order/add' json_encode('{products: [{"id": 1, "quantity": 20}]}') ); // how to add parameters here? needs to have {products: [{"id": 1, "quantity": 20}]}

        $this->assertResponseOk();
    }

    protected function getStub()
    {
        return;
    }

}
