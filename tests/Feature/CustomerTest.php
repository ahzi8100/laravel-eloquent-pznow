<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\VirtualAccount;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::find('EKO');
        self::assertNotNull($customer);

        $wallet = $customer->wallet;
        self::assertNotNull($wallet);
        self::assertEquals(1000000, $wallet->amount);
    }

    public function testHasOneThrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::find('EKO');
        assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        self::assertNotNull($virtualAccount);
        self::assertEquals("BCA",$virtualAccount->bank);
    }
}
