<?php

class CartsTest extends ApiTester {

    /** @test */
    public function it_fetches_a_cart()
    {
        Kplus\Models\User::create([
            'name' => 'Pietje Puk',
            'email' => 'pietje@puk.nl',
            'password' => Hash::make('1234')
        ]);

        Auth::loginUsingId(1);

        $cart = $this->getJson('api/v1/cart');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_adds_a_product_to_cart()
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

        Auth::loginUsingId(1);

        $this->postJson('api/v1/cart/product/add', ['id' => 1]);

        $this->assertResponseOk();
    }

    /** @test */
    public function it_updates_a_product_to_cart()
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

        $this->postJson('api/v1/cart/product/update', ['id' => 1, 'qty' => 5]);

        $this->assertResponseOk();
    }

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

        $this->postJson('api/v1/cart/product/delete', ['id' => 1]);

        $this->assertResponseOk();
    }

    /** @test */
    public function it_substracts_a_product_to_cart()
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

        $this->postJson('api/v1/cart/product/substract', ['id' => 1, 'qty' => 1]);

        $this->assertResponseOk();
    }

    protected function getStub()
    {
        return;
    }

}
