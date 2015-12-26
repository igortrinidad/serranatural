<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use serranatural\Models\Produto;



class ExampleTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {

        $produto = factory(Produto::class)->create();

        $this->visit('/admin/produtos/lista')
             ->see($produto->nome_produto);
    }
}
