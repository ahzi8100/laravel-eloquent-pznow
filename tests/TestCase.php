<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from products');
        DB::delete('delete from categories');
        DB::delete('delete from vouchers');
        DB::delete('delete from virtual_accounts');
        DB::delete('delete from wallets');
        DB::delete('delete from customers');
    }
}
