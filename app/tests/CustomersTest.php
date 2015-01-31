<?php

class CustomersTest extends ApiTester {

    /** @test */
    public function it_fetches_a_single_product()
    {
        Kplus\Models\User::create([
            'name' => 'Pietje Puk',
            'email' => 'pietje@puk.nl',
            'password' => Hash::make('1234')
        ]);

        $this->postJson('api/v1/customer/login', ['email' => 'pietje@puk.nl', 'password' => '1234'])->data;

        $this->assertResponseOk();
    }

    protected function getStub()
    {
        return;
    }

}
