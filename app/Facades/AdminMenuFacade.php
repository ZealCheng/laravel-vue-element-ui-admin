<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class AdminMenuFacade extends Facade
{
    /**
     * @return string
     */
	protected static function getFacadeAccessor(){
		return 'AdminMenu';
	}
}