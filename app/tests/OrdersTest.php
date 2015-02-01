<?php

class OrdersTest extends ApiTester {

    /** @test */
    public function it_adds_an_order()
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

        $data = [
            'products' => [
                [
                    'id' => 1,
                    'quantity' => 20
                ]
            ]
        ];

        $this->postJson('api/v1/order/add', $data);

        $this->assertResponseOk();
    }

    protected function getStub()
    {
        return;
    }

}
