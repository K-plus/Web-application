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

    protected function getStub()
    {
        return;
    }

}
